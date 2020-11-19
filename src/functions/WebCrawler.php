<?php

class WebCrawler
{
    private $url;
    private $proxy;
    private $dom;
    private $html;

    public function __construct()
    {
        $this->url = "https://bcc.ime.usp.br/tccs/2006/andre/WebCrawler.html";
        $this->proxy = "10.1.21.254:3128";
        $this->dom = new DOMDocument();
    }

    public function getH1Tag()
    {
        $this->loadHTML();
        $h1Tag = $this->captureH1Tag();
        $arrayH1Tag = $this->getArrayH1Tag($h1Tag);
        return $arrayH1Tag;
    }

    public function getPTag()
    {
        $this->loadHTML();
        $pTag = $this->capturePTag();
        $arrayPTag = $this->getArrayPTag($pTag);
        return $arrayPTag;
    }

    public function getImgTag()
    {
        $this->loadHTML();
        $imgTag = $this->captureImgTag();
        $arrayImg = $this->getArrayImg($imgTag);

        return $arrayImg;
    }

    private function getContextConnection()
    {
        $arrayConfig = array(
            'http' => array(
                'ignore_errors' => true,
                'proxy' => $this->proxy,
                'request_fulluri' => true
            ),
            'https' => array(
                'ignore_errors' => true,
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

    private function captureH1Tag()
    {
        $h1Tag = $this->dom->getElementsByTagName('h1');
        return $h1Tag;
    }

    private function capturePTag()
    {
        $pTag = $this->dom->getElementsByTagName('p');
        return $pTag;
    }

    private function captureImgTag()
    {
        $imgTag = $this->dom->getElementsByTagName('img');
        return $imgTag;
    }

    private function getArrayH1Tag($h1Tag)
    {
        $arrayH1 = [];

        foreach ($h1Tag as $h1) {
            $arrayH1[] = $h1->nodeValue;
        }

        return $arrayH1;
    }

    private function getArrayPTag($pTag)
    {
        $arrayP = [];

        foreach ($pTag as $p) {
            $arrayP[] = $p->nodeValue;
        }

        return $arrayP;
    }

    private function getArrayImg($imgTag)
    {
        $arrayImg = [];

        foreach ($imgTag as $img) {
            $arrayImg[] = $img->getAttribute('src');
        }

        return $arrayImg;
    }
}
