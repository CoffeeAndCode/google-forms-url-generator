<?php
namespace GoogleFormsURLGenerator;

class URLGenerator
{
    private $formID;

    function __construct($formID)
    {
        $this->$formID = $formID;
    }

    public function generate()
    {
        return '';
    }
}
