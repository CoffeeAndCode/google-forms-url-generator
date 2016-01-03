<?php
namespace GoogleFormsURLGenerator;

class URLGenerator
{
    private $formURL;

    function __construct($formURL)
    {
        $this->formURL = $formURL;
    }

    public function prefilledURL($params=[])
    {
        return $this->formURL . '/viewform' . self::paramsToQueryString($params);
    }

    public function submissionURL($params=[])
    {
        return $this->formURL . '/formResponse' . self::paramsToSubmissionQueryString($params);
    }

    public static function encode($value)
    {
        $encodedValue = urlencode($value);

        // These are based on tests ran against prefilling forms and comparing
        // the resulting URLs.
        $additionalReplacements = array(
            '%21' => '!',
            '%24' => '$',
            '%27' => '\'',
            '%28' => '(',
            '%29' =>  ')',
            '%2A' => '*',
            '%2C' => ',',
            '%2F' => '/',
            '%3A' => ':',
            '%3B' => ';',
            '%3F' => '?',
            '%40' => '@',
            '%7E' => '~'
        );

        foreach ($additionalReplacements as $search => $replacement) {
            $encodedValue = str_replace($search, $replacement, $encodedValue);
        }

        return $encodedValue;
    }

    public static function paramsToQueryString($params=[])
    {
        if (empty($params)) {
            return '';
        }
        $queryStringParams = array();
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $arrayValue) {
                    $queryStringParams[] = 'entry.'.strval($key).'='.self::encode($arrayValue);
                }
            } else {
                $queryStringParams[] = 'entry.'.strval($key).'='.self::encode($value);
            }
        }
        return '?'.join('&', $queryStringParams);
    }

    public static function paramsToSubmissionQueryString($params=[])
    {
        $paramQueryString = self::paramsToQueryString($params);
        if (strlen($paramQueryString) > 0) {
            return '?ifq&'.substr($paramQueryString, 1).'&submit=Submit';
        }
        return '?ifq&submit=Submit';
    }
}
