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
/* @var \Joomla\Registry\Registry $params */
/* @var array $columns */
/* @var array $data */
/* @var \Hoochicken\ParameterBag\ParameterBag $request */
/* @var Joomla\Application\ $app */
/* @var bool $entryId */
?>
<form method="post">
    <input name="<?= QltodoHelper::FORM_TITLE ?>" placeholder="<?= QltodoHelper::FORM_TITLE ?>" value="<?= $request->getString(QltodoHelper::FORM_TITLE, '') ?>" class="form-control" />
    <textarea name="<?= QltodoHelper::FORM_DESCRIPTION ?>" placeholder="<?= QltodoHelper::FORM_DESCRIPTION ?>" class="form-control"><?= $request->getString(QltodoHelper::FORM_DESCRIPTION, '') ?></textarea>
    <input name="<?= QltodoHelper::FORM_MENUITEMTITLE ?>" placeholder="<?= QltodoHelper::FORM_MENUITEMTITLE ?>" value="<?= $request->getString(QltodoHelper::FORM_MENUITEMTITLE, '') ?>" class="form-control" />
    <input name="<?= QltodoHelper::FORM_MENUITEMTID ?>" placeholder="<?= QltodoHelper::FORM_MENUITEMTID ?>" value="<?= $request->getString(QltodoHelper::FORM_MENUITEMTID, '') ?>" class="form-control" />
    <input name="<?= QltodoHelper::FORM_STATE ?>" placeholder="<?= QltodoHelper::FORM_STATE ?>" value="<?= $request->getString(QltodoHelper::FORM_STATE, '') ?>" class="form-control" />
    <input name="<?= QltodoHelper::FORM_WORKFLOW ?>" placeholder="<?= QltodoHelper::FORM_WORKFLOW ?>" value="<?= $request->getString(QltodoHelper::FORM_WORKFLOW, '') ?>" class="form-control" />
    <input name="<?= QltodoHelper::FORM_SEVERITY ?>" placeholder="<?= QltodoHelper::FORM_SEVERITY ?>" value="<?= $request->getString(QltodoHelper::FORM_SEVERITY, '') ?>" class="form-control" />
    <input type="hidden" name="<?= QltodoHelper::FORM_ACTION_SAVE ?>" value="1"/>
    <input type="submit" class="btn btn-primary" value="<?= $entryId ? Text::_('JACTION_EDIT') : Text::_('JACTION_CREATE') ?>" />
</form>
<form method="post">
    <input type="hidden" name="<?= QltodoHelper::FORM_ID ?>" value="<?= $entryId ?>" />
    <input type="hidden" name="<?= QltodoHelper::FORM_ACTION_DELETE ?>" value="delete" />
    <input type="submit" class="btn btn-primary" value="<?= Text::_('JACTION_DELETE') ?>" />
</form>
