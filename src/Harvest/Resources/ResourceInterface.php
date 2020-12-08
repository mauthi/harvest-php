<?php

namespace Harvest\Resources;

/**
 * Interface ResourceInterface.
 *
 * @namespace    Harvest\Resources
 * @author     Joridos <joridoss@gmail.com>
 */
interface ResourceInterface
{
    public function getAll(): array;

    public function getPage(int $page): array;

    public function getInactive(): array;

    public function getActive(): array;

    public function create();

    public function update();
}
