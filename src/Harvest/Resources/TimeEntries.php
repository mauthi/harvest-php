<?php

namespace Harvest\Resources;

use DateTime;
use Harvest\Api\Connection;

/**
 * Class Projects.
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
class TimeEntries extends AbstractResource implements ResourceInterface
{
    const HARVEST_PATH = 'time_entries';

    /**
     * @param string|DateTime $updatedSince
     */
    public function getAll($updatedSince = null): array
    {
        $this->_params['updated_since'] = $this->_appendUpdatedSinceParam($updatedSince);
        $this->_uri = self::HARVEST_PATH;

        return parent::getAll();
    }

    /**
     * @param string|DateTime $updatedSince
     */
    public function getCount($updatedSince = null, array $params = []): int
    {
        $this->_params['updated_since'] = $this->_appendUpdatedSinceParam($updatedSince);
        $this->_uri = self::HARVEST_PATH;

        return parent::getCount($params);
    }

    /**
     * @param int $page
     * @param string|DateTime $updatedSince
     * @return array
     */
    public function getPage(int $page, $updatedSince = null, array $params = []): array
    {
        $this->_params['updated_since'] = $this->_appendUpdatedSinceParam($updatedSince);
        $this->_uri = self::HARVEST_PATH;

        return parent::getPage($page, $params);
    }

    /**
     * @return array
     */
    public function getInactive(): array
    {
        // not available for this resource - so return empty string
        return '';
    }

    /**
     * @return array
     */
    public function getActive(): array
    {
        // not available for this resource - so return empty string
        return '';
    }
}
