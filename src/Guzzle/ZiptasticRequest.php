<?php

namespace Ziptastic\Guzzle\Guzzle;

use ArrayAccess;
use Exception;
use GuzzleHttp\Client;
use JsonSerializable;

abstract class ZiptasticRequest implements JsonSerializable, ArrayAccess
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
     * @var int|string
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
     * @var string
     */
    public $response;

    /**
     * This is used when buidling the URL to determine which style of url is needed.
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
     * This is used to hide attributes from the toArray method.
     *
     * @var array
     */
    protected $hidden = ['client', 'hidden', 'attributes'];

    /**
     * This is the request's client.
     *
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->attributes = get_object_vars($this);
    }

    /**
     * Magically get the class variables and if they are not found throw an exception.
     *
     * @param string $string
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function __get($string)
    {
        if ($this->has($string)) {
            return $this->$string;
        } elseif (!empty($this->response)) {
            $decoded_response = json_decode($this->response)[0];
            if (isset($decoded_response->$string)) {
                return $decoded_response->$string;
            }
        }
        throw new Exception("Undefined variable [$string]");
    }

    /**
     * Magically set the class variables and if they are not found throw an exception.
     * Otherwise set the variables to the requested value.
     *
     * @param string $string
     * @param mixed  $args
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function __set($string, $args)
    {
        if ($this->has($string)) {
            $this->$string = $args;
        } else {
            throw new Exception("Undefined variable [$string]");
        }
    }

    /**
     * Check to see if your attributes exist in the attributes array.
     *
     * @param string $string
     * @param array  $attr
     *
     * @return bool
     */
    public function has($string, $attr = [])
    {
        if (count($attr) > 0) {
            return in_array($string, $attr) && !in_array($string, $this->hidden);
        }

        return in_array($string, array_keys($this->attributes)) && !in_array($string, $this->hidden);
    }

    /**
     * This executes the Guzzle query to the api.
     *
     * @return ZiptasticRequest
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
     * json_encode the object.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize()
    {
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
        $attributes = get_object_vars($this);
        foreach ($attributes as $variable => $value) {
            if ($this->has($variable)) {
                if (is_string($value) && $this->is_json($value)) {
                    $value = json_decode($value);
                }
                $attr[$variable] = $value;
            }
        }

        return $attr;
    }

    /**
     * Checks to see if a string is an array.
     *
     * @param string $string
     *
     * @return bool
     */
    protected function is_json($string)
    {
        json_decode($string);

        return json_last_error() == JSON_ERROR_NONE;
    }

    /**
     * Whether a offset exists.
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param int|string $offset
     *
     * @return bool true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->$offset = null;
    }
}
