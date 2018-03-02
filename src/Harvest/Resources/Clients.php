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
            return $data['client']['active'] == false;
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
            return $data['client']['active'] == true;
        });

        return $actives;
    }

    /**
     * @param array $data
     * @return string 
     */
    public function createClient(array $data) {
        $this->_uri = self::HARVEST_PATH;

        $this->_data = array();
        $this->_data[self::RESOURCE_NAME] = $data;
        return parent::create();
    }

    /**
     * @param array $data
     * @return string 
     */
    public function updateOrCreateClient($id, array $data) {
        if (is_null($id))
            return $this->createClient($data);
        else
            return $this->updateClient($id, $data);
    }


    /**
     * @param array $data
     * @return string 
     */
    public function updateClient($id, array $data) {
        $this->_uri = self::HARVEST_PATH."/{$id}";

        $this->_data = array();
        $this->_data[self::RESOURCE_NAME] = $data;
        return parent::update();
    }
}