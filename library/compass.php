<?php

class Compass {

    public static function upload($file) {
        $uid = $_SESSION['uid'];
        $api = 'https://compass.pg.com.cn/api/v1/'.md5($uid).'/wechat/inject?openid='.$uid;
        $rs = self::call('get', $api, array());

        $api = 'https://compass.pg.com.cn/api/v1/'.md5($uid).'/compass/init';
        $rs = self::call('get', $api, array());

        $file = realpath(dirname(__FILE__).'/..').'/uploads/'.basename($file);
        $api = 'https://compass.pg.com.cn/api/v1/'.md5($uid).'/compass/upload';

        $imageId = '';
        $rs = self::call('post', $api, array(
            'photo' => curl_file_create($file, 'image/jpeg', basename($file))
        ));

        if ($rs['code'] === 0) {
            $api = 'https://compass.pg.com.cn/api/v1/'.md5($uid).'/compass/report?imageid='.$rs['data']['imageId'];
            $rs = self::call('get', $api, array());
        }

        return $rs;
    }


    public static function call($method, $url, array $params)
    {
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT        => 8,
            CURLOPT_FOLLOWLOCATION => true,
        );

        switch ($method) {
            case 'post':
                $options[CURLOPT_POST] = true;
                //$options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
                //$options[CURLOPT_HTTPHEADER][] = 'Content-Length: '.strlen($params);
                $options[CURLOPT_POSTFIELDS] = $params;
                break;
            case 'put':
                $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $options[CURLOPT_POSTFIELDS] = $params;
                $options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
                $options[CURLOPT_HTTPHEADER][] = 'Content-Length: '.strlen($params);
                break;
            case 'delete':
                $options[CURLOPT_POST] = false;
                $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';            
                break;
            case 'get':
            default:
                break;
        }      

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        $httpCode = (int)$info['http_code'];
        if ($httpCode === 200) {
            $result = (array)json_decode($response, true);
        } else {
            $result = array(
                'resultCode' => $httpCode,
                'errorMsg' => '',
                'response' => $response,
                'info' => $info
            );
        }   

        return $result;         
    }
}