<?php

require '../../functions/GitHubWebCrawler.php';

$GHWC = new GitHubWebCrawler();
$img = $GHWC->getUserImage();

print_r($img);
