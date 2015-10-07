<?php
namespace Digitsoauth;

/**
 * Fabric.io (Digits)
 * Account verification
 *
 * @see https://docs.fabric.io
 * @see https://dev.twitter.com/oauth/overview/authorizing-requests
 * @see https://dev.twitter.com/oauth/overview/creating-signatures
 * @see https://docs.fabric.io/web/digits/getting-started.html#digits-for-web-demo
 */
class Account
{
    const DIGITS_API = 'https://api.digits.com/1.1/sdk/account.json';

    public function __construct($oauthToken, $oauthTokenSecret, $consumerKey, $consumerSecret)
    {
        $this->adapter = new Adapter\Fabric($oauthToken,
                                            $oauthTokenSecret,
                                            $consumerKey,
                                            $consumerSecret,
                                            self::DIGITS_API);
    }

    /**
     * Call api.digits.com to verify access token
     *
     * @return mixed|\Zend_Http_Response
     */
    public function verifyCredentials()
    {
        $result = $this->adapter->request();
        return $result;
    }

}
