<?php

namespace Kregel\Ziptastic;


use GuzzleHttp\Client;
use Kregel\Ziptastic\Guzzle\ZiptasticRequest;

class Ziptastic extends ZiptasticRequest
{
    public function __construct($zipcode, $country)
    {
        $this->setPostalCode($zipcode)->setCountry($country);
    }

    /**
     * @return string
     */
    public function getZiptastic()
    {
        return $this->ziptastic;
    }

    /**
     * @param $ziptastic
     * @return $this
     */
    public function setZiptastic($ziptastic)
    {
        $this->ziptastic = $ziptastic;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = strtoupper($country);
        return $this;
    }

    /**
     * @return int|string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param $postal_code
     * @return $this
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    /**
     * @return array
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }


    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * @return int
     */
    public function getRadius()
    {
        return $this->radius;
    }



    public function setRadius($radius)
    {
        $this->radius = $radius;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return boolean
     */
    public function isIsReverseGeocode()
    {
        return $this->is_reverse_geocode;
    }

    /**
     * @param $is_reverse_geocode
     * @return $this
     */
    public function setIsReverseGeocode($is_reverse_geocode)
    {
        $this->is_reverse_geocode = $is_reverse_geocode;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param $key
     * @return string
     */
    public function getKey($key)
    {
        return $this->key;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
}