<?php

namespace Auth\Service;


use GuzzleHttp\Client;

class LinkedIn
{
    const LINKEDIN_AUTH_URL = 'https://www.linkedin.com/oauth/v2/authorization';
    const LINKEDIN_BASE_URL = 'https://www.linkedin.com';

    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * @var array
     */
    protected $config;

    /**
     * LinkedIn constructor.
     *
     * @param Client $guzzleClient
     * @param array $config
     */
    public function __construct(Client $guzzleClient, $config)
    {
        $this->guzzleClient = $guzzleClient;
        $this->config = $config;
        \Zend\Debug\Debug::dump($this->config);
    }

    public function getAuthenticationUrl()
    {
        return sprintf('%s?%s', self::LINKEDIN_AUTH_URL, implode('&', [
            'response_type=' . 'code',
            'client_id=' . $this->config['client_key'],
            'redirect_uri=' . urlencode($this->config['callback_uri']),
            'state=' . md5('foo-bar' . date('Y-m-d H:i:s')),
            'scope=' . urlencode('r_basicprofile r_emailaddress rw_company_admin w_share')
        ]));
    }

    public function requestAuthenticationCode()
    {

    }

}