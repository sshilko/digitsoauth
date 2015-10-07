Digitsoauth (Verifying a User)
=====

Validate users that are authenticated with phone numbers via Fabric.io / Digits (Twitter).
The initial purpose is server-side validating Fabric tokens obtained from mobile client.

Client has to send clientToken & clientTokenSecret for backend to validate them.

Backend needs to know Consumer Key&Secret for HMAC signing of oAuth request to [api.digits.com](https://api.digits.com/1.1/sdk/account.json)

Uses ZendFramework 1 Zend Oauth Client parts.

#### Requirements

* ZendFramework 1 [library](https://github.com/zendframework/zf1) for Zend_Oauth_Client 
* PHP 5.3.0 [namespaces](http://php.net/manual/en/language.namespaces.rationale.php)
* [Fabric account](http://fabric.io) for CONSUMER KEY (API KEY), CONSUMER SECRET (API SECRET)

#### Basic Usage (token server-side validation)

```

$account = new \Digitsoauth\Account($accessToken,
                                    $accessTokenSecret,
                                    $consumerKey,
                                    $consumerSecret);

#calls https://api.digits.com/1.1/sdk/account.json to verify $accessToken
#returns user data (success)
#or Zend_Http_Response (error)
$result = $account->verifyCredentials();

if ($result instanceof \Zend_Http_Response) {
    #process errors (network, credentials, ...)
    echo (string) $result;
} else {
    #got the response array with digits identifier & phone number
    $digitsId    = $result['id_str'];
    $digitsPhone = $result['phone_number'];
}

```

#### References

1. https://docs.fabric.io/ios/digits/oauth-echo.html
2. [fabric.io](https://docs.fabric.io)
3. [dev.twitter.com](https://dev.twitter.com/oauth/overview/authorizing-requests)
4. https://dev.twitter.com/oauth/overview/creating-signatures
5. https://docs.fabric.io/web/digits/getting-started.html#set-up-digits-authentication
6. http://nouncer.com/oauth/signature.html
7. http://framework.zend.com/manual/1.12/en/zend.oauth.introduction.html
