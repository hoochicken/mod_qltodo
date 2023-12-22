<?php
/**
 * @package		mod_qltodo
 * @copyright	Copyright (C) 2022 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

use Hoochicken\Datagrid\Datagrid;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/* @var stdClass $module */
/* @var Joomla\Registry\Registry $params */
/* @var Joomla\Application\ $app */
/* @var array $entry */
/* @var string $originalUrl */
/* @var bool $displayBackToList */
/* @var bool $displayNavigation */
/* @var ?array $next */
/* @var ?array $prev */


$entryId = $entry[QltodoTable::COLUMN_ID];
?>
<div class="entry">
    <div class="<?= QltodoTable::COLUMN_ID ?>"><?= $entry[QltodoHelper::COLUMN_ID] ?></div>
    <div class="<?= QltodoTable::COLUMN_DESCRIPTION ?>"><?= $entry[QltodoTable::COLUMN_DESCRIPTION] ?></div>
    <div class="<?= QltodoTable::COLUMN_MENU_ITEM_TITLE ?>"><?= $entry[QltodoTable::COLUMN_MENU_ITEM_TITLE] ?></div>
    <div class="<?= QltodoTable::COLUMN_MENU_ITEM_ID ?>"><?= $entry[QltodoTable::COLUMN_MENU_ITEM_ID] ?></div>
    <div class="<?= QltodoTable::COLUMN_STATE ?>"><?= $entry[QltodoTable::COLUMN_STATE] ?></div>
    <div class="<?= QltodoTable::COLUMN_WORKFLOW ?>"><?= $entry[QltodoTable::COLUMN_WORKFLOW] ?></div>
    <div class="<?= QltodoTable::COLUMN_SEVERITY ?>"><?= $entry[QltodoTable::COLUMN_SEVERITY] ?></div>
    <form method="post">
        <input type="hidden" name="<?= QltodoHelper::FORM_ACTION_SAVE ?>" value="1"/>
        <input type="submit" class="btn btn-primary" value="<?= $entryId ? Text::_('JACTION_EDIT') : Text::_('JACTION_CREATE') ?>" />
    </form>
    <form method="post">
        <input type="hidden" name="<?= QltodoHelper::FORM_ID ?>" value="<?= $entryId ?>" />
        <input type="hidden" name="<?= QltodoHelper::FORM_ACTION_DELETE ?>" value="delete" />
        <input type="submit" class="btn btn-primary" value="<?= Text::_('JACTION_DELETE') ?>" />
    </form>
    <div class="navigation d-flex justify-content-between">
    <?php if ($displayNavigation) : ?>
        <?php if (is_null($prev)) : ?>
            <span class="btn btn-secondary disabled"><?= Text::_('MOD_QLTODO_PREV') ?></span>
        <?php else : ?>
            <a class="btn btn-secondary" href="<?= $prev[QltodoHelper::QLTODO][QltodoHelper::QLTODO_URL] ?>"><?= $params->get('linkTextPrev', Text::_('MOD_QLTODO_PREV')) ?></a>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($displayBackToList) : ?>
        <a class="btn btn-secondary" href="<?= $originalUrl ?>"><?= $params->get('linkTextBackToList', Text::_('MOD_QLTODO_BACKTOLIST')) ?></a>
    <?php endif; ?>
    <?php if ($displayNavigation) : ?>
        <?php if (is_null($next)) : ?>
            <span class="btn btn-secondary disabled"><?= Text::_('MOD_QLTODO_PREV') ?></span>
        <?php else : ?>
            <a class="btn btn-secondary" href="<?= $next[QltodoHelper::QLTODO][QltodoHelper::QLTODO_URL] ?>"><?= $params->get('linkTextNext', Text::_('MOD_QLTODO_NEXT')) ?></a>
        <?php endif; ?>
    <?php endif; ?>
    </div>
</div>
