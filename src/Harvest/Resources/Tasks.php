<?php

namespace Harvest\Resources;

use Harvest\Api\Connection;

/**
 * Class Tasks
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
class Tasks extends AbstractResource implements ResourceInterface
{
    const HARVEST_PATH = 'tasks';

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
        $this->_params["is_active"] = false;
        return $this->getAll();
    }

    /**
     * @return string
     */
    public function getActive()
    {
        $this->_params["is_active"] = true;
        return $this->getAll();
    }

}