<?php
session_start();
$uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
if ($uid === 0) {
    $uid = 'compass_test_'.rand(1, 100);
    $_SESSION['uid'] = $uid;
}
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
    <style>
.start {
    border: 0 solid transparent;
    border-radius: 0;
    padding: .5rem 1.65rem;
    font-size: 1.6rem;
    color: #000;
    text-decoration: none;
    text-transform: uppercase;
    cursor: pointer;
    text-align: center;
    background: #868686;
    background-image: -webkit-linear-gradient(left bottom,#868686 0,#e5e5e5 25%,#eaeaea 26%,#bfbfbf 0,#fff 46%,#fff 55%,#bcbcbc 79%,#bababa);
}

.logo {
    width: 65%;
    height: auto;
    max-height: 32rem;
}

.intro {
    color: #d9d9d9;
    font-family: "NeutrafaceText-Light,Microsoft Yahei, 黑体,Heiti SC";
    font-size: 1.5rem;
    line-height: 1.5rem;
    margin: 2.75rem 0 0;
    width: 80%;
}
    </style>    
  </head>
  <body>
    <div class="container">
        <img src="assets/images/logofull.png" background-size="cover" mode="widthFix" class="logo"></img>
        <p class="intro">Upload a photo and search the same person in our database.</p>
        <img src="assets/images/youtube_thumbnail.png"></img>

        <a class="start btn btn-block" href="upload.php">Get Started</a>
    </div>    
  </body>
</html>
