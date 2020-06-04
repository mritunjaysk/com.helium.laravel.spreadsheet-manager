<?php

namespace Helium\SpreadsheetManager;
use Helium\SpreadsheetManager\Classes\Parser;
use Orchestra\Testbench\TestCase;

class ParserTest extends TestCase
{
    private $_testHeader = ['Col 1', 'Col 2', 'Col 3'];

    private $_testData = [
        ["data1", 'data2', 'data3'],
        ["data4", 'data5', 'data6']
    ];

    public function testParseCsv()
    {
        $csv = Maker::makeCsv($this->_testHeader, $this->_testData, null);
    }
}