<?php

require './WebCrawler.php';

$WC = new WebCrawler();

$h1Tag = $WC->getH1Tag();
$pTag = $WC->getPTag();
$imgTag = $WC->getImgTag();
