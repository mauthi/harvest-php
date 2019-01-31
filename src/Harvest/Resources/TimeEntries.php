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
    const HARVEST_PATH = 'time_entries';

    /**
     * @param string|DateTime $updatedSince
     * @return string
     */
    public function getAll($updatedSince = null)
    {
        $this->_params["updated_since"] = $this->_appendUpdatedSinceParam($updatedSince);
        $this->_uri = self::HARVEST_PATH;
        return parent::getAll();
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