<?php

namespace Hints\Component;


class HintsFileStore
{
    const FILENAME = 'hints.json';

    private $store;

    public function __construct()
    {

        if(!file_exists(self::FILENAME)){
            $this->createFile();
        }

        $this->store = $this->buildStoreFromFile();

    }

    private function buildStoreFromFile(){
        return json_decode(file_get_contents(self::FILENAME), JSON_OBJECT_AS_ARRAY);
    }

    public function getAllHints(){
        return $this->store;
    }

    public function addArrayToFile($row){

        $store = $this->buildStoreFromFile();

        $store[] = $row;

        $this->storeArrayOnFile($store);

        $this->store = $store;

    }

    private function createFile(){
        $initArray = [];

        file_put_contents(self::FILENAME, json_encode($initArray));

    }

    private function storeArrayOnFile($array){
        file_put_contents(self::FILENAME, json_encode($array, JSON_PRETTY_PRINT));
    }
}
