<?php

use Kregel\Ziptastic\Zipper;
class ZipperTest extends PHPUnit_Framework_TestCase
{
    protected $key = '';
    public function testZipper()
    {
        $zipper = (new Zipper)->in('US')->withPostalCode(48867)->andWithKey($this->key);
        
    }
}