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
class Projects extends AbstractResource implements ResourceInterface
{
    const HARVEST_PATH = 'projects';
    const RESOURCE_NAME = 'project';

    /**
     * @param int $clientId
     * @param string|\DateTime $updatedSince
     * @return array
     */
    public function getAll($clientId = null, $updatedSince = null): array
    {
        $this->_params['updated_since'] = $this->_appendUpdatedSinceParam($updatedSince);
        $this->_params['client_id'] = $clientId;
        $this->_uri = self::HARVEST_PATH;

        return parent::getAll();
    }

    /**
     * @return array
     */
    public function getInactive(): array
    {
        $all = json_decode($this->getAll(), true);
        $actives = array_filter($all, function ($data) {
            return $data['project']['active'] == false;
        });

        return $actives;
    }

    /**
     * @return array
     */
    public function getActive(): array
    {
        $all = json_decode($this->getAll(), true);
        $actives = array_filter($all, function ($data) {
            return $data['project']['active'] == true;
        });

        return $actives;
    }

    /**
     * @param array $data
     * @return \stdClass|bool
     */
    public function createProject(array $data)
    {
        $this->_id = null;
        $this->_uri = self::HARVEST_PATH;

        $this->_data = [];
        $this->_data = $data;

        return parent::create();
    }

    /**
     * @param int $id
     * @param array $data
     * @return \stdClass|bool
     */
    public function updateOrCreateProject(?int $id, array $data)
    {
        if (is_null($id)) {
            return $this->createProject($data);
        } else {
            return $this->updateProject($id, $data);
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return \stdClass|bool
     */
    public function updateProject(int $id, array $data)
    {
        $this->_id = $id;
        $this->_uri = self::HARVEST_PATH;

        $this->_data = [];
        $this->_data = $data;

        return parent::update();
    }
}
