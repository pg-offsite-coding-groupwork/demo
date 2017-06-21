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
// echo '<hr />';var_dump($rs);echo '<hr />';exit;


$row = $rs[1];
$faceId = $row['persistedFaceId'];
$img = Azure::img($faceId);

?>


<!DOCTYPE html>
<html>
  <head>
    <title>Result</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <link href="resources/css/jquery-ui-themes.css" type="text/css" rel="stylesheet"/>
    <link href="resources/css/axure_rp_page.css" type="text/css" rel="stylesheet"/>
    <link href="data/styles.css" type="text/css" rel="stylesheet"/>
    <link href="files/result/styles.css" type="text/css" rel="stylesheet"/>
    <script src="resources/scripts/jquery-1.7.1.min.js"></script>
    <script src="resources/scripts/jquery-ui-1.8.10.custom.min.js"></script>
    <script src="resources/scripts/prototypePre.js"></script>
    <script src="data/document.js"></script>
    <script src="resources/scripts/prototypePost.js"></script>
    <script src="files/result/data.js"></script>
    <script type="text/javascript">
      $axure.utils.getTransparentGifPath = function() { return 'resources/images/transparent.gif'; };
      $axure.utils.getOtherPath = function() { return 'resources/Other.html'; };
      $axure.utils.getReloadPath = function() { return 'resources/reload.html'; };
    </script>
  </head>
  <body>
    <div id="base" class="">

      <!-- Unnamed (Rectangle) -->
      <div id="u6" class="ax_default heading_1">
        <div id="u6_div" class=""></div>
        <!-- Unnamed () -->
        <div id="u7" class="text">
          <p><span>Wang's 2nd Picture:</span></p>
        </div>
      </div>

      <!-- Unnamed (Rectangle) -->
      <div id="u8" class="ax_default box_1" style="width:auto;height:auto;">
        <div id="u8_div" class=""><img src='<?php echo $img; ?>' alt='' /></div>
        <!-- Unnamed () -->
        <div id="u9" class="text" style="display:none; visibility: hidden">
          <p><span></span></p>
        </div>
      </div>
    </div>
	
	
	<br><br>
	
	<!--
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
			-->
	
	
  </body>
</html>


<!--
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
-->