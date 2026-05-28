<?php

require_once __DIR__ . '/RentalPricingStrategy.php';

/**
 * Long-Term Pricing Strategy - Concrete Strategy
 * Calculates price with progressively better rates for longer rental periods
 * - 3-7 days: 10% discount
 * - 8-14 days: 20% discount
 * - 15+ days: 25% discount
 */
class LongTermPricingStrategy implements RentalPricingStrategy
{
    /**
     * Long-term pricing with sliding scale discounts
     */
    public function calculatePrice($daily_rate, $days)
    {
        $base_price = $daily_rate * $days;
        $discount_rate = 0;

        if ($days >= 15) {
            $discount_rate = 0.25; // 25% discount
        } elseif ($days >= 8) {
            $discount_rate = 0.20; // 20% discount
        } elseif ($days >= 3) {
            $discount_rate = 0.10; // 10% discount
        }

        $discount = $base_price * $discount_rate;
        return $base_price - $discount;
    }
}
