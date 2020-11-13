<?php

require '../../functions/GitHubWebCrawler.php';

$test = new GitHubWebCrawler();
$returningHTML = $test->loadHTML();
