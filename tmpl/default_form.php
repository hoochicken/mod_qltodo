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
?>
<form method="post">
    <input name="<?= QltodoHelper::FORM_TITLE ?>" value="<?= $request->getString(QltodoHelper::FORM_TITLE, '') ?>" />
    <input name="<?= QltodoHelper::FORM_DESCRIPTION ?>" value="<?= $request->getString(QltodoHelper::FORM_DESCRIPTION, '') ?>" />
    <input name="<?= QltodoHelper::FORM_MENUITEMTITLE ?>" value="<?= $request->getString(QltodoHelper::FORM_MENUITEMTITLE, '') ?>" />
    <input name="<?= QltodoHelper::FORM_MENUITEMTID ?>" value="<?= $request->getString(QltodoHelper::FORM_MENUITEMTID, '') ?>" />
    <input name="<?= QltodoHelper::FORM_STATE ?>" value="<?= $request->getString(QltodoHelper::FORM_STATE, '') ?>" />
    <input name="<?= QltodoHelper::FORM_WORKFLOW ?>" value="<?= $request->getString(QltodoHelper::FORM_WORKFLOW, '') ?>" />
    <input name="<?= QltodoHelper::FORM_SEVERITY ?>" value="<?= $request->getString(QltodoHelper::FORM_SEVERITY, '') ?>" />
    <input type="hidden" name="<?= QltodoHelper::FORM_ACTION_SAVE ?>" value="1"/>
    <input type="submit" value="<?= Text::_('JSAVE') ?>" />
</form>
