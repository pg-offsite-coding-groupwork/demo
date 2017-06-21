<?php

class Upload
{
    public static function save($row)
    {
        $savePath = dirname(__FILE__).'/../uploads';
        
        $file = $row['name'];
        $ext = self::getExt($file);
        $dest = md5(uniqid(rand())).'.'.$ext;

        move_uploaded_file($row['tmp_name'], $savePath.'/'.$dest);
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/'.$dest;

        return $url;
    }

    private static function getExt($file)
    {
        $tmp = explode('.', $file);
        $ext = count($tmp)>1 ? $tmp[count($tmp) - 1] : $tmp[0];

        return $ext;
    }
}