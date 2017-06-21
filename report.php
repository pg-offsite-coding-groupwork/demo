<?php
session_start();

require './library/azure.php';
require './library/upload.php';

// demo
// save your uploaded photo
$imgUrl = Upload::save($_FILES['photo']);

// use Azure's api to detect face
$requestBody = <<<EOF
{
    "url":"{$imgUrl}"
}
EOF;
$rs = Azure::POST('https://api.cognitive.azure.cn/face/v1.0/detect', $requestBody);
// 如果要调试这个接口的返回值，请将下面一行取消注释
// echo '<hr />';var_dump($rs);echo '<hr />';exit;
$faceId = $rs[0]['faceId'];

// try to find a similar person in face list
$requestBody = <<<EOF
{    
    "faceId":"{$faceId}",
    "faceListId":"offset-demo",  
    "maxNumOfCandidatesReturned":10,
    "mode": "matchPerson"
}
EOF;

$rs = Azure::POST('https://api.cognitive.azure.cn/face/v1.0/findsimilars', $requestBody);
// 如果要调试这个接口的返回值，请将下面一行取消注释
echo '<hr />';var_dump($rs);echo '<hr />';exit;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Olay</title>
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="App-Config" content="fullscreen=yes,useHistoryState=yes,transition=yes">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link href="./assets/style.css" rel="stylesheet" type="text/css">
    <link href="./assets/report.css" rel="stylesheet" type="text/css">
    <style>

    </style>    
  </head>
  <body>
    <div class="container report">
        <div class="report-head">
            <div class="age-presenter">
                <img class="uploaded" src='<?php echo $imgUrl;?>' alt='' />
            </div>

            <?php
            $msg = '';
            switch ($rs['resultCode']) {
                case 400:
                    $msg = $rs['response'];
                    break;
            }
            ?>
            <?php
            if ($msg !== '') {
            ?>
            <p class="text text-view intro"><?php echo $msg;?></p>  
            <?php
            } else {
            ?>
            <p class="text text-view intro">Similar persons: </p>  
            <p class="text text-view intro">
                <ul class='similar'>
                    <?php
                    foreach ($rs as $row) {
                        $faceId = $row['persistedFaceId'];
                        $img = Azure::img($faceId);

                        if ($img) {
                            ?>
                    <li>
                        <img src='<?php echo $img; ?>' alt='' />
                    </li>
                    <?php

                        }
                    }
                    ?>
                </ul>    
            </p> 
            <?php
            }
            ?>
        </div>

        <div class="buttons">
            <button class="myproducts" onclick="window.location='index.php';">Retake Analysis</button>
        </div>
    </div>
 
  </body>
</html>
