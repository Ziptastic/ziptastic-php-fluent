# Ziptastic PHP with Guzzle

This package was brought into existence because of [this package](https://github.com/Ziptastic/ziptastic-php), specifically because of the [first enhancement](https://github.com/Ziptastic/ziptastic-php/issues/1)

This library is a [Guzzle](http://docs.guzzlephp.org/en/latest/) based interface for the [Ziptastic API](https://getziptastic.com/).

Using Ziptastic requires an API key, you can get one by signing up with Ziptastic.

## Installing

Ziptastic PHP can be installed via composer:

````
composer require ziptastic/guzzle
````

## Usage

There are two different ways to use this package with the same end result.

The first way to use this is by using `Zipper` which will be using a more "plain english" oriented syntax
````php
<?php

include "vendor/autoload.php";

use Ziptastic\Guzzle\Zipper;

$key = 'Your Api Key from ziptastic';

$results = (new Zipper)->in('US')->withPostalCode(48867)->andWithKey($key)->find();
echo $results->response;
?>
````

If that isn't your cup of tea or you just want to get things done, you can use `Ziptastic`

````php
<?php

include "vendor/autoload.php";

use Ziptastic\Guzzle\Ziptastic;

$key = 'Your Api Key from ziptastic';

$results = (new Ziptastic(23042,'us'))->setKey($key)->find();

echo $results->response;
?>
````

## Using results
If you wanted to, you can access any and all of the results of the api call via calling the item you want from the api response.
The first way to use this is by using `Zipper` which will be using a more "plain english" oriented syntax
````php
<?php

include "vendor/autoload.php";

use Ziptastic\Guzzle\Zipper;

$key = 'Your Api Key from ziptastic';

$results = (new Zipper)->in('US')->withPostalCode(48867)->andWithKey($key)->find();
echo $results->city, ', ',$results->state,' ',$results->postal_code;
?>
````
And in that example the only one set by default is the postal code, the others are from the response.


Ziptastic PHP is licensed under the [MIT license](https://opensource.org/licenses/MIT/).
