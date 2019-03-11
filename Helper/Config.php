<?php
/**
 *
 * @category    Dito
 * @package     Dito_Magento2module
 * @author      Tannus Esquerdo <tannus.esquerdo@dito.com.br>
 */

namespace Dito\Magento2module\Helper;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const DITO_ENABLED_CONFIG_PATH              = "aplication/Magento2module/dito_enabled";
    const APP_KEY_CONFIG_PATH                   = "aplication/Magento2module/app_key";
    const APP_SECRET_CONFIG_PATH                = "aplication/Magento2module/app_secret";
    const SEND_REVENUE_CONFIG_PATH              = "events/Magento2module/send_revenue";
    const USER_ID_CONFIG_PATH                   = "users/Magento2module/user_id";

    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return boolean
     */
    public function isDitoEnabled()
    {
        return (boolean) $this->scopeConfig->getValue(self::DITO_ENABLED_CONFIG_PATH);
    }

    /**
     * @return string
     */
    public function getAppKey()
    {
        return (string) $this->scopeConfig->getValue(self::APP_KEY_CONFIG_PATH);
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return (string) $this->scopeConfig->getValue(self::APP_SECRET_CONFIG_PATH);
    }

    /**
     * @return boolean
     */
    public function getTrackStatus($key)
    {
        return (boolean) $this->scopeConfig->getValue('events/Magento2module/' . $key);
    }

    /**
     * @return boolean
     */
    public function isIdTypeCpf()
    {
        return (boolean) $this->scopeConfig->getValue(self::USER_ID_CONFIG_PATH);
    }

    /**
     * @return boolean
     */
    public function sendRevenue()
    {
        return (boolean) $this->scopeConfig->getValue(self::SEND_REVENUE_CONFIG_PATH);
    }

    /**
     * @return string
     */
    public function getUserDataConfig($key)
    {
        return (string) $this->scopeConfig->getValue('users/Magento2module/' . $key);
    }

    /**
     * @return string
     */
    public function getCoreData($key)
    {
        return (string) $this->scopeConfig->getValue($key, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}