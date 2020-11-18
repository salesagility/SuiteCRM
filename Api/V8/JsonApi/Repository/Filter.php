<?php
namespace Api\V8\JsonApi\Repository;

class Filter
{
    // operators so far
    const OP_EQ = '=';
    const OP_NEQ = '<>';
    const OP_GT = '>';
    const OP_GTE = '>=';
    const OP_LT = '<';
    const OP_LTE = '<=';

    const OP_AND = 'AND';
    const OP_OR = 'OR';

    /**
     * @var \DBManager
     */
    private $db;

    /**
     * @param \DBManager $db
     */
    public function __construct(\DBManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param \SugarBean $bean
     * @param array $params
     *
     * @return string
     * @throws \InvalidArgumentException When field is not found or is not an array.
     */
    public function parseWhere(\SugarBean $bean, array $params)
    {
        $operator = self::OP_AND;
        if (isset($params['operator'])) {
            $this->checkOperator($params['operator']);
            $operator = strtoupper($params['operator']);
            unset($params['operator']);
        }

        $params = $this->addDeletedParameter($params);

        $where = [];
        foreach ($params as $field => $expr) {
            $tableName = "";
            if (array_key_exists($field, $bean->field_name_map) && !empty($bean->field_name_map[$field]))
            {
              if (array_key_exists("source", $bean->field_name_map[$field]) && $bean->field_name_map[$field]["source"] == "custom_fields") $tableName = $bean->getTableName() . "_cstm";
              else if (!empty($bean->field_defs[$field])) $tableName = $bean->getTableName();
              else {
                throw new \InvalidArgumentException(sprintf(
                    'Filter field %s in %s module is not found',
                    $field,
                    $bean->getObjectName()
                ));
              }
            } else {
                throw new \InvalidArgumentException(sprintf(
                    'Filter field %s in %s module is not found',
                    $field,
                    $bean->getObjectName()
                ));
            }

            if (!is_array($expr)) {
                throw new \InvalidArgumentException(sprintf('Filter field %s must be an array', $field));
            }

            foreach ($expr as $op => $value) {
                $this->checkOperator($op);
                $where[] = sprintf(
                    '%s.%s %s %s',
                    $tableName,
                    $field,
                    constant(sprintf('%s::OP_%s', self::class, strtoupper($op))),
                    $this->db->quoted($value)
                );
            }
        }

        return implode(sprintf(' %s ', $operator), $where);
    }

    /**
     * Only return deleted records if they were explicitly requested
     *
     * @param array $params
     * @return array
     */
    protected function addDeletedParameter(array $params)
    {
        if (!array_key_exists('deleted', $params)) {
            $params['deleted'] = [
                'eq' => 0
            ];
        }

        return $params;
    }

    /**
     * @param string $op
     *
     * @throws \InvalidArgumentException When the given operator is invalid.
     */
    private function checkOperator($op)
    {
        $operator = sprintf('%s::OP_%s', self::class, strtoupper($op));
        if (!defined($operator)) {
            throw new \InvalidArgumentException(
                sprintf('Filter operator %s is invalid', $op)
            );
        }
    }
}
