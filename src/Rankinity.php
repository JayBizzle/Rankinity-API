<?php

namespace Jaybizzle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Rankinity
{
    public $api_key;
    public $api_endpoint = 'http://my.rankinity.com/api/v1/';
    public $client;
    public $query = [];

    public function __construct($api_key, $client = null)
    {
        $this->api_key = $api_key;

        $this->addQuery('token', $api_key);

        $this->client = ($client) ?: new Client([
            'base_url' => $this->api_endpoint,
            'defaults' => [
                //'proxy'   => 'http://localhost:8888',
                'headers'  => [
                    'Accept'      => 'application/json',
                ],
            ],
            'debug' => true,
        ]);
    }

    /**
     * Dynamically add query parameters or call API endpoints.
     * 
     * @param string $method
     * @param array  $args
     *
     * @return object
     */
    public function __call($name, $args)
    {
        if (substr($name, 0, 3) == 'get') {
            $name = strtolower(substr($name, 3));

            $name = $name.'.json';

            return $this->buildRequest($name, $args);
        } else {
            if($name == 'project') {
                $this->api_endpoint .= 'projects/'.$args[0].'/';
                return $this;
            }

            if($name == 'searchEngine') {
                $this->api_endpoint .= 'search_engines/'.$args[0].'/';
                return $this;
            }

            return $this->addQuery($name, $args);
        }
    }

    /**
     * Add query parameters.
     * 
     * @param string $method
     * @param array  $args
     *
     * @return $this
     */
    public function addQuery($name, $args)
    {
        $name = $this->snakeCase($name);

        $this->query[$name] = is_array($args) ? $args[0] : $args;

        return $this;
    }

    /**
     * Prepare the request.
     * 
     * @param string $resource
     * @param array  $args
     * @param string $method
     *
     * @return object
     */
    public function buildRequest($resource, $args = [], $method = 'get')
    {
        $query = [];

        if (isset($args[0]) && count($args[0]) == 1 && is_int($args[0])) {
            $resource = $resource.'/'.$args[0];
        }

        if (!empty($this->query)) {
            $query = $this->query;
        }

        return $this->sendRequest($resource, $query, $method);
    }

    /**
     * Send the request.
     * 
     * @param string $resource
     * @param array  $args
     * @param string $method
     *
     * @return object
     */
    public function sendRequest($resource, $query = [], $method = 'get')
    {
        $option_name = ($method == 'get') ? 'query' : 'json';
        $endpoint = $this->api_endpoint.$resource;

        try {
            $response = $this->client->$method($endpoint, [$option_name => $query]);
        } catch (ClientException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

        // Reset query parameters
        $this->query = [];

        return json_decode($response->getBody());
    }

    /**
     * Convert camelCase methods to snake_case params.
     * 
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public function snakeCase($value, $delimiter = '_')
    {
        $key = $value.$delimiter;

        if (!ctype_lower($value)) {
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.$delimiter, $value));
            $value = preg_replace('/\s+/', '', $value);
        }

        return $value;
    }
}
