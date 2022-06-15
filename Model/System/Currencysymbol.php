<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\CurrencyPrecision\Model\System;

use Magento\Framework\Locale\Bundle\CurrencyBundle;
use Magento\CurrencySymbol\Model\System\Currencysymbol as BaseCurrencysymbol;

class Currencysymbol extends BaseCurrencysymbol
{
    /**
     * Return currency symbol properties array based on config values
     *
     * @return array
     */
    public function getCurrencySymbolsData()
    {
        if ($this->_symbolsData) {
            return $this->_symbolsData;
        }

        $this->_symbolsData = [];

        $currentSymbols = $this->_unserializeStoreConfig(self::XML_PATH_CUSTOM_CURRENCY_SYMBOL);

        foreach ($this->getAllowedCurrencies() as $code) {
            $currenciesObj = (new CurrencyBundle())->get($this->localeResolver->getLocale());
            //@phpstan-ignore-next-line
            $currencies = $currenciesObj['Currencies'];

            //overriden - added is null to avoid throw exception
            $symbol = !is_null($currencies[$code]) ? $currencies[$code][0]: $code;
            $name = !is_null($currencies[$code]) ? $currencies[$code][1]: $code;

            $this->_symbolsData[$code] = ['parentSymbol' => $symbol, 'displayName' => $name];

            if (isset($currentSymbols[$code]) && !empty($currentSymbols[$code])) {
                $this->_symbolsData[$code]['displaySymbol'] = $currentSymbols[$code];
            } else {
                $this->_symbolsData[$code]['displaySymbol'] = $this->_symbolsData[$code]['parentSymbol'];
            }
            $this->_symbolsData[$code]['inherited'] =
                ($this->_symbolsData[$code]['parentSymbol'] == $this->_symbolsData[$code]['displaySymbol']);
        }

        return $this->_symbolsData;
    }
}
