<?php

require '../../functions/WebCrawler.php';

$PWC = new WebCrawler();
$h1Tag = $PWC->getH1Tag();
$pTag = $PWC->getPTag();
$imgTag = $PWC->getImgTag();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Web Crawler</title>
</head>

<body>
    <header>
        <h1>
            <?php
            echo $h1Tag[0];
            ?>
        </h1>
    </header>

    <main>
        <div class="container">
            <?php for ($i = 1; $i < count($pTag); $i++) : ?>
                <?php if ($i <= 3) : ?>
                    <p>
                        <?php echo $pTag[$i] ?>
                    </p>
                <?php endif; ?>

                <?php if ($i > 3 && $i <= 7) : ?>
                    <li>
                        <?php echo $pTag[$i] ?>
                    </li>
                <?php endif; ?>

                <?php if ($i >= 8 && $i <= 16) : ?>
                    <p>
                        <?php echo $pTag[$i] ?>
                    </p>
                <?php endif; ?>

                <?php if ($i >= 17) : ?>
                    <li>
                        <?php echo $pTag[$i] ?>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

    </main>
</body>

</html>