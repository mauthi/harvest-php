<?php

namespace Harvest\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Harvest\Api\Connection;

/**
 * Class AbstractResource
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
abstract class AbstractResource
{
    private $_connection;
    protected $_uri;
    protected $_data;

    /**
     * AbstractResource constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
        $this->_uri = '';
    }

    /**
     * @return string
     */
    public function getAll()
    {
        return $this->_connection->request('GET', $this->_uri);
    }

    /**
     * @return array Array of created resource or false
     */
    public function create()
    {
        $options = array();
        $options['json'] = $this->_data;
        $response = $this->_connection->request('POST', $this->_uri, $options);
        if ($response->getStatusCode() == 201 && $location = $this->getLocationFromResponse($response)) {
            return $this->_connection->request('GET', $location);
        } 
        return false;
    }


    private function getLocationFromResponse($response) 
    {
        $aLocation = $response->getHeader("Location");
        if (isset($aLocation[0]))
            return $aLocation[0];

        return false;
    }


    /**
     * @return array Array of updated resource or false
     */
    public function update()
    {
        $options = array();
        $options['json'] = $this->_data;
        $response = $this->_connection->request('PUT', $this->_uri, $options);
        if ($response->getStatusCode() == 200 && $location = $this->getLocationFromResponse($response)) {
            return $this->_connection->request('GET', $location);
        } 
        return false;
    }

    /**
     * @param string|DateTime $updatedSince
     * @return bool|string
     */
    protected function _appendUpdatedSinceParam($updatedSince = null)
    {
        if( is_null($updatedSince) ) {
            return false;
        } else if( $updatedSince instanceOf \DateTime ) {
            $updatedSince->setTimezone(new \DateTimeZone('Z')); // convert to correct harvest intern timezone
            return $updatedSince->format("Y-m-d G:i:s");
        } else {
            return $updatedSince;
        }
    }
}