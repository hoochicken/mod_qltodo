<?php
/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

interface DisplayDataInterface
{
    public function toArray(): array;

    public function getParams(): ParametersCustomInterface;

    public function setMessage(?string $message): void;
}
