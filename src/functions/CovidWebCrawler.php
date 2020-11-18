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

    public function getH2Tag()
    {
        $this->loadHTML();
        $divTags = $this->captureDivTags();
        $internalDivs  = $this->captureMainDiv($divTags);
        $h2Tag = $this->captureH2Tags($internalDivs);
        $arrayH2 = $this->getArrayH2($h2Tag);
        return $arrayH2;
    }

    public function getSpanTag()
    {
        $this->loadHTML();
        $divTags = $this->captureDivTags();
        $internalDivs = $this->captureMainDiv($divTags);
        $spanTag = $this->captureSpanTags($internalDivs);
        $arraySpan = $this->getArraySpan($spanTag);
        return $arraySpan;
    }

    // Cria a configuração com o Proxy.
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

    // Carrega o HTML
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
        $divTags = $this->dom->getElementsByTagName('div');
        return $divTags;
    }

    private function captureMainDiv($divTags)
    {
        $internalDivs = null;

        foreach ($divTags as $div) {
            $class = $div->getAttribute('class');
            if ($class == 'content') {
                $internalDivs = $div->getElementsByTagName('div');
            }
        }

        return $internalDivs;
    }

    private function captureH2Tags($internalDivs)
    {
        $h2Tag = null;

        if (is_array($internalDivs) || is_object($internalDivs)) {
            foreach ($internalDivs as $div) {
                $class = $div->getAttribute('class');
                if ($class == 'cover-list-tile tile-content sortable-tile numeros-governo') {
                    $h2Tag = $div->getElementsByTagName('h2');
                }
            }
        }

        return $h2Tag;
    }

    private function captureSpanTags($internalDivs)
    {
        $spanTags = null;

        if (is_array($internalDivs) || is_object($internalDivs)) {
            foreach ($internalDivs as $div) {
                $class = $div->getAttribute('class');

                if ($class == 'itens') {
                    $spanTags = $div->getElementsByTagName('span');
                }
            }
        }

        return $spanTags;
    }

    private function getArrayH2($h2Tag)
    {
        $arrayH2 = [];

        if (is_array($h2Tag) || is_object($h2Tag)) {
            foreach ($h2Tag as $h2) {
                $arrayH2[] = $h2->nodeValue;
            }
        }

        return $arrayH2;
    }

    private function getArraySpan($spanTags)
    {
        $arraySpan = [];

        if (is_array($spanTags) || is_object($spanTags)) {
            foreach ($spanTags as $span) {
                $arraySpan[] = $span->nodeValue;
            }
        }

        return $arraySpan;
    }
}
