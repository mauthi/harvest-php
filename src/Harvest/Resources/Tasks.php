<?php

namespace Harvest\Resources;

use Harvest\Api\Connection;

/**
 * Class Tasks.
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
class Tasks extends AbstractResource implements ResourceInterface
{
    const HARVEST_PATH = 'tasks';

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

    /**
     * @return array
     */
    public function getInactive(): array
    {
        $this->_params['is_active'] = false;

        return $this->getAll();
    }

    /**
     * @return array
     */
    public function getActive(): array
    {
        $this->_params['is_active'] = true;

        return $this->getAll();
    }
}
