<?php
/**
 *
 * @category    Dito
 * @package     Dito_Magento2module
 * @author      Tannus Esquerdo <tannus.esquerdo@dito.com.br>
 */

namespace Dito\Magento2module\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    const DITO_ENABLED_CONFIG_PATH              = "dito/Magento2module/dito_enabled";
    const APP_KEY_CONFIG_PATH                   = "dito/Magento2module/app_key";
    const APP_SECRET_CONFIG_PATH                = "dito/Magento2module/app_secret";
    const SEND_REVENUE_CONFIG_PATH              = "dito/Magento2module/send_revenue";
    const USER_ID_CONFIG_PATH                   = "dito/Magento2module/user_id";

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
        return (boolean) $this->scopeConfig->getValue('dito/Magento2module/' . $key);
    }

    /**
     * @return boolean
     */
    public function getIdType()
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
        return (string) $this->scopeConfig->getValue('dito/Magento2module/' . $key);
    }
}