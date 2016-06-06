<?php

namespace Kregel\Ziptastic;

use Exception;
use Kregel\Ziptastic\Guzzle\ZiptasticRequest;

class Zipper extends ZiptasticRequest
{

    /**
     * This sets the country code for the call.
     *
     * @param $country
     *
     * @return Zipper
     */
    public function in($country)
    {
        $this->country = $country;

        return $this;
    }


    /**
     * Magically get the class variables and if they are not found throw an exception.
     *
     * @param $string
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function __get($string)
    {
        if ($this->has($string)) {
            return $this->$string;
        } elseif ( ! empty( $this->response )) {
            $decoded_response = json_decode($this->response)[0];
            if (isset( $decoded_response->$string )) {
                return $decoded_response->$string;
            }
        }
        throw new Exception("Undefined variable [$string]");
    }


    /**
     * Magically set the class variables and if they are not found throw an exception.
     * Otherwise set the variables to the requested value.
     *
     * @param $string
     * @param $args
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function __set($string, $args)
    {
        if ($this->has($string)) {
            $this->$string = $args;

            return $this;
        }
        throw new Exception("Undefined variable [$string]");
    }


    /**
     * Determine what the developer is trying to call on. If it doesn't exist throw an
     * exception to let them know their variable cannot be found.
     *
     * @param $name
     * @param $arguments
     *
     * @throws Exception
     *
     * @return bool|Zipper
     */
    public function __call($name, $arguments)
    {
        if (substr($name, 0, 4) === 'with') {
            return $this->resolveWith($name, $arguments);
        } elseif (substr(strtolower($name), 0, 7) === 'andwith') {
            return $this->resolveWith(lcfirst(trim($name, 'and')), $arguments);
        }
        throw new Exception("The method you called [$name] doesn't exist ");
    }


    /**
     * @param $with
     * @param $args
     *
     * @return bool|Zipper
     */
    private function resolveWith($with, $args)
    {

        $variable = ( substr($with, 4, strlen($with)) );

        $parts = preg_split('/(?<=[a-z])(?=[A-Z])/x', $variable);

        $variable = strtolower(implode('_', $parts));

        return $this->with($variable, $args);
    }


    /**
     * This is short hand for assigning variables to values.
     *
     * @param $variable
     * @param $value
     *
     * @return $this
     */
    public function with($variable, $value)
    {
        if (is_array($value)) {
            if (count($value) == 1) {
                $value = $value[0];
            }
        }
        $this->$variable = $value;

        return $this;
    }
}
