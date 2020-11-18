<?php

require '../../functions/CovidWebCrawler.php';

$CWC = new CovidWebCrawler();

$h2Tag = $CWC->getH2Tag();
$spanTag = $CWC->getSpanTag();

print_r($h2Tag);
print_r($spanTag);
