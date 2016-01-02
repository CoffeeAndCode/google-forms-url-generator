<?php
namespace GoogleFormsURLGenerator;

class URLGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        $generator = new URLGenerator('abcd');
        $this->assertEquals('', $generator->generate());
    }
}
