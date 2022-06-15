<?php
/**
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Crypto\CurrencyPrecision\Plugin\Directory;

use Magento\Directory\Model\Currency as BaseCurrency;
use Crypto\CurrencyPrecision\Plugin\BasePlugin;

class Currency extends BasePlugin
{
    public function beforeFormatPrecision(
        BaseCurrency $subject,
        ?float $price,
        ?int $precision,
        array $options = [],
        bool $includeContainer = true,
        bool $addBrackets = false
    ): array {
        if ($this->isCurrencyPrecision($subject->getCurrencyCode())) {
            $options['precision'] = $this->getCurrencyPrecision($subject->getCurrencyCode());
        }

        return [$price,
            $precision,
            $options,
            $includeContainer,
            $addBrackets];
    }
}
