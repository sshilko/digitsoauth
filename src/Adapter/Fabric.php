<?php

namespace Digitsoauth\Adapter;

class Fabric
{
    const HTTP_METHOD  = 'GET';
    const SIGN_METHOD  = 'HMAC-SHA1';
    const OAUTHVERSION = '1.0';

    private $client;

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

        $client = new \Zend_Oauth_Client(array('consumerKey'     => $consumerKey,
                                               'consumerSecret'  => $consumerSecret,
                                               'signatureMethod' => self::SIGN_METHOD,
                                               'version'         => self::OAUTHVERSION
                                         ), $resourceURL);
        $client->setRequestScheme(\Zend_Oauth::REQUEST_SCHEME_HEADER);
        $client->setRequestMethod(\Zend_Oauth::GET);

        $ztoken = new \Zend_Oauth_Token_Access();
        $ztoken->setToken($oauthToken);
        $ztoken->setTokenSecret($oauthTokenSecret);

        $client->setToken($ztoken);

        $this->client = $client;
    }

    public function request() {
        $zend_http_response = $this->client->request();
        if ($zend_http_response->isSuccessful()) {
            return \Zend_Json::decode($zend_http_response->getBody());
        } else {
            return $zend_http_response;
        }
    }
}
