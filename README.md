# CurrencyPrecision Magento 2 Extension

## Description

Module manages custom currency precisions and add possibility to change default currency precision.

## Installation

To install module you need to add repositories to your `composer.json`:

```angular2html
    "repositories": {
        "crypto-currency-precision": {
            "type": "git",
            "url": "git@github.com:torys877/crypto-currency-precision.git"
        }
    }
```

Or add repositories in console:

`composer config repositories.crypto-currency-precision git git@github.com:torys877/crypto-currency-precision.git`

Install module:

`composer require cryptom2/currency-precision:v1.0.0`

And run

```angular2html
php bin/magento setup:upgrade
```

## Example Of Usage

To set precision it needs to create `config.xml` in `etc` module directory and add next config:

```
<default>
    <system>
        <currency>
            <ETH>
                <precision>5</precision>
            </ETH>
        </currency>
    </system>
</default>`
```

## Author

### Ihor Oleksiienko

* [Github](https://github.com/torys877)
* [Linkedin](https://www.linkedin.com/in/igor-alekseyenko-77613726/)
* [Facebook](https://www.facebook.com/torysua/)
