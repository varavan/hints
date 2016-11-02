<?php

namespace Tests\Hints\Factory;

use Hints\Factory\FileCommentDtoFactory;
use Hints\Factory\HintDtoFactory;
use Hints\Model\Dto\FileComment;

class HintDtoFactoryTest extends \PHPUnit_Framework_TestCase
{
    const ANY_CONTENT = 'any content';
    const ANY_AUTHOR = 'jowi';
    const ANY_TAG = 'tag text';
    const ANY_TAG_2 = 'tag text 2';
    const ANY_FILE_PATH = 'any_file_path';
    const ANY_FILE_LINE = '34';

    /** @var  FileCommentDtoFactory | \PHPUnit_Framework_MockObject_MockObject */
    private $fileCommentDtoFactory;
    /** @var  HintDtoFactory */
    private $hintDtoFactory;

    public function setUp()
    {
        parent::setUp();

        $this->fileCommentDtoFactory = $this->createMock(FileCommentDtoFactory::class);

        $this->hintDtoFactory = new HintDtoFactory($this->fileCommentDtoFactory);

    }

    public function testContentIsSetUp(){

        $hintDto = $this->hintDtoFactory->make(self::ANY_CONTENT);

        $this->assertEquals(self::ANY_CONTENT, $hintDto->content);
    }

    public function testAuthorIsSetUp(){

        $hintDto = $this->hintDtoFactory->make(self::ANY_CONTENT, self::ANY_AUTHOR);


        $this->assertEquals(self::ANY_AUTHOR, $hintDto->author);
    }

    public function testTagsAreSetUp(){

        $hintDto = $this->hintDtoFactory->make(self::ANY_CONTENT, null, [self::ANY_TAG, self::ANY_TAG_2]);

        $this->assertEquals(self::ANY_TAG, $hintDto->tags[0]->name);
        $this->assertEquals(self::ANY_TAG_2, $hintDto->tags[1]->name);
    }

    public function testFileCommentIsSetUp(){
        $this->fileCommentDtoFactoryWillReturnObject();

        $hintDto = $this->hintDtoFactory->make(self::ANY_CONTENT, null, null, self::ANY_FILE_PATH, self::ANY_FILE_LINE);

        $this->assertEquals(self::ANY_FILE_PATH, $hintDto->fileComment->path);
        $this->assertEquals(self::ANY_FILE_LINE, $hintDto->fileComment->line);

    }

    private function fileCommentDtoFactoryWillReturnObject(){
        $fileComment = new FileComment();
        $fileComment->path = self::ANY_FILE_PATH;
        $fileComment->line = self::ANY_FILE_LINE;

        $this->fileCommentDtoFactory
            ->method('make')
            ->with(self::ANY_FILE_PATH, self::ANY_FILE_LINE)
            ->willReturn($fileComment);
    }
}