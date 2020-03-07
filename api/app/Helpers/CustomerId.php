<?php

if (!function_exists('customerId')) {

    class CustomerInfo
    {
        static protected $customerInfo = null;

        public function __construct()
        {
            if (static::$customerInfo === null) {
                static::$customerInfo = require(base_path() . '/customer.id');
            }
        }

        public function getInfo($key)
        {
            return static::$customerInfo[$key];
        }
    }

    /**
     * @param string $key
     * @return array
     */
    function customerInfo(string $key)
    {
        $customerInfo = new CustomerInfo();

        return $customerInfo->getInfo($key);
    }
}
