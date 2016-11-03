<?php

namespace Harvest\Resources;

/**
 * Interface ResourceInterface
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
interface ResourceInterface
{
    public function getAll();
    public function getInactive();
    public function getActive();
    public function create();
}