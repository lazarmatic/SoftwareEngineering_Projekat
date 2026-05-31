<?php
require_once 'baseService.php';
//require_once '../dao/bookRentalDao.php';
//require_once 'C:\xampp\htdocs\webprojekat\backend\rest\dao\bookRentalDao.php';
require_once __DIR__ . '/../dao/bookRentalDao.php';

// Strategy Pattern - Import pricing strategies
require_once __DIR__ . '/../strategies/RentalPricingStrategy.php';
require_once __DIR__ . '/../strategies/StandardPricingStrategy.php';
require_once __DIR__ . '/../strategies/PremiumUserPricingStrategy.php';
require_once __DIR__ . '/../strategies/LongTermPricingStrategy.php';

class bookRentalService extends BaseService
{
    private $pricingStrategy;

    public function __construct()
    {
        $dao = new bookRentalDao();
        parent::__construct($dao);
        // Default to standard pricing strategy
        $this->pricingStrategy = new StandardPricingStrategy();
    }

    /**
     * Set the pricing strategy to use for rental calculations
     * Strategy Pattern Implementation
     */
    public function setPricingStrategy(RentalPricingStrategy $strategy)
    {
        $this->pricingStrategy = $strategy;
    }

    /**
     * Calculate rental price using the current pricing strategy
     * 
     * @param float $daily_rate Daily rental rate
     * @param int $days Number of days
     * @return float Calculated price
     */
    public function calculateRentalPrice($daily_rate, $days)
    {
        return $this->pricingStrategy->calculatePrice($daily_rate, $days);
    }

    public function getRentalByUserId($user_id)
    {
        return $this->dao->getRentalByUserId($user_id);
    }
    public function getRentalByBookId($book_id)
    {
        return $this->dao->getRentalByBookId($book_id);
    }
    public function getByRentalID($rental_id)
    {
        return $this->dao->getByRentalID($rental_id);
    }
}
