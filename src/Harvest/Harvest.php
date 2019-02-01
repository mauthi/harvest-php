<?php
namespace Harvest;

use Harvest\Api\Connection;
use Harvest\Resources\Tasks;
use Harvest\Resources\Clients;
use Harvest\Resources\Projects;
use Harvest\Resources\TimeEntries;
use Harvest\Exceptions\HarvestException;

/**
 * Class Harvest
 *
 * @namespace    Harvest
 * @author     Joridos <joridoss@gmail.com>
 */
class Harvest
{
    private $_connection;

    /**
     * Harvest constructor.
     * @param $accountId
     * @param $token
     * @param $account
     */
    public function __construct($accountId, $token, $_debug = false)
    {
        $this->_connection = new Connection(array( 'account_id' => $accountId, 'token' => $token, 'debug' => $_debug));
        $this->projects = new Projects($this->_connection);
        $this->clients = new Clients($this->_connection);
        $this->tasks = new Tasks($this->_connection);
        $this->time_entries = new TimeEntries($this->_connection);

    }

    /**
     * @return Projects
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @return Clients
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @return Tasks
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @return TimeEntries
     */
    public function getTimeEntries()
    {
        return $this->time_entries;
    }

    /**
     * @return Timesheets
     */
    public function getTimesheets()
    {
        throw new HarvestException("Resource 'Timesheets' is deprecated!");
    }

    /**
     * @return Timesheets
     */
    public function getTimereports()
    {        throw new HarvestException("Resource 'Timereports' is deprecated!");
    }
}
