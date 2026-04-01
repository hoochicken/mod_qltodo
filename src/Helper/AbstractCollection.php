<?php
/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

abstract class AbstractCollection implements CollectionInterface
{
    protected array $items = [];

    public function add($item): void
    {
        $this->items[] = $item;
    }

    public function set(array $items): void
    {
        $this->items = $items;
    }

    public function get(): array
    {
        return $this->items;
    }
}
