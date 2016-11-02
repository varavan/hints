<?php

namespace Tests\Hints\Repository;

use Hints\Component\HintReader;
use Hints\Component\HintWriter;
use Hints\Model\Dto\FileComment;
use Hints\Model\Dto\Hint;
use Hints\Model\Dto\Tag;
use Hints\Repository\HintRepository;
use Tests\Hints\Mother\HintMother;

class HintRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HintWriter | \PHPUnit_Framework_MockObject_MockObject
     */
    private $hintWriter;

    /**
     * @var HintReader | \PHPUnit_Framework_MockObject_MockObject
     */
    private $hintReader;

    /**
     * @var HintRepository
     */
    private $hintRepository;
    /**
     * @var HintMother
     */
    private $hintMother;

    public function setUp()
    {
        parent::setUp();

        $this->hintWriter = $this->createMock(HintWriter::class);
        $this->hintReader = $this->createMock(HintReader::class);

        $this->hintRepository = new HintRepository($this->hintWriter, $this->hintReader);

        $this->hintMother = new HintMother();
    }


    public function testAll(){

        // Given
        $hints = $this->hintReaderWillReturnHint();

        // When
        $allHints = $this->hintRepository->all();

        // Then
        $this->assertEquals($hints, $allHints);

    }

    public function testFindByTag(){
        // Given
        $hints = $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByTag = $this->hintRepository->byTag(HintMother::ANY_TAG_NAME);
        $hintsFilteredByTagWithFindByMethod = $this->hintRepository->findBy([HintRepository::TAG_CONDITION_NAME => HintMother::ANY_TAG_NAME]);

        // Then
        $this->assertEquals($hints, $hintsFilteredByTag);
        $this->assertEquals($hints, $hintsFilteredByTagWithFindByMethod);
    }

    public function testFindNothingByTag(){
        // Given
        $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByTag = $this->hintRepository->byTag(HintMother::ANY_TAG_NAME.'fake');
        $hintsFilteredByTagWithFindByMethod = $this->hintRepository->findBy([HintRepository::TAG_CONDITION_NAME => HintMother::ANY_TAG_NAME.'fake']);


        // Then
        $this->assertEmpty($hintsFilteredByTag);
        $this->assertEmpty($hintsFilteredByTagWithFindByMethod);
    }

    public function testFindByAuthor(){
        // Given
        $hints = $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByAuthor = $this->hintRepository->byAuthor(HintMother::ANY_AUTHOR);
        $hintsFilteredByAuthorWithFindByMethod = $this->hintRepository->findBy([HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR]);

        // Then
        $this->assertEquals($hints, $hintsFilteredByAuthor);
        $this->assertEquals($hints, $hintsFilteredByAuthorWithFindByMethod);
    }

    public function testFindNothingByAuthor(){
        // Given
        $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByAuthor = $this->hintRepository->byAuthor(HintMother::ANY_AUTHOR.'fake');
        $hintsFilteredByAuthorWithFindByMethod = $this->hintRepository->findBy([HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR.'fake']);


        // Then
        $this->assertEmpty($hintsFilteredByAuthor);
        $this->assertEmpty($hintsFilteredByAuthorWithFindByMethod);
    }

    public function testFindByFilePath(){
        // Given
        $hints = $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByFilePath = $this->hintRepository->byFilePath(HintMother::ANY_FILE_PATH);
        $hintsFilteredByFilePathWithFindByMethod = $this->hintRepository->findBy([HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH]);


        // Then
        $this->assertEquals($hints, $hintsFilteredByFilePath);
        $this->assertEquals($hints, $hintsFilteredByFilePathWithFindByMethod);
    }

    public function testFindNothingByFilePath(){
        // Given
        $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByFilePath = $this->hintRepository->byFilePath(HintMother::ANY_FILE_PATH.'fake');
        $hintsFilteredByFilePathWithFindByMethod = $this->hintRepository->findBy([HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH.'fake']);


        // Then
        $this->assertEmpty($hintsFilteredByFilePath);
        $this->assertEmpty($hintsFilteredByFilePathWithFindByMethod);
    }


    public function testByWithArrayOfAuthorAndFile(){
        // Given
        $hints = $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByAuthorAndFile = $this->hintRepository->findBy([HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR, HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH]);

        // Then
        $this->assertEquals($hints, $hintsFilteredByAuthorAndFile);
    }

    public function testByWithArrayOfAuthorNotExists(){
        // Given
        $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByAuthorAndFile = $this->hintRepository->findBy([HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR, HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH.'fake']);
        $hintsFilteredByAuthorAndFile_2 = $this->hintRepository->findBy([HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR.'fake', HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH]);

        // Then
        $this->assertEmpty($hintsFilteredByAuthorAndFile);;
        $this->assertEmpty($hintsFilteredByAuthorAndFile_2);;
    }

    public function testByWithArrayOfAuthorFileAndTag(){
        // Given
        $hints = $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByAuthorFileAndTag = $this->hintRepository->findBy(
            [
                HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR,
                HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH,
                HintRepository::TAG_CONDITION_NAME => HintMother::ANY_TAG_NAME
            ]
        );

        // Then
        $this->assertEquals($hints, $hintsFilteredByAuthorFileAndTag);
    }

    public function testByWithArrayOfAuthorFileAndTagNotExists(){
        // Given
        $this->hintReaderWillReturnHint();

        // When

        $hintsFilteredByAuthorFileAndTag = $this->hintRepository->findBy(
            [
                HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR.'fake',
                HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH,
                HintRepository::TAG_CONDITION_NAME => HintMother::ANY_TAG_NAME
            ]
        );

        $hintsFilteredByAuthorFileAndTag_2 = $this->hintRepository->findBy(
            [
                HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR,
                HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH.'fake',
                HintRepository::TAG_CONDITION_NAME => HintMother::ANY_TAG_NAME
            ]
        );

        $hintsFilteredByAuthorFileAndTag_3 = $this->hintRepository->findBy(
            [
                HintRepository::AUTHOR_CONDITION_NAME => HintMother::ANY_AUTHOR,
                HintRepository::FILE_PATH_CONDITION_NAME => HintMother::ANY_FILE_PATH,
                HintRepository::TAG_CONDITION_NAME => HintMother::ANY_TAG_NAME.'fake'
            ]
        );

        // Then
        $this->assertEmpty($hintsFilteredByAuthorFileAndTag);;
        $this->assertEmpty($hintsFilteredByAuthorFileAndTag_2);;
        $this->assertEmpty($hintsFilteredByAuthorFileAndTag_3);;
    }

    public function testFindAllIfWithEmptyArrayFindBy(){
        // Given
        $hints = $this->hintReaderWillReturnHint();

        // When
        $hintsFilteredByNothing= $this->hintRepository->findBy([]);

        // Then
        $this->assertEquals($hints, $hintsFilteredByNothing);

    }

    /**
     * @return array
     */
    private function hintReaderWillReturnHint()
    {
        $hints = [$this->hintMother->makeHint()];
        $this->hintReader->method('getAll')->willReturn($hints);
        return $hints;
    }


}