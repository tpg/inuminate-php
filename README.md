# Inuminate PHP client

Inuminate is a privacy first, cookie-free web traffic monitor and analyser.

If you don't want to use our JavaScript tracker, or it's not an option, you can use our PHP client. 

Install with Composer:

```shell
composer require thepublicgood/inuminate
```

## Usage

Add the following somewhere in your application that is run with every request. A middleware or a global route handler are good ideas.

```php
use TPG\Inuminate\Inuminate;

$inuminate = new Inuminate('INUMINATE_SITE_KEY');
$inuminate->track();
```

That's it.

Note that the request to Inuminate is completed within the web request which may have an impact on performance. If this isn't acceptable, either opt for our JavaScript tracker, or you'll need to run some sort of queue.
