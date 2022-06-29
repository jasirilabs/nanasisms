<?php

namespace JasiriLabs\SigmaSMS\BeemSms;
use GuzzleHttp\Client;
use JasiriLabs\SigmaSMS\Config;

class BeamSmsClient
{

    // base url for the NextSms API
    const BASE_URL = 'https://apisms.beem.africa';


    /**
     *
     * @var config
     *
     */

    private Config $config;


    /**
     *
     * The NextSms API version
     *
     */

    private string $apiVersion = 'v1';


    private Client $client;


    public function __construct($config, $apiVersion)
    {
        $this->apiVersion = $apiVersion;
        $this->config = $config;

        $this->client =  new Client(
            [
                'base_uri' => self::BASE_URL,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'auth' => [$this->config->get('username'), $this->config->get('password')],
            ]
        );
    }



    public function post($endpoint, $data)
    {
        $url =  "/". $this->apiVersion . $endpoint;
        $response = $this->client->request('POST', $url, [
            'body' => json_encode($data),
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function get($endpoint)
    {
        $url =  "/public/". $this->apiVersion . $endpoint;
        $response = $this->client->request('GET', $url);
        return json_decode($response->getBody()->getContents(), true);
    }


}