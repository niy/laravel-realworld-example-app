<?php
/**
 * Created by PhpStorm.
 * User: mrnim
 * Date: 5/10/2018
 * Time: 1:24 PM
 */

namespace App\ArvanCloud;


use GuzzleHttp\Client;

class ArvanCloudClient
{
    const BASE_URL = 'https://api.arvancloud.com/';

    /**
     * Creates a Guzzle http client to consume ArvanCloud API
     * @param array $config
     * @return Client
     */
    public static function create($config = [])
    {
        $clientConfig = array_merge(
            [
                'base_uri' => self::BASE_URL,
                'headers' => [
                    'X-AUTH-EMAIL' => env('ARVANCLOUD_USER_EMAIL'),
                    'X-AUTH-KEY' => env('ARVANCLOUD_USER_KEY'),
                    'X-AUTH-SERVICE-KEY' => env('ARVANCLOUD_DOMAIN_KEY')
                ]
            ],
            $config
        );

        return new Client($clientConfig);
    }
}