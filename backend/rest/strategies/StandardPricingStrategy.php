<?php

require_once __DIR__ . '/RentalPricingStrategy.php';

/**
 * Standard Pricing Strategy - Concrete Strategy
 * Calculates price as: daily_rate * days
 */
class StandardPricingStrategy implements RentalPricingStrategy
{
    /**
     * Standard pricing: no discount
     */
    public function calculatePrice($daily_rate, $days)
    {
        return $daily_rate * $days;
    }
}
