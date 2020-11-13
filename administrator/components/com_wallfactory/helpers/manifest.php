<?php

/**
-------------------------------------------------------------------------
wallfactory - Wall Factory 4.1.8
-------------------------------------------------------------------------
 * @author thePHPfactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thePHPfactory.com
 * Technical Support: Forum - http://www.thePHPfactory.com/forum/
-------------------------------------------------------------------------
*/

defined('_JEXEC') or die;

class WallFactoryManifest
{
    /** @var SimpleXMLElement */
    private $xml;
    private $installationManifest;
    private $option = null;
    private $component = null;

    public function __construct()
    {
        $this->installationManifest = JInstaller::parseXMLInstallFile(
            JPATH_ADMINISTRATOR . '/components/' . $this->getOption() . '/' . $this->getComponent() . '.xml'
        );

        $this->xml = simplexml_load_string(
            $this->fetchUrl('http://thephpfactory.com/versions/' . $this->getOption() . '.xml')
        );
    }

    private function getOption()
    {
        if (null === $this->option) {
            $this->option = 'com_' . $this->getComponent();
        }

        return $this->option;
    }

    private function getComponent()
    {
        if (null === $this->component) {
            $this->component = strtolower(str_replace('Manifest', '', get_class($this)));
        }

        return $this->component;
    }

    private function fetchUrl($url)
    {
        $cache = JPATH_CACHE . '/' . md5($url);

        if (!file_exists($cache) || time() - filemtime($cache) > 60 * 60) {
            $handle = curl_init();

            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_MAXREDIRS, 5);
            curl_setopt($handle, CURLOPT_AUTOREFERER, 1);
            curl_setopt($handle, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_TIMEOUT, 10);

            $response = curl_exec($handle);

            curl_close($handle);

            file_put_contents($cache, $response);
        }

        return file_get_contents($cache);
    }

    public function isUpdateAvailable()
    {
        return version_compare($this->getLatestVersion(), $this->getCurrentVersion(), '>');
    }

    public function getLatestVersion()
    {
        return $this->xml->latestversion;
    }

    public function getCurrentVersion()
    {
        return $this->installationManifest['version'];
    }

    public function getSupportAndUpdates()
    {
        return $this->xml->downloadlink;
    }

    public function getOtherProducts()
    {
        return $this->xml->otherproducts;
    }

    public function getAboutCompany()
    {
        return $this->xml->aboutfactory;
    }

    public function getVersionHistory()
    {
        return $this->xml->versionhistory;
    }
}
