<?php

class Azure {

    const API_KEY = '933ddf16cfaa44f0a0c40fc3f391dbba';

    public static function GET($url) {

    }

    public static function POST($url, $postBody = '') {
        return self::call('post', $url, $postBody);
    }

    public static function PUT($url, $postBody = '') {
        return self::call('put', $url, $postBody);
    }

    public static function DELETE($url) {

    }

    public static function call($method, $url, $params) {
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT        => 8,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => array(
                'Ocp-Apim-Subscription-Key: '.self::API_KEY
            ),
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

// PersonId
// wsc 270f5ffd-0450-473f-9f3e-893fd36531eb
// tw aa8ffbc5-bb7a-4f9c-8c30-bcf4b8ca56f3
// gyy 23014c76-496b-42a0-9d7b-b0f9a5323d95

// persistedFaceId
// wsc 870830ac-b0f8-4426-a4c9-21a6f7a4c838
// tw 6d0eca0a-4cea-48be-b049-897c2b22fad7
// gyy 66e8d0a7-be57-4586-8e0c-cfc5c22b7227
    public static function person($personId)
    {
        $img = '';
        switch ($personId) {
            case '270f5ffd-0450-473f-9f3e-893fd36531eb':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/wsc2.jpg';
                break;
            case 'aa8ffbc5-bb7a-4f9c-8c30-bcf4b8ca56f3':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/tw1.jpg';
                break;
            case '23014c76-496b-42a0-9d7b-b0f9a5323d95':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/gyy1.jpg';
                break;
        }

        return $img;
    }

    public static function img($faceId) {
        $img = '';

        switch ($faceId) {
            case '1bbcb33a-fa5d-4e0d-bbcb-43d6fac478d0':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/wsc1.png';
                break;
            case 'aa5b8f83-ad69-4b22-8843-3977aab32758':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/wsc2.jpg';
                break;
            case 'fdefef83-6911-49a6-b401-29b5773e36ce':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/wsc3.jpg';
                break;
            case '59a79066-9198-4e59-9c9a-b6e258c1d957':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/gyy1.jpg';
                break;
            case 'a30ef5da-71ea-43ac-b64a-92b9c79e8976':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/gyy2.jpg';
                break;
            case 'cc4ec3a8-0bc9-48db-ad62-77fc6a9402b2':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/gyy3.jpg';
                break;
            case '55cf648c-fa01-4379-b72e-8f6f4f6ece26':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/tw1.jpg';
                break;
            case 'ab8623cc-7caa-4849-b98e-8f8c7ef1f023':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/tw2.jpg';
                break;
            case '218d2e50-d46a-488f-a267-e64935add526':
                $img = 'https://offsite.chinacloudsites.cn/demo/images/tw3.jpg';
                break;
        }

        return $img;
    }
}