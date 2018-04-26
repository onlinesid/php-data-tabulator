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
     * Returns aggregate value, given row index and column index (they are NOT row ID and col ID!!!)
     *
     * @param int $r row index, starts from 1 because 0 is the row label
     * @param int $c col index, starts from 1 because 0 is the col label
     * @return mixed
     */
    public function getAggregateValueFromRowCol($r, $c)
    {
        $columns = array_keys($this->unique_columns);
        $rows    = array_keys($this->unique_rows);

        return $this->getAggregateValue($rows[$r-1], $columns[$c-1]);
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

    /**
     * @param bool $include_headers
     * @return array
     */
    public function toArray($include_headers)
    {
        $arr = [];

        // headers
        if ($include_headers) {
            $row = [];
            for ($c=0; $c < $this->getNbColumns(); $c++) {
                $row[] = $this->getColumnLabel($c);
            }
            $arr[] = $row;
        }

        for ($r=0; $r < $this->getNbRows(); $r++) {
            $row = [$this->getRowLabel($r)];
            for ($c=0; $c < $this->getNbColumns(); $c++) {

            }
        }

        return $arr;
    }
}