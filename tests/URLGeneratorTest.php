<?php
namespace GoogleFormsURLGenerator;

class URLGeneratorEncodingTests extends \PHPUnit_Framework_TestCase
{
    public function testEncodeSimpleString()
    {
        $this->assertEquals('Option+1', URLGenerator::encode('Option 1'));
    }

    public function testEncodeMultilineString()
    {
        $value = <<<EOD
This is a multiline string.

  Line with preceeding spaces!
EOD;
        $expected = 'This+is+a+multiline+string.%0A%0A++Line+with+preceeding+spaces!';
        $this->assertEquals($expected, URLGenerator::encode($value));
    }

    public function testEncodingSpecialCharacters()
    {
        $value = '~!@#$%^&*()_+`-={}|[]\:";\'<>?,./';
        $expected = '~!@%23$%25%5E%26*()_%2B%60-%3D%7B%7D%7C%5B%5D%5C:%22;\'%3C%3E?,./';
        $this->assertEquals($expected, URLGenerator::encode($value));
    }
}

class URLGeneratorPrefilledURLTests extends \PHPUnit_Framework_TestCase
{
    private $exampleURL = 'https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx';

    public function testPrefilledURLWithoutParams()
    {
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/viewform', $generator->prefilledURL());
    }

    public function testPrefilledURLWithParamIDAsAnInteger()
    {
        $params = array(
            123456 => 'Option 1'
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/viewform?entry.123456=Option+1', $generator->prefilledURL($params));
    }

    public function testPrefilledURLWithParamIDAsAString()
    {
        $params = array(
            '123456' => 'Option 1'
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/viewform?entry.123456=Option+1', $generator->prefilledURL($params));
    }

    public function testPrefilledURLWithMultipleParams()
    {
        $params = array(
            '123456' => 'Option 1',
            '789012' => 'Option 2'
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/viewform?entry.123456=Option+1&entry.789012=Option+2', $generator->prefilledURL($params));
    }

    public function testPrefilledURLWithMultipleAnswersForTheSameQuestion()
    {
        $params = array(
            '123456' => ['Option 1', 'Option 2']
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/viewform?entry.123456=Option+1&entry.123456=Option+2', $generator->prefilledURL($params));
    }
}

class URLGeneratorSubmissionURLTests extends \PHPUnit_Framework_TestCase
{
    private $exampleURL = 'https://docs.google.com/a/google-apps-account.com/forms/d/xxxxxxxxxxxxxxxxx-xxxxxxx-xxxxx_xxxxxxxxxxxx';

    public function testSubmissionURLWithoutParams()
    {
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/formResponse?ifq&submit=Submit', $generator->submissionURL());
    }

    public function testSubmissionURLWithParamIDAsAnInteger()
    {
        $params = array(
            123456 => 'Option 1'
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/formResponse?ifq&entry.123456=Option+1&submit=Submit', $generator->submissionURL($params));
    }

    public function testSubmissionURLWithParamIDAsAString()
    {
        $params = array(
            '123456' => 'Option 1'
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/formResponse?ifq&entry.123456=Option+1&submit=Submit', $generator->submissionURL($params));
    }

    public function testSubmissionURLWithMultipleParams()
    {
        $params = array(
            '123456' => 'Option 1',
            '789012' => 'Option 2'
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/formResponse?ifq&entry.123456=Option+1&entry.789012=Option+2&submit=Submit', $generator->submissionURL($params));
    }

    public function testSubmissionURLWithMultipleAnswersForTheSameQuestion()
    {
        $params = array(
            '123456' => ['Option 1', 'Option 2']
        );
        $generator = new URLGenerator($this->exampleURL);
        $this->assertEquals($this->exampleURL . '/formResponse?ifq&entry.123456=Option+1&entry.123456=Option+2&submit=Submit', $generator->submissionURL($params));
    }
}
