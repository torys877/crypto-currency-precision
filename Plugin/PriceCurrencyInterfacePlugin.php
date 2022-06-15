<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\CurrencyPrecision\Plugin;

use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\App\ScopeInterface;
use Magento\Framework\Model\AbstractModel;

class PriceCurrencyInterfacePlugin extends BasePlugin
{
    public function beforeRoundPrice(
        PriceCurrencyInterface $subject,
        float $price,
        int $precision = 2
    ): array {
        if (!$this->isCurrencyPrecision()) {
            return [$price, $precision];
        }

        return [$price, 5];
    }

    public function aroundRound(
        PriceCurrencyInterface $subject,
        callable $proceed,
        float $price
    ): float {
        if (!$this->isCurrencyPrecision() || !$price) {
            return $proceed($price);
        }

        return round($price, 5);
    }

    /**
     * @param PriceCurrencyInterface $subject
     * @param callable $proceed
     * @param float $amount
     * @param bool $includeContainer
     * @param int $precision
     * @param string|bool|int|ScopeInterface|null $scope
     * @param AbstractModel|string|null $currency
     * @return string
     */
    public function aroundFormat(
        PriceCurrencyInterface $subject,
        callable $proceed,
        float $amount,
        bool $includeContainer = true,
        int $precision = PriceCurrencyInterface::DEFAULT_PRECISION,
        $scope = null,
        $currency = null
    ): string {
        if (!$this->isCurrencyPrecision()) {
            return $proceed($amount,
                $includeContainer,
                $precision,
                $scope,
                $currency);
        }

        return $proceed($amount,
            $includeContainer,
            $this->getCurrencyPrecision(),
            $scope,
            $currency);
    }
}
