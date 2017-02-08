<?php

namespace Ziptastic\Guzzle;

use Exception;
use Ziptastic\Guzzle\Guzzle\ZiptasticRequest;

class Zipper extends ZiptasticRequest
{
    /**
     * This sets the country code for the call.
     *
     * @param string $country
     *
     * @return Zipper
     */
    public function in($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Determine what the developer is trying to call on. If it doesn't exist throw an
     * exception to let them know their variable cannot be found.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @throws Exception
     *
     * @return bool|Zipper
     */
    public function __call($name, $arguments)
    {
        // Check to see if the method called is able to be resolved,
        // Current supported method are with(), andWidth(), and and()
        // If the method cannot be resolved, throw an exception
        if (substr($name, 0, 4) === 'with') {
            return $this->resolveWith($name, $arguments);
        } elseif (substr(strtolower($name), 0, 7) === 'andwith') {
            return $this->resolveWith(lcfirst(trim($name, 'and')), $arguments);
        } elseif (method_exists($this, $name)) {
            return $this->$name($arguments);
        }
        throw new Exception("The method you called [$name] doesn't exist ");
    }

    /**
     * @param $with
     * @param $args
     *
     * @return Zipper
     */
    private function resolveWith($with, $args)
    {
        // Remove the word "with" so we can get what we really want, the
        // function or the attribute we really want.
        $variable = (substr($with, 4, strlen($with)));

        // Split the capital and lower cased words, so if someone passes a PostalCode
        // We can resolve it to postal_code
        $parts = preg_split('/(?<=[a-z])(?=[A-Z])/x', $variable);

        // Here we change the array of parts into just one word and glue them together with
        // and underscore, which follows the desired name convention.
        $variable = strtolower(implode('_', $parts));

        // Call and return with
        return $this->with($variable, $args);
    }

    /**
     * This is short hand for assigning variables to values.
     *
     * @param $variable
     * @param $value
     *
     * @return Zipper
     */
    public function with($variable, $value)
    {
        // If the variable is an array with a singel value we just want that value,
        // So we grab the first element and set it equal to the value. Otherwise we just
        // Pass the value through.
        if (is_array($value)) {
            // If the count is more than 1 we should assume that we're dealing with coordinates.
            if (count($value) == 1) {
                $value = $value[0];
            }
        }
        $this->$variable = $value;

        return $this;
    }
}
