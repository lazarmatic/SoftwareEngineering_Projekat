<?php

/**
 * Strategy Pattern Interface for Rental Pricing
 * Allows different pricing strategies based on rental duration or customer type
 */
interface RentalPricingStrategy
{
    /**
     * Calculate rental price based on daily rate and rental duration
     * 
     * @param float $daily_rate The daily rental rate
     * @param int $days Number of days for rental
     * @return float The calculated price
     */
    public function calculatePrice($daily_rate, $days);
}
