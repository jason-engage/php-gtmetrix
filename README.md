# GTMetrix API 2.0 client for PHP

## Installing

Fork and ask ChatGPT how to install to composer using custom dev repository

Rebuilt for API 2.0 using philcook/gtmetrix - it is not backwards compatible and will break existing code.

## Using

```php
use LightningStudio\GTMetrixClient\GTMetrixClient;

$client = new GTMetrixClient();
$client->setAPIKey('your-gtmetrix-api-key');
   
try {
    $test = $client->startTest($url);
    echo $test;
    var_dump($test->getData());
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

```

## Update information

From version 2.0 references to Entrecore have been replace with LightningStudio due to Entrecore no longer existing and therefore avoiding confusion for users. 
