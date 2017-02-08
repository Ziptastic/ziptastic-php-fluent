<?php

use Ziptastic\Guzzle\Zipper;

class ZipperTest extends PHPUnit_Framework_TestCase
{
    protected $key = '123';

    public function testZipper()
    {
        $zipper = (new Zipper())->in('US')->withPostalCode(48867)->andWithKey($this->key);
    }
}
