<?php

use Kregel\Ziptastic\Ziptastic;

class ZiptasticTest extends PHPUnit_Framework_TestCase
{
    protected $key = '123';

    public function testZiptastic()
    {
        $results = (new Ziptastic(23042, 'us'))->setKey($this->key);
    }
}
