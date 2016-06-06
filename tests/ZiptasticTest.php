<?php

use Kregel\Ziptastic\Ziptastic;

class ZiptasticTest extends PHPUnit_Framework_TestCase
{
    protected $key = '';

    public function testZipper()
    {
        $results = (new Ziptastic(23042, 'us'))->setKey($this->key)->find();
    }
}
