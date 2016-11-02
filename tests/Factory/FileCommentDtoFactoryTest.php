<?php

namespace Tests\Hints\Factory;


use Hints\Factory\FileCommentDtoFactory;
use Hints\Component\BuildAbsoluteFilePath;
use Hints\Exception\FileNotFoundException;

class FileCommentDtoFactoryTest extends \PHPUnit_Framework_TestCase
{
    const FILE_PATH_DOES_NOT_EXIST = 'any';
    const FILE_PATH_DOES_EXISTS = 'tests/Resources/test.txt';
    const ANY_LINE = 3;

    /**
     * @var FileCommentDtoFactory
     */
    private $fileCommentDtoFactory;
    /** @var  BuildAbsoluteFilePath | \PHPUnit_Framework_MockObject_MockObject */
    private $buildAbsoluteFilePath;

    public function setUp()
    {
        parent::setUp();

        $this->buildAbsoluteFilePath = $this->createMock(BuildAbsoluteFilePath::class);

        $this->fileCommentDtoFactory = new FileCommentDtoFactory($this->buildAbsoluteFilePath);
    }


    /**
     * @expectedException \Hints\Exception\FileNotFoundException
     */
    public function testFileNotFoundExceptionIsThrownOnUnexistentFile(){
        $this->buildPathWillNotFoundFile();
        $this->fileCommentDtoFactory->make(self::FILE_PATH_DOES_NOT_EXIST);
    }

    public function testBootDtoOnFileExists(){
        $fileCommentDto = $this->fileCommentDtoFactory->make(self::FILE_PATH_DOES_EXISTS);

        $this->assertEquals(self::FILE_PATH_DOES_EXISTS, $fileCommentDto->path);
    }

    public function testLineIsSetUp(){
        $fileCommentDto = $this->fileCommentDtoFactory->make(self::FILE_PATH_DOES_EXISTS, self::ANY_LINE);
        $this->assertEquals(self::ANY_LINE, $fileCommentDto->line);
    }

    private function buildPathWillNotFoundFile(){
        $this->buildAbsoluteFilePath->method('build')->willThrowException(new FileNotFoundException(self::FILE_PATH_DOES_NOT_EXIST));
    }

}