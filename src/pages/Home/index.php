<?php

$proxy = '10.1.21.254:3128';

$arrayConfig = array(
    'http' => array(
        'proxy' => $proxy,
        'request_fulluri' => true
    ),
    'https' => array(
        'proxy' => $proxy,
        'request_fulluri' => true
    )
);

$context = stream_context_create($arrayConfig);
//-------------------------------------------------------------------------------------------------

$url = 'https://github.com/MarcosJBotene';
$html = file_get_contents($url, false, $context);

$dom = new DOMDocument();
libxml_use_internal_errors(true);

// Transforma o HTML em objeto
$dom->loadHTML($html);
libxml_clear_errors();

print_r($html);
