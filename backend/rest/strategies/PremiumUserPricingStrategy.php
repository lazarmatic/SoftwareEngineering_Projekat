<?php

require_once __DIR__ . '/RentalPricingStrategy.php';

/**
 * Premium User Pricing Strategy - Concrete Strategy
 * Calculates price with 15% discount for premium/loyal users
 */
class PremiumUserPricingStrategy implements RentalPricingStrategy
{
    /**
     * Premium pricing: 15% discount on final price
     */
    public function calculatePrice($daily_rate, $days)
    {
        $base_price = $daily_rate * $days;
        $discount = $base_price * 0.15; // 15% discount
        return $base_price - $discount;
    }
}
