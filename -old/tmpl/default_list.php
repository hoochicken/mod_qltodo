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
/* @var QltodoEntry $entry */
?>
<ul class="">
    <?php foreach ($data as $k => $singleEntry) : ?>
        <li class="item">
            <form method="post" action="<?= $singleEntry->getPageUrl() ?>">
                <strong><?= $singleEntry->getTitle() ?> (<?= $singleEntry->getId(); ?>)</strong><br />
                <input class="btn btn-secondary" type="submit" value="Fix it" /><br />
                <a href="<?= $singleEntry->getPageUrl() ?>" class="item_menu_title"><?= $singleEntry->getMenuItemTitle() ?? $singleEntry->getPageUrl() ?></a><br />
                <?php if (!empty($singleEntry->getDescription())) : ?>
                    <span class="description"><?= $singleEntry->getDescription() ?></span>
                <?php endif; ?>
                <input type="hidden" name="<?= QltodoHelper::FORM_ACTION_LOAD ?>" value="1" />
                <input name="<?= QltodoHelper::FORM_ID ?>" value="<?= $singleEntry->getId() ?>" type="hidden" />
            </form>
        </li>
    <?php endforeach; ?>
</ul>
