<?php

namespace Consolidation\OutputFormatters\Transformations;

use Consolidation\OutputFormatters\StructuredData\TableDataInterface;
use Consolidation\OutputFormatters\StructuredData\OriginalDataInterface;
use Consolidation\OutputFormatters\StructuredData\MetadataHolderInterface;
use Consolidation\OutputFormatters\Options\FormatterOptions;
use Consolidation\OutputFormatters\Formatters\TsvFormatter;
use Symfony\Component\Console\Output\BufferedOutput;

class TableTransformation extends \ArrayObject implements TableDataInterface, StringTransformationInterface, OriginalDataInterface
{
    protected $headers;
    protected $rowLabels;
    protected $layout;
    /** @var MetadataHolderInterface */
    protected $originalData;

    const TABLE_LAYOUT = 'table';
    const LIST_LAYOUT = 'list';

    public function __construct($data, $fieldLabels, $rowLabels = [])
    {
        $this->headers = $fieldLabels;
        $this->rowLabels = $rowLabels;
        $rows = static::transformRows($data, $fieldLabels);
        $this->layout = self::TABLE_LAYOUT;
        parent::__construct($rows);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function isList()
    {
        return $this->layout == self::LIST_LAYOUT;
    }

    /**
     * @inheritdoc
     */
    public function simplifyToString(FormatterOptions $options)
    {
        $alternateFormatter = new TsvFormatter();
        $output = new BufferedOutput();

        try {
            $data = $alternateFormatter->validate($this->getArrayCopy());
            $alternateFormatter->write($output, $this->getArrayCopy(), $options);
        } catch (\Exception $e) {
        }
        return $output->fetch();
    }

    protected static function transformRows($data, $fieldLabels)
    {
        $rows = [];
        foreach ($data as $rowid => $row) {
            $rows[$rowid] = static::transformRow($row, $fieldLabels);
        }
        return $rows;
    }

    protected static function transformRow($row, $fieldLabels)
    {
        $result = [];
        foreach ($fieldLabels as $key => $label) {
            $result[$key] = array_key_exists($key, $row) ? $row[$key] : '';
        }
        return $result;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($key)
    {
        if (array_key_exists($key, $this->headers)) {
            return $this->headers[$key];
        }
        return $key;
    }

    public function getRowLabels()
    {
        return $this->rowLabels;
    }

    public function getRowLabel($rowid)
    {
        if (array_key_exists($rowid, $this->rowLabels)) {
            return $this->rowLabels[$rowid];
        }
        return $rowid;
    }

    public function getOriginalData()
    {
        if (isset($this->originalData)) {
            return $this->originalData->reconstruct($this->getArrayCopy(), $this->originalData->getMetadata());
        }
        return $this->getArrayCopy();
    }

    public function setOriginalData(MetadataHolderInterface $data)
    {
        $this->originalData = $data;
    }

    public function getTableData($includeRowKey = false)
    {
        $data = $this->getArrayCopy();
        if ($this->isList()) {
            $data = $this->convertTableToList();
        }
        if ($includeRowKey) {
            $data = $this->getRowDataWithKey($data);
        }
        return $data;
    }

    protected function convertTableToList()
    {
        $result = [];
        foreach ($this as $row) {
            foreach ($row as $key => $value) {
                $result[$key][] = $value;
            }
        }
        return $result;
    }

    protected function getRowDataWithKey($data)
    {
        $result = [];
        $i = 0;
        foreach ($data as $key => $row) {
            array_unshift($row, $this->getHeader($key));
            $i++;
            $result[$key] = $row;
        }
        return $result;
    }
}
