<?php

namespace Digitsoauth\Adapter;

class Fabric
{
    const HTTP_METHOD  = 'GET';
    const SIGN_METHOD  = 'HMAC-SHA1';
    const OAUTHVERSION = '1.0';

    private $client;

    private $connectTimeout = 3;
    private $totalTimeout   = 6;

    /**
     * HMAC signing
     * Hmac = f(tokenSecret, consumerSecret)
     */

    public function __construct($oauthToken,
                                $oauthTokenSecret,
                                $consumerKey,
                                $consumerSecret,
                                $resourceURL)
    {
        $this->url          = $resourceURL;
        $this->token        = $oauthToken;

        $config = array('adapter' => 'Zend_Http_Client_Adapter_Curl',
                        'timeout' => $this->totalTimeout,
                        'curloptions' => array(CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
                                               CURLOPT_TIMEOUT        => $this->totalTimeout));

        $client = new \Zend_Oauth_Client(array('consumerKey'     => $consumerKey,
                                               'consumerSecret'  => $consumerSecret,
                                               'signatureMethod' => self::SIGN_METHOD,
                                               'version'         => self::OAUTHVERSION
                                         ),
                                         $resourceURL,
                                         $config);

        $client->setRequestScheme(\Zend_Oauth::REQUEST_SCHEME_HEADER);
        $client->setRequestMethod(\Zend_Oauth::GET);

        $ztoken = new \Zend_Oauth_Token_Access();
        $ztoken->setToken($oauthToken);
        $ztoken->setTokenSecret($oauthTokenSecret);

        $client->setToken($ztoken);

        $client->setAdapter();

        $this->client = $client;
    }

    public function request()
    {
        $zend_http_response = $this->client->request();
        if ($zend_http_response->isSuccessful()) {
            return \Zend_Json::decode($zend_http_response->getBody());
        } else {
            return $zend_http_response;
        }
    }
}
