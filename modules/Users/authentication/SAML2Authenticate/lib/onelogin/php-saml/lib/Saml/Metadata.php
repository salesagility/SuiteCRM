<?php

class OneLogin_Saml_Metadata
{
    const VALIDITY_SECONDS = 604800; // 1 week

    protected $_settings;

    /**
     * @param array|object|null $settings Setting data
     */
    public function __construct($settings = null)
    {
        $auth = new OneLogin_Saml2_Auth($settings);
        $this->_settings = $auth->getSettings();
    }

    /**
     * @return string
     *
     * @throws OneLogin_Saml2_Error
     */
    public function getXml()
    {
        return $this->_settings->getSPMetadata();
    }

    /**
     * @return string
     */
    protected function _getMetadataValidTimestamp()
    {
        $timeZone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $time = strftime("%Y-%m-%dT%H:%M:%SZ", time() + self::VALIDITY_SECONDS);
        date_default_timezone_set($timeZone);
        return $time;
    }
}
