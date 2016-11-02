<?php

namespace Tests\Hints\Component;


use Hints\Component\BuildAbsoluteFilePath;

class BuildAbsoluteFilePathTest extends \PHPUnit_Framework_TestCase
{
    const RELATIVE_PROJECT_PATH = '/';
    const FILE_PATH_DOES_NOT_EXIST = 'any';
    const FILE_PATH_DOES_EXISTS = 'tests/Resources/test.txt';

    /** @var  BuildAbsoluteFilePath */
    private $buildAbsoluteFilePath;

    public function setUp()
    {
        parent::setUp();

        $this->buildAbsoluteFilePath = new BuildAbsoluteFilePath(self::RELATIVE_PROJECT_PATH);
    }

    /**
     * @expectedException \Hints\Exception\FileNotFoundException
     */
    public function testFileNotFoundExceptionIsThrownOnUnexistentFile(){
        $this->buildAbsoluteFilePath->build(self::FILE_PATH_DOES_NOT_EXIST);
    }

    public function testBootDtoOnFileExists(){
        $absolutePath = $this->buildAbsoluteFilePath->build(self::FILE_PATH_DOES_EXISTS);

        $this->assertTrue(file_exists($absolutePath));
    }
}