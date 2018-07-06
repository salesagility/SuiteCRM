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

        $where = [];
        foreach ($params as $field => $expr) {
            if (!property_exists($bean, $field)) {
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
                    $bean->getTableName(),
                    $field,
                    constant(sprintf('%s::OP_%s', self::class, strtoupper($op))),
                    $this->db->quoted($value)
                );
            }
        }

        return implode(sprintf(' %s ', $operator), $where);
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
