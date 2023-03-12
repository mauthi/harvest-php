<?php

namespace Harvest\Resources;

use stdClass;

/**
 * Class Clients.
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
class Clients extends AbstractResource implements ResourceInterface
{
    public const HARVEST_PATH = 'clients';
    public const RESOURCE_NAME = 'client';

    /**
     * @param string|\DateTime $updatedSince
     * @return array
     */
    public function getAll($updatedSince = null): array
    {
        $this->_params['updated_since'] = $this->_appendUpdatedSinceParam($updatedSince);
        $this->_uri = self::HARVEST_PATH;

        return parent::getAll();
    }

    public function getOne($id): stdClass
    {
        $this->_uri = self::HARVEST_PATH;

        return parent::getOne($id);
    }

    public function getByName(String $name): ?stdClass
    {
        $this->_uri = self::HARVEST_PATH;
        $this->_params['name'] = $name;

        $all = parent::getAll();
        if (sizeof($all) != 1) {
            return null;
        }

        return $all[0];
    }

    /**
     * @return array
     */
    public function getInactive(): array
    {
        $all = json_decode($this->getAll(), true);
        $actives = array_filter($all, function ($data) {
            return $data['client']['active'] == false;
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
            return $data['client']['active'] == true;
        });

        return $actives;
    }

    /**
     * @param array $data
     * @return \stdClass|bool
     */
    public function createClient(array $data)
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
    public function updateOrCreateClient(?int $id, array $data)
    {
        if (is_null($id)) {
            return $this->createClient($data);
        } else {
            return $this->updateClient($id, $data);
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return \stdClass|bool
     */
    public function updateClient(int $id, array $data)
    {
        $this->_id = $id;
        $this->_uri = self::HARVEST_PATH;

        $this->_data = [];
        $this->_data = $data;

        return parent::update();
    }
}
