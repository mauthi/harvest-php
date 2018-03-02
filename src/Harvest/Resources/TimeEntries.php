<?php

namespace Harvest\Resources;

use DateTime;
use Harvest\Api\Connection;

/**
 * Class Projects
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
class TimeEntries extends AbstractResource implements ResourceInterface 
{
    const HARVEST_PATH = 'entries';

    /**
     * @param string $basePath
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|DateTime $updatedSince
     * @return string
     */
    private function getAllWithParams($basePath, $dateFrom, $dateTo = null, $updatedSince = null)
    {
        $this->_params["from"] = $dateFrom;
        $this->_params["to"] = $dateTo;
        $this->_params["updated_since"] = $this->_appendUpdatedSinceParam($updatedSince);
        $this->_uri = self::HARVEST_PATH;
        return parent::getAll();
    }

    /**
     * @param integer $userId
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|DateTime $updatedSince
     * @return string
     */
    public function getAllForUser($userId, $dateFrom, $dateTo = null, $updatedSince = null)
    {
        $this->_params["user_id"] = $userId;
        return $this->getAllWithParams($basePath, $dateFrom, $dateTo, $updatedSince);
    }

    /**
     * @param integer $projectId
     * @param string $dateFrom
     * @param string $dateTo
     * @param string|DateTime $updatedSince
     * @return string
     */
    public function getAllForProject($projectId, $dateFrom, $dateTo = null, $updatedSince = null)
    {
        $this->_params["project_id"] = $projectId;
        return $this->getAllWithParams($basePath, $dateFrom, $dateTo, $updatedSince);
    }

    /**
     * @return string
     */
    public function getInactive()
    {
        // not available for this resource - so return empty string
        return "";
    }

    /**
     * @return string
     */
    public function getActive()
    {
        // not available for this resource - so return empty string
        return "";
    }
}