<?php

namespace Helium\SpreadsheetManager;
use Helium\SpreadsheetManager\Classes\Maker;
use Orchestra\Testbench\TestCase;

class MakerTest extends TestCase
{
    private $_testHeader = ['Col 1', 'Col 2', 'Col 3'];

    private $_testData = [
        ["data1", 'data2', 'data3'],
        ["data4", 'data5', 'data6']
    ];

    public function testMakeXls()
    {
        $excelFile = Maker::makeXls($this->_testHeader, $this->_testData, null);
        $this->assertFileExists($excelFile);
        $this->assertEquals('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', mime_content_type($excelFile));
    }

    public function testMakeCsv()
    {
        $excelFile = Maker::makeCsv($this->_testHeader, $this->_testData, null);
        $this->assertFileExists($excelFile);
        $this->assertEquals('text/plain', mime_content_type($excelFile));
    }
}