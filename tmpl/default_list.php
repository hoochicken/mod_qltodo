<?php
/**
 * @package		mod_qltodo
 * @copyright	Copyright (C) 2022 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

use Hoochicken\Datagrid\Datagrid;
use Joomla\CMS\Factory;
// no direct access
defined('_JEXEC') or die;

/* @var stdClass $module */
/* @var \Joomla\Registry\Registry $params */
/* @var array $columns */
/* @var array $data */
/* @var Joomla\Application\ $app */
?>
<ul class="">
    <?php foreach ($data as $k => $entry) : ?>
        <li class="item">
            <strong><?= $entry['title'] ?? '' ?> (<?= $entry['id'] ?? '' ?>) </strong><br />
            <?php if (!empty($entry['item_menu_title'] ?? '')) : ?>
                <a href="#" class="item_menu_title"><?= $entry['item_menu_title'] ?></a><br />
            <?php endif; ?>
            <?php if (!empty($entry['description'] ?? '')) : ?>
                <span class="description"><?= $entry['description'] ?? '' ?></span>
            <?php endif; ?>

            <?php // print_r($entry); ?>
        </li>
    <?php endforeach; ?>
</ul>
