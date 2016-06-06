<?php

namespace Kregel\Ziptastic;

use Kregel\Ziptastic\Guzzle\ZiptasticRequest;

class Ziptastic extends ZiptasticRequest
{

    /**
     * Ziptastic constructor.
     *
     * @param $zipcode
     * @param $country
     */
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
     *
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
     *
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
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
     *
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


    /**
     * @param $coordinates
     *
     * @return $this
     */
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


    /**
     * @param $radius
     *
     * @return $this
     */public function setRadius($radius)
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
     * @param $response
     *
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
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
     *
     * @return $this
     */public function setIsReverseGeocode($is_reverse_geocode)
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
     *
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }


    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }


    /**
     * @param $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }


    /**
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }


    /**
     * @param $hidden
     *
     * @return $this
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
        return $this;
    }


    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }


    /**
     * @param $client
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }
}
