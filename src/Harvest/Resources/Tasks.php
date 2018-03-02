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
        $all = json_decode($this->getAll(), true);
        $actives = array_filter($all, function ($data) {
            return $data['task']['deactivated'] == true;
        });

        return $actives;
    }

    /**
     * @return string
     */
    public function getActive()
    {
        $all = json_decode($this->getAll(), true);
        $actives = array_filter($all, function ($data) {
            return $data['task']['deactivated'] == false;
        });

        return $actives;
    }

}