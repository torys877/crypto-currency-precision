<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\CurrencyPrecision\Block;

use Magento\Framework\Locale\Bundle\CurrencyBundle as CurrencyBundle;
use Magento\Directory\Block\Currency as BaseCurrencyBlock;
use Magento\Store\Model\Store;

class Currency extends BaseCurrencyBlock
{
    /**
     * Retrieve currencies array
     * Return array: code => currency name
     * Return empty array if only one currency
     *
     * @return array
     */
    public function getCurrencies(): array
    {
        $currencies = $this->getData('currencies');
        if ($currencies === null) {
            $currencies = [];
            /** @var Store $store */
            $store = $this->_storeManager->getStore();
            $codes = $store->getAvailableCurrencyCodes(true);
            if (is_array($codes) && count($codes) > 1) {
                //@phpstan-ignore-next-line
                $rates = $this->_currencyFactory->create()->getCurrencyRates($store->getBaseCurrency(), $codes);

                foreach ($codes as $code) {
                    if (isset($rates[$code])) {
                        $allCurrenciesObj = (new CurrencyBundle())->get(
                            $this->localeResolver->getLocale()
                        );
                        //@phpstan-ignore-next-line
                        $allCurrencies = $allCurrenciesObj['Currencies'];
                        //overriden - added is null to avoid throw exception
                        $currencies[$code] = !is_null($allCurrencies[$code]) ? $allCurrencies[$code][1]: $code;
                    }
                }
            }

            $this->setData('currencies', $currencies);
        }
        return $currencies;
    }
}
