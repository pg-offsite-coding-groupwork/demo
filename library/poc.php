<?php

class Poc 
{
    public static function GET($url) {
        return self::call($url, array());
    }

    public static function POST($url, $postBody = '') {
        return self::call('post', $url, $postBody);
    }

    public static function PUT($url, $postBody = '') {
        return self::call('put', $url, $postBody);
    }

    public static function DELETE($url) {

    }

    public static function call($url, array $params)
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
                $options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
                $options[CURLOPT_HTTPHEADER][] = 'Content-Length: '.strlen($params);
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