<?php
// 如果接收到了上传的文件
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $_SESSION['uid'];
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
    <link href="./assets/upload.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  <div class="container upload">
    <div class="headbar">
        <p class="h1">FOR THE MOST ACCURATE SKIN ANALYSIS</p>
    </div>

    <div class="list">
        <ol>
            <li class="list0">
                <span>Pull hair back and if possible remove makeup and glasses</span>
            </li>

            <li class="list1">
                <span>Use the front-facing camera and minimize shadows</span>
            </li>

            <li class="list2">
                <span>Ensure your entire face is centered with a neutral expression</span>
            </li>
        </ol>

        <form method="post" id='photo_form' enctype='multipart/form-data' action="report.php">
            <input style='position: absolute;z-index: -1;' type='file' name='photo' id='photo' value='' />
            <button class="upload" id='start'>Start Analysis</button>
        </form>
    </div>
</div>
<div id='uploading' class='uploading'>
    <div id='uploadingText'>
        Uploading ...
    </div>
</div>
<iframe name='iframe' id='iframe' border='0' style='border: 0px;'></iframe>
<script type='text/javascript' src='assets/jquery-3.2.1.min.js'></script>
<script type='text/javascript'>
$(function () {
    console.log('jquery init ' + new Date())
    $('#photo').change(function () {
        var $this = $(this)
        var val = $this.val()

        console.log('VAL', val)
        if (val) {
            console.log($this.val())
            console.log('photo changed')
            setTimeout(function () {
                $('#uploading').show();
                $('#photo_form').trigger('submit');
            }, 300)
        }
    });

    $('#start').click(function () {
        $('#photo').trigger('click')
        return false;
    });
});
</script>
  </body>
</html>
