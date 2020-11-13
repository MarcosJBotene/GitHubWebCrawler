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

    public function loadHTML()
    {
        $context = $this->getContextConnection();
        $this->html = file_get_contents($this->url, false, $context);

        libxml_use_internal_errors(true);

        $this->dom->loadHTML($this->html);
        libxml_clear_errors();

        print_r($this->html);
    }
}
