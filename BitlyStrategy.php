<?php
/**
 * Bitly strategy for Opauth
 * based on http://dev.bitly.com/api.html
 * Author: Benjamin Bjurstrom
 *
 * More information on Opauth: http://opauth.org
 *
 * @copyright    Copyright © 2012 U-Zyn Chua (http://uzyn.com)
 * @link         http://opauth.org
 * @package      Opauth.BitlyStrategy
 * @license      MIT License
 */


class BitlyStrategy extends OpauthStrategy
{

    public function __construct($strategy, $env)
    {
        parent::__construct($strategy, $env);
    }


    /**
     * Compulsory config keys, listed as unassociative arrays
     * eg. array('app_id', 'app_secret');
     */
    public $expects = array('client_id', 'client_secret');

    /**
     * Optional config keys with respective default values, listed as associative arrays
     * eg. array('scope' => 'email');
     */
    public $defaults = array(
        'redirect_uri' => '{complete_url_to_strategy}oauth_callback'
    );

    /**
     * Oauth request
     *
     * Generates a request token and redirects the user to bitly's site for
     * authentication.
     */
    public function request()
    {
        if (empty($_GET['code'])) {
            $url = 'https://bitly.com/oauth/authorize';
            $params = array(
                'client_id' => $this->strategy['client_id'],
                'redirect_uri' => $this->strategy['redirect_uri']
            );
            $this->clientGet($url, $params);
        }
    }

    /**
     * Oauth Callback
     *
     * After the user authenticates at https://bitly.com/oauth/authorize
     * bitly redirects them to the default callback URL. Opauth then
     * calls this method.
     */
    public function oauth_callback()
    {
        if(isset($_GET['code'])){
            $url = 'https://api-ssl.bit.ly/oauth/access_token';
            $params = array(
                'client_id' => $this->strategy['client_id'],
                'client_secret' => $this->strategy['client_secret'],
                'code' => $_GET['code'],
                'redirect_uri' => $this->strategy['redirect_uri'],
            );
            $output = $this->serverPost($url, $params);

            $parts = explode('&', $output);
            foreach ($parts as $part) {
                $bits = explode('=', $part);
                $results[$bits[0]] = $bits[1];
            }

            print_r($results);

            $this->send_success($results);
        }else{
            $error = array(
                'provider' => 'Bitly',
                'code' => 'auth_declined',
                'message' => 'auth_declined'
            );

            //opauth error callback
            $this->errorCallback($error);
        }
    }


    private function send_success($results)
    {
        $this->auth = array(
            'provider' => 'Bitly',
            'uid' => $results['login'],
            'credentials' => array(
                'token' => $results['access_token'],
                'api_key' => $results['apiKey']
            ),
            'raw' => $results
        );

        //opauth success callback
        $this->callback();
    }
}