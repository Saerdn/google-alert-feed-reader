<?php
/**
 * Author: Andreas Geisler
 * Date: 05.06.16
 *
 * Description:
 * Class to send requests to a given source.
 */
namespace Google;


class Request {

    // Store data that has already been read from an url
    private $urlData = [];

    /**
     * Read data of a given URL and return result as a string.
     * TODO: TEST getDataFromUrl must always return string
     *
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function getDataFromUrl($url = '') {
        if( empty($url) ) {
            throw new \Exception("Empty url in request");
        }
        $xmlString = self::_fetchUrl($url);
        $this->urlData[$url] = $xmlString;

        return $xmlString;
    }

    /**
     * Read data of a given URL and return result as an object.
     * TODO: TEST getDataAsObjectFromUrl must always return \SimpleXMLElement
     *
     * @param string $url
     * @return \SimpleXMLElement object
     * @throws \Exception
     */
    public function getDataAsObjectFromUrl($url = '') {
        if( empty($url) ) {
            throw new \Exception("Empty url in request");
        }

        if( !isset($this->urlData[$url]) ) {
            $this->getDataFromUrl($url);
        }

        $xmlAsObject = simplexml_load_string ($this->urlData[$url]);

        return $xmlAsObject;
    }

    /**
     * Do a simple cUrl query
     *
     * @param string $url
     * @return mixed
     */
    private static function _fetchUrl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $feedData = curl_exec($ch);
        curl_close($ch);

        // TODO: Handle errors

        return $feedData;
    }

}