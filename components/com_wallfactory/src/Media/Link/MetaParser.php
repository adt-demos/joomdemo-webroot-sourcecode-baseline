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

namespace ThePhpFactory\Wall\Media\Link;

defined('_JEXEC') or die;

class MetaParser
{
    private $xpath;

    public function parseUrl($url)
    {
        $data = $this->readUrl($url);

        return $this->parse($data);
    }

    private function readUrl($url)
    {
        $agent = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $agent);

        $response = curl_exec($curl);

        $error = curl_error($curl);
        $errno = curl_errno($curl);

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($errno) {
            throw new \Exception($error);
        }

        if (200 !== $statusCode) {
            throw new \Exception(sprintf('Http status code "%s"!', $statusCode));
        }

        return $response;
    }

    public function parse($html)
    {
        if ('' === (string)trim($html)) {
            throw new \Exception('Html is empty!');
        }

        $dom = new \DOMDocument();

        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors($internalErrors);

        $this->xpath = new \DOMXpath($dom);
    }

    public function getTitle()
    {
        if ($title = $this->query('//title')->item(0)) {
            return $title->nodeValue;
        }

        if ($title = $this->query('//meta[@property="og:title"]/@content')->item(0)) {
            return $title->nodeValue;
        }

        return null;
    }

    private function query($expression)
    {
        return $this->xpath->query($expression);
    }

    public function getDescription()
    {
        if ($title = $this->query('//meta[@name="description"]/@content')->item(0)) {
            return $title->nodeValue;
        }

        if ($title = $this->query('//meta[@property="og:description"]/@content')->item(0)) {
            return $title->nodeValue;
        }

        return null;
    }
}
