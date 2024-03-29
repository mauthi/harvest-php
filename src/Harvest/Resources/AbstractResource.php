<?php

namespace Harvest\Resources;

use GuzzleHttp\Client as GuzzleClient;
use Harvest\Api\Connection;

/**
 * Class AbstractResource.
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
abstract class AbstractResource
{
    public const PER_PAGE = 100;
    private $_connection;
    protected $_uri;
    protected $_data;
    protected $_params = [];
    protected $_id = null;

    /**
     * AbstractResource constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
        $this->_uri = '';
        $this->_params['per_page'] = self::PER_PAGE;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $page = 1;
        $aReturn = [];
        $ressourceName = $this->_uri;

        do {
            $this->_params['page'] = $page;
            $uri = $this->_uri.'?'.http_build_query($this->_params);
            $aResult = json_decode($this->_connection->request('GET', $uri));
            $aReturn = array_merge($aReturn, $aResult->$ressourceName);
            $page++;
        } while ($aResult && $aResult->next_page);

        return $aReturn;
    }

    public function getCount(array $params = []): int
    {
        $uri = $this->_uri.'?'.http_build_query(array_merge($this->_params, $params));
        $aResult = json_decode($this->_connection->request('GET', $uri));

        if ($aResult) {
            return $aResult->total_entries;
        }

        return 0;
    }

    /**
     * @return array
     */
    public function getPage(int $page, array $params = []): array
    {
        $ressourceName = $this->_uri;

        $this->_params['page'] = $page;
        $uri = $this->_uri.'?'.http_build_query(array_merge($this->_params, $params));
        $aResult = json_decode($this->_connection->request('GET', $uri));

        return $aResult->$ressourceName;
    }

    public function getOne($id)
    {
        if (!$id) {
            return false;
        }

        $uri = $this->_uri.'/'.$id;
        $aResult = json_decode($this->_connection->request('GET', $uri));

        return $aResult;
    }

    /**
     * @return \stdClass|bool Array of created resource or false
     */
    public function create()
    {
        $options = [];
        $options['json'] = $this->_data;

        $response = $this->_connection->request('POST', $this->_uri, $options);

        if ($response->getStatusCode() == 201) {
            return json_decode((string) $response->getBody());
        }

        return false;
    }

    /**
     * @return \stdClass|bool Array of updated resource or false
     */
    public function update()
    {
        if (!$this->_id) {
            return false;
        }

        $uri = $this->_uri.'/'.$this->_id;

        $options = [];
        $options['json'] = $this->_data;
        $response = $this->_connection->request('PUT', $uri, $options);

        if ($response->getStatusCode() == 200) {
            return json_decode((string) $response->getBody());
        }

        return false;
    }

    /**
     * @param string|DateTime $updatedSince
     * @return bool|string
     */
    protected function _appendUpdatedSinceParam($updatedSince = null)
    {
        if (is_null($updatedSince)) {
            return null;
        } elseif ($updatedSince instanceof \DateTime) {
            $updatedSince->setTimezone(new \DateTimeZone('Z')); // convert to correct harvest intern timezone

            return $updatedSince->format(\DateTime::ISO8601);
        } else {
            return $updatedSince;
        }
    }

    protected function appendDateParam(DateTime $date): string
    {
        return $date->format('Y-m-d');
    }
}
