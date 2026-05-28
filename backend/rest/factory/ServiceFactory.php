<?php

/**
 * Service Factory - Factory Pattern Implementation
 * Centralizes the creation of service instances
 * Makes it easy to manage dependencies and configurations in one place
 */
class ServiceFactory
{
    private static $services = [];

    /**
     * Create and return a service instance
     * Uses a simple singleton pattern to reuse instances
     * 
     * @param string $serviceClass The class name of the service to create
     * @return object The service instance
     */
    public static function createService($serviceClass)
    {
        // Return cached instance if exists
        if (isset(self::$services[$serviceClass])) {
            return self::$services[$serviceClass];
        }

        // Create new instance and cache it
        $service = new $serviceClass();
        self::$services[$serviceClass] = $service;
        return $service;
    }

    /**
     * Create a book service
     */
    public static function createBookService()
    {
        return self::createService('bookService');
    }

    /**
     * Create a book rental service
     */
    public static function createBookRentalService()
    {
        return self::createService('bookRentalService');
    }

    /**
     * Create a book store service
     */
    public static function createBookStoreService()
    {
        return self::createService('bookStoreService');
    }

    /**
     * Create a book review service
     */
    public static function createBookReviewService()
    {
        return self::createService('bookReviewService');
    }

    /**
     * Create a user service
     */
    public static function createUserService()
    {
        return self::createService('userService');
    }

    /**
     * Create an auth service
     */
    public static function createAuthService()
    {
        return self::createService('AuthService');
    }

    /**
     * Clear all cached services (useful for testing)
     */
    public static function clearCache()
    {
        self::$services = [];
    }
}
