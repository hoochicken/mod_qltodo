<?php
/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

class MessageCollection extends AbstractCollection
{
    public function add($item): void
    {
        if (!$item instanceof MessageItem) {
            return;
        }
        parent::add($item);
    }

    public function hasErrors(): bool
    {
        return 0 < count($this->items);
    }
}
