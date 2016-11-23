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
class Projects extends AbstractResource implements ResourceInterface
{
    const HARVEST_PATH = 'projects';
    const RESOURCE_NAME = 'project';

    /**
     * @param integer $clientId
     * @param string|DateTime $updatedSince
     * @return string
     */
    public function getAll($clientId = null, $updatedSince = null)
    {
        $newUri = null;

        $newUri = '?' . http_build_query(array('client' => $clientId, 'updated_since' => $this->_appendUpdatedSinceParam($updatedSince)));

        $this->_uri = self::HARVEST_PATH . $newUri;
        return parent::getAll();
    }

    /**
     * @return string
     */
    public function getInactive()
    {
        $all = json_decode($this->getAll(), true);
        $actives = array_filter($all, function ($data) {
            return $data['project']['active'] == false;
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
            return $data['project']['active'] == true;
        });

        return $actives;
    }

    /**
     * @param array $data
     * @return string 
     */
    public function createProject(array $data) {
        $this->_uri = self::HARVEST_PATH;

        $this->_data = array();
        $this->_data[self::RESOURCE_NAME] = $data;
        return parent::create();
    }

    /**
     * @param array $data
     * @return string 
     */
    public function updateOrCreateProject($id, array $data) {
        if (is_null($id))
            return $this->createProject($data);
        else
            return $this->updateProject($id, $data);
    }


    /**
     * @param array $data
     * @return string 
     */
    public function updateProject($id, array $data) {
        $this->_uri = self::HARVEST_PATH."/{$id}";

        $this->_data = array();
        $this->_data[self::RESOURCE_NAME] = $data;
        return parent::update();
    }
}