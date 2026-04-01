<?php
/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

use Joomla\Registry\Registry;
use stdClass;

interface ParametersBasicInterface
{
    public function displayTitle(): bool;

    public function getTitleTag(): string;

    public function getModuleTag(): string;

    public function getModuleClassSuffix(bool $specialChars = true): string;

    public function getLayout(): string;

    public function getParams(): ?Registry;

    public function setParams(?Registry $params): void;

    public function getModule(): ?stdClass;

    public function setModule(?stdClass $module): void;

    public function getMessage(): ?string;

    public function setMessage(?string $message): void;

    public function existsErrors(): bool;

    public function getErrors(): ?MessageCollection;

    public function setErrors(?MessageCollection $errors): void;
}
