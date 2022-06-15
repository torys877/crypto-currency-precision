<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\CurrencyPrecision\Plugin;

use Magento\Framework\Registry;
use Crypto\CurrencyPrecision\Helper\CurrencyChecker;
use Magento\Sales\Api\Data\OrderInterface;

class BasePlugin
{

    private CurrencyChecker $currencyChecker;
    private Registry $coreRegistry;

    public function __construct(
        CurrencyChecker $currencyChecker,
        Registry $coreRegistry
    ) {
        $this->currencyChecker = $currencyChecker;
        $this->coreRegistry = $coreRegistry;
    }

    public function getCurrencyPrecision(?string $code = null): int
    {
        return $this->currencyChecker->getCurrencyPrecision($this->getCode($code));
    }

    public function isCurrencyPrecision(?string $code = null): bool
    {
        return $this->currencyChecker->isCurrencyPrecision($this->getCode($code));
    }

    protected function getCode(?string $code = null): ?string
    {
        /** @var ?OrderInterface $order */
        $order = $this->coreRegistry->registry('sales_order') ??
            $this->coreRegistry->registry('current_order');

        if (!$code && $order && $order instanceof OrderInterface) {
            $code = $order->getOrderCurrencyCode();
        }

        return $code;
    }
}
