<?php

namespace Tests\Hints\Component;


use Hints\Component\ReadSomeFileLines;

class ReadSomeFileLinesTest extends \PHPUnit_Framework_TestCase
{
    const ANY_NUMBER_OF_LINES = 1;

    const FILE_PATH = '/../Resources/test.txt';
    /** @var  ReadSomeFileLines */
    private $readSomeFileLines;

    public function setUp()
    {
        parent::setUp();

        $this->readSomeFileLines = new ReadSomeFileLines(__DIR__.self::FILE_PATH);

    }

    public function testReadSomeLinesThatExists(){

        $lines = $this->readSomeFileLines->findLinesOn(3, self::ANY_NUMBER_OF_LINES);

        $this->assertNotEmpty($lines);
        $this->assertEquals(3, count($lines));
        $this->assertEquals('line 2', $lines[0]);
        $this->assertEquals('line 3', $lines[1]);
        $this->assertEquals('line 4', $lines[2]);

    }

    /**
     * @expectedException \Hints\Exception\LineDoesNotExistsException
     * @throws \Hints\Exception\LineDoesNotExistsException
     */
    public function testWhenLineIs0ShouldNotExists(){
         $this->readSomeFileLines->findLinesOn(0, self::ANY_NUMBER_OF_LINES);
    }

    public function testReadMoreLinesThanLowerLimit(){

        $lines = $this->readSomeFileLines->findLinesOn(2, 3);

        $this->assertNotEmpty($lines);
        $this->assertEquals(5, count($lines));
        $this->assertEquals('line 1', $lines[0]);
        $this->assertEquals('line 2', $lines[1]);
        $this->assertEquals('line 3', $lines[2]);
        $this->assertEquals('line 4', $lines[3]);
        $this->assertEquals('line 5', $lines[4]);

    }

    public function testReadMoreLinesThanUpperLimit(){

        $lines = $this->readSomeFileLines->findLinesOn(5, 3);

        $this->assertNotEmpty($lines);
        $this->assertEquals(7, count($lines));
        $this->assertEquals('line 2', $lines[0]);
        $this->assertEquals('line 3', $lines[1]);
        $this->assertEquals('line 4', $lines[2]);
        $this->assertEquals('line 5', $lines[3]);
        $this->assertEquals('line 6', $lines[4]);
        $this->assertEquals('', $lines[5]);
        $this->assertEquals('', $lines[6]);

    }


    public function testReadOfLineRange(){

        $lines = $this->readSomeFileLines->findLinesOn(10, 1);

        $this->assertNotEmpty($lines);
        $this->assertEquals(3, count($lines));
        $this->assertEquals('', $lines[0]);
        $this->assertEquals('', $lines[1]);
        $this->assertEquals('', $lines[2]);

    }
}