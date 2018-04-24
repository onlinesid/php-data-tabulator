<?php

namespace OnlineSid\DataTabulator\Tests;

use OnlineSid\DataTabulator\DataTabulator;
use \PHPUnit_Framework_TestCase;

class DataTabulatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Testing a simple scenario
     */
    function test1()
    {
        parent::setUp();

        $rows = [
            ['id' => 7, 'u_id' => 1, 'u_name' => 'Joan', 'a_id' => 'PK', 'a_name' => 'Packing', 'num' => 10.5, ],
            ['id' => 4, 'u_id' => 1, 'u_name' => 'Joan', 'a_id' => 'PK', 'a_name' => 'Packing', 'num' =>  0.5, ],
            ['id' => 2, 'u_id' => 1, 'u_name' => 'Joan', 'a_id' => 'DR', 'a_name' => 'Driving', 'num' =>  2.3, ],
            ['id' => 5, 'u_id' => 2, 'u_name' => 'Robb', 'a_id' => 'DR', 'a_name' => 'Driving', 'num' =>  8.7, ],
        ];
        $tabulator = new DataTabulator($rows);

        $table = $tabulator->to2DTable('Name', 'u_id', 'u_name', 'a_id', 'a_name', 'num');

        // Expected result ($table) is something like:
        //
        //    Name       Packing (PK)     Driving (DR)
        //    Joan (1)          11               2.3
        //    Robb (2)           0               8.7

        $this->assertEquals(3, $table->getNbRows());
        $this->assertEquals(3, $table->getNbColumns());

        $this->assertEquals(11  , $table->getAggregateValue(1, 'PK'));
        $this->assertEquals( 2.3, $table->getAggregateValue(1, 'DR'));
        $this->assertEquals( 0  , $table->getAggregateValue(2, 'PK'));
        $this->assertEquals( 8.7, $table->getAggregateValue(2, 'DR'));

        $this->assertEquals( 'Name', $table->getColumnLabel(0));
        $this->assertEquals( 'Packing', $table->getColumnLabel(1));
        $this->assertEquals( 'Driving', $table->getColumnLabel(2));

        $this->assertEquals( 'Name', $table->getRowLabel(0));
        $this->assertEquals( 'Joan', $table->getRowLabel(1));
        $this->assertEquals( 'Robb', $table->getRowLabel(2));
    }
}