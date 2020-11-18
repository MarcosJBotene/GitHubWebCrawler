<?php

class CovidWebCrawler
{
    private $url;
    private $proxy;
    private $dom;
    private $html;

    public function __construct()
    {
        $this->url = "https://www.gov.br/saude/pt-br";
        $this->proxy = "10.1.21.254:3128";
        $this->dom = new DOMDocument();
    }

    private function getContextConnection()
    {
        $arrayConfig = array(
            'http' => array(
                'proxy' => $this->proxy,
                'request_fulluri' => true
            ),
            'https' => array(
                'proxy' => $this->proxy,
                'request_fulluri' => true
            )
        );

        $context = stream_context_create($arrayConfig);
        return $context;
    }

    private function loadHTML()
    {
        $context = $this->getContextConnection();
        $this->html = file_get_contents($this->url, false, $context);

        libxml_use_internal_errors(true);

        $this->dom->loadHTML($this->html);
        libxml_clear_errors();
    }

    private function captureDivTags()
    {
        $divTag = $this->dom->getElementsByTagName('div');
        return $divTag;

        var_dump($divTag);
    }

    private function captureMainDiv($divTag)
    {
        $internalDivs = null;
        $divClass = 'content';

        foreach ($divTag as $div) {
            $class = $div->getAttribute('class');

            if ($class == $divClass) {
                $internalDivs = $div->getElementsByTagName('div');
            }
        }

        return $internalDivs;

        var_dump($internalDivs);
    }
}
