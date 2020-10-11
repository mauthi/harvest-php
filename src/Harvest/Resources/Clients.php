<?php

namespace Harvest\Resources;

/**
 * Class Clients
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
class Clients extends AbstractResource implements ResourceInterface
{
	const HARVEST_PATH = 'clients';
    const RESOURCE_NAME = 'client';

	/**
     * @param string|\DateTime $updatedSince
     * @return array
     */
    public function getAll($updatedSince = null): array
    {
        $this->_params["updated_since"] = $this->_appendUpdatedSinceParam($updatedSince);
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
     * @return \stdClass|boolean 
     */
    public function createClient(array $data) {
        $this->_id = null;
        $this->_uri = self::HARVEST_PATH;

        $this->_data = array();
        $this->_data = $data;
        return parent::create();
    }

    /**
     * @param int $id
     * @param array $data
     * @return \stdClass|boolean 
     */
    public function updateOrCreateClient(int $id, array $data) {
        if (is_null($id))
            return $this->createClient($data);
        else
            return $this->updateClient($id, $data);
    }


    /**
     * @param int $id
     * @param array $data
     * @return \stdClass|boolean
     */
    public function updateClient(int $id, array $data) {
        $this->_id = $id;
        $this->_uri = self::HARVEST_PATH;

        $this->_data = array();
        $this->_data = $data;
        return parent::update();
    }
}