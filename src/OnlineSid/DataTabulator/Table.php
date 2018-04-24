<?php

namespace OnlineSid\DataTabulator;

class Table
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $unique_rows;

    /**
     * @var
     */
    private $unique_columns;

    /**
     * @var int
     */
    private $nb_columns = 0;

    /**
     * @var int
     */
    private $nb_rows = 0;

    /**
     * Table constructor.
     * @param array $data
     * @param array $unique_rows
     * @param array $unique_columns
     */
    public function __construct(array $data, $unique_rows, $unique_columns)
    {
        $this->data = $data;
        $this->unique_columns = $unique_columns;
        $this->unique_rows = $unique_rows;

        if (count($data) > 0) {
            $this->nb_rows = count($data);
            $this->nb_columns = count(array_keys($this->data[0]));
        }
    }

    /**
     * @return int
     */
    public function getNbColumns() {
        return $this->nb_columns;
    }

    /**
     * @return int
     */
    public function getNbRows() {
        return $this->nb_rows;
    }

    /**
     * @param mixed $row_id
     * @param mixed $col_id
     * @return mixed
     */
    public function getAggregateValue($row_id, $col_id)
    {
        $data = $this->data;

        // find the col id
        $c = 0;
        foreach ($this->unique_columns as $col) {
            if ($col_id == $col['id']) {
                break;
            }
            $c++;
        }

        foreach ($data as $row)
        {
            if ($row[0] == $row_id) {
                return $row[$c+1];
            }
        }
    }

    /**
     * @param int $index
     * @return string
     */
    public function getColumnLabel($index)
    {
        if ($index == 0) return $this->data[0][0];

        $keys = array_keys($this->unique_columns);

        return $this->unique_columns[$keys[$index-1]]['name'];
    }

    /**
     * @param int $index
     * @return string
     */
    public function getRowLabel($index)
    {
        if ($index == 0) return $this->data[0][0];

        $keys = array_keys($this->unique_rows);

        return $this->unique_rows[$keys[$index-1]]['name'];
    }

}