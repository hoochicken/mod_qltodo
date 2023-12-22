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
            <form method="post" action="<?= $entry['page_url'] ?>">
                <strong><?= $entry['title'] ?? '' ?> (<?= $entry['id'] ?? '' ?>)</strong><br />
                <input class="btn btn-secondary" type="submit" value="Fix it" /><br />
                <a href="<?= $entry['page_url'] ?>" class="item_menu_title"><?= $entry['item_menu_title'] ?? $entry['page_url'] ?></a><br />
                <?php if (!empty($entry['description'] ?? '')) : ?>
                    <span class="description"><?= $entry['description'] ?? '' ?></span>
                <?php endif; ?>
                <input type="hidden" name="<?= QltodoHelper::FORM_ACTION_LOAD ?>" value="1" />
                <input name="<?= QltodoHelper::FORM_ID ?>" value="<?= $entry['id'] ?>" type="hidden" />
            </form>
        </li>
    <?php endforeach; ?>
</ul>
