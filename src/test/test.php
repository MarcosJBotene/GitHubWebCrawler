<?php

require '../functions/WebCrawler.php';

$PWC = new WebCrawler();
$h1Tag = $PWC->getH1Tag();
$pTag = $PWC->getPTag();
$imgTag = $PWC->getImgTag();

print_r($h1Tag);
print_r($pTag);
print_r($imgTag);
