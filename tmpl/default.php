<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;

defined('_JEXEC') or die;

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();

if ($displayData->isDisplayTypeForm()) {
    require 'default_form.php';
    return;
} 

require 'default_list.php';
