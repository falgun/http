
# HTTP

HTTP Related Abstraction Layer for Falgun Framework.

## Install
 *Please note that PHP 7.4 or higher is required.*

Via Composer

``` bash
$ composer require falgunphp/http
```

## Basic Usage
Request Class is used to retrieve information about request:
```php
<?php
use Falgun\Http\Request;
// build request object from global variables
// eg. $_SERVER, $_GET, $_POST
$request = Request::createFromGlobals();

// get all headers
$request->headers()->all(); //array
// get a specific header
$request->headers()->get('Content_type'); // application/json

// get query data, like $_GET
$request->queryDatas()->get('id');
//get Post Data, like $_POST
$request->postDatas()->get('name');
// get uploaded file list, like $_FILE
$request->files()->all(); // array
// get cookies list, like $_COOKIE
$request->cookies()->all(); // array
```
Uri class can be used to get URL information:
```php
$uri = $request->uri();
$uri->getScheme(); // http
$uri->getHost(); // site.com
$uri->getPort(); // 80
$uri->getPath(); // /index.php
$uri->getQuery(); // ?foo=bar
$uri->getFragment(); // #bazz
$uri->getUserInfo();  // username:password
```

Response Class is used as a container of information that needs to be sent:
```php
use Falgun\Http\Response;

$response = new Response('hello world', 200, 'OK');
// set a header
$response->headers()->set('Content-Type', 'plain/text');

// Response can be built for json too
$response = Response::json(['name' => 'Falgun']);
$response->getBody(); // {"name": "Falgun"}
``` 
Use Session class to get/set session value:
```php
namespace Falgun\Http\Session;

$session = new Session();
$session->start(); // session started
$session->has('test'); // false
$session->set('test', 'foo');
$session->get('test'); // foo
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
