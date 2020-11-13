<?php

class GitHubWebCrawler
{
    private $url;
    private $proxy;
    private $dom;
    private $html;

    public function __construct()
    {
        $this->url = "https://github.com/MarcosJBotene";
        $this->proxy = "10.1.21.254:3128";
        $this->dom = new DOMDocument();
    }

    public function getUserImage()
    {
    }

    // Cria uma configuração pro Proxy.
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

    // Carrega o HTML.
    private function loadHTML()
    {
        $context = $this->getContextConnection();
        $this->html = file_get_contents($this->url, false, $context);

        libxml_use_internal_errors(true);

        $this->dom->loadHTML($this->html);
        libxml_clear_errors();
    }

    // Captura uma Div. 
    private function captureDivTags()
    {
        $divTags = $this->dom->getElementsByTagName('div');
        return $divTags;
    }

    // Captura as Divs Internas dentro da Div Principal da Pagina.
    private function captureInternalDivsApplicationMain($allDivs)
    {
        $internalDivs = null;

        foreach ($allDivs as $div) {
            $class = $div->getAttribute('class');

            if ($class == 'application-main') {
                $internalDivs = $div->getElementsByTagName('div');
                break;
            }
        }

        return $internalDivs;
    }

    private function captureImgTags($internalDivs)
    {
        $class = 'flex-shrink-0 col-12 col-md-3 mb-4 mb-md-0';
        $imgTags = null;

        foreach ($internalDivs as $internalDiv) {
            $internalClass = $internalDiv->getAttribute('class');
            if ($internalClass == $class) {
                $imgTags = $internalDiv->getElementsByTagName('img');
            }
        }

        return $imgTags;
    }

    private function getArrayImg($imgTags)
    {
        $arrayImg = [];

        foreach ($imgTags as $img) {
            $arrayImg[] = $img->nodeValue;
        }

        return $arrayImg;
    }
}
