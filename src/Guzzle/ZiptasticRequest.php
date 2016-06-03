<?php

namespace Kregel\Ziptastic\Guzzle;

use Exception;
use GuzzleHttp\Client;
use JsonSerializable;

class ZiptasticRequest implements JsonSerializable
{
    /**
     * This is the url to ziptastic.
     *
     * @var string
     */
    public $ziptastic = 'https://zip.getziptastic.com';

    /**
     * This is the version of ziptastic you will be accessing.
     *
     * @var string
     */
    public $version = 'v3';

    /**
     * This should be the request's country code.
     *
     * @var string
     */
    public $country;

    /**
     * This should be the request's postal code.
     *
     * @var string|int
     */
    public $postal_code;

    /**
     * This is the coordiantes for a reverse geolocation.
     * It should be latitude first, then longitude.
     *
     * @var array
     */
    public $coordinates;

    /**
     * This is the radius for a reverse geolocation.
     *
     * @var int
     */
    public $radius;

    /**
     * This is the client's response.
     *
     * @var string|null
     */
    public $response;

    /**
     * Thisis used when buidling the URL to determine which style of url is needed.
     *
     * @var bool
     */
    public $is_reverse_geocode = false;

    /**
     * An array of all the attributes in this class.
     *
     * @var array
     */
    public $attributes;

    /**
     * This should be the needed key for accessing the api.
     *
     * @var string
     */
    public $key;
    /**
     * This is the request's client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Sets the base attributes
     * ZiptasticRequest constructor.
     */
    public function __construct()
    {
        $this->attributes = get_object_vars($this);
    }

    /**
     * This executes the Guzzle query to the api.
     */
    public function find()
    {
        if (empty($this->key)) {
            throw new Exception('A key was not provided');
        }
        $this->client = new Client(['headers' => ['x-key' => $this->key]]);
        $this->response = $this->client->get($this->buildUrl())->getBody()->getContents();

        return $this;
    }

    /**
     * Builds the url for sending the requests to.
     *
     * @return string
     */
    protected function buildUrl()
    {
        $url = trim($this->ziptastic);
        $version = trim($this->version);
        if ($this->is_reverse_geocode === true) {
            return $url.'/'.$version.'/reverse/'.implode('/', $this->coordinates).'/'.$this->radius;
        }

        return $url.'/'.$version.'/'.strtoupper($this->country).'/'.$this->postal_code;
    }

    /**
     * Check to see if your attributes exist in the attributes array.
     *
     * @param $string
     * @param array $attr
     *
     * @return bool
     */
    public function has($string, $attr = [])
    {
        if (count($attr) > 0) {
            \Kregel\Ziptastic\dd($attr);

            return in_array($string, $attr);
        }

        return in_array($string, $this->attributes);
    }

    /**
     * json_encode the object.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $this->attributes = get_object_vars($this);

        return $this->toArray();
    }

    /**
     * Convert sthis object to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attr = [];
        foreach ($this->attributes as $variable => $value) {
            if (is_string($value) && $this->is_json($value)) {
                $value = json_decode($value);
            }
            $attr[$variable] = $value;
        }

        return $attr;
    }

    /**
     * Checks to see if a string is an array.
     *
     * @param $string
     *
     * @return bool
     */
    protected function is_json($string)
    {
        json_decode($string);

        return json_last_error() == JSON_ERROR_NONE;
    }
}
