<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\CurrencyPrecision\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class CurrencyChecker
{
    public const CONFIG_PATH_CURRENCY_PRECISION = 'system/currency/%s/precision';
    public const DEFAULT_PRECISION = 2;
    private ScopeConfigInterface $scopeConfig;
    private StoreManagerInterface $storeManager;
    private array $currencies = [];

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function getCurrencyCode(): string
    {
        /** @var Store $store */
        $store = $this->storeManager->getStore();

        return $store->getCurrentCurrency()->getCode();
    }

    public function getCurrencyPrecision(?string $code = null): int
    {
        return $this->getCurrencyPrecisionConfig($code) !== null ?
            $this->getCurrencyPrecisionConfig($code) :
            self::DEFAULT_PRECISION;
    }

    public function getCurrencyPrecisionConfig(?string $code = null): ?int
    {
        if (!$code) {
            $code = $this->getCurrencyCode();
        }

        $configField = sprintf(self::CONFIG_PATH_CURRENCY_PRECISION, $code);

        if (!isset($this->currencies[$code])) {
            $this->currencies[$code] = $this->scopeConfig->getValue($configField);
        }

        return (int) $this->currencies[$code];
    }

    public function isCurrencyPrecision(?string $code = null): bool
    {
        return $this->getCurrencyPrecisionConfig($code) === null ? false : true;
    }
}
