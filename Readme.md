Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
 composer require payourself2/monobank-bundle 
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require payourself2/monobank-bundle 
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Payourself2\Bundle\MonobankBundle\MonobankBundle::class => ['all' => true],
];
```

Configuration
============
### Add parameters
#### If you are going to use personal api:
```yaml
parameters:
    payourself2_monobank_api_base_path: 'https://api.monobank.ua'
    payourself2_monobank_personal_key: '%env(PAYOURSELF2_MONOBANK_PERSONAL_KEY)%'
 ```

#### If you are going to use corporate api:
```yaml
parameters:
    payourself2_monobank_pub_key: '%env(PAYOURSELF2_MONOBANK_PUB_KEY)%'
    payourself2_monobank_priv_key: '%env(PAYOURSELF2_MONOBANK_PRIV_KEY)%'
 ```

redefine your payourself2_monobank_send_request_adapter 
```yaml
services:
    payourself2_monobank_send_request_adapter:
        class: Payourself2\Bundle\MonobankBundle\Adapter\SymfonyClientAdapter
        autowire: true
        autoconfigure: true
 ```

## Docs
### main
https://api.monobank.ua/docs
### sign
https://gist.github.com/Sominemo/64845669d6326f2f73d356f025656bdb#file-mono-corp-api-signing-ru-md
