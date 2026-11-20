<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoForm;
use Hoochicken\Module\Qltodo\Site\Helper\UrlWizard;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('mod_qltodo');
$wa->useStyle('mod_qltodo');

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
HTMLHelper::_('behavior.core');

$cssClassShowPanel = $displayData->isSidebarVisible() || $displayData->isDisplayTypeForm() ? 'open' : '';
$cssClassShowButton = $displayData->isSidebarVisible() || $displayData->isDisplayTypeForm() ? 'hide' : '';
$counterEntries = count($displayData->getQltodoEntries());
?>
<button type="button" class="btn btn-primary mod_qltodo toggle-btn <?= $cssClassShowButton ?>" id="qltodoopenSidebarBtn">☰ <?= Text::_('MOD_QLTODO_GUI_OPEN') ?> (<?= $counterEntries ?>)</button>

<aside class="mod_qltodo sidebar bg-body shadow <?= $cssClassShowPanel ?>" id="qltodosidebar"
       style="--qltodo-item-border-width: <?= $params->getItemBorderWidth() ?>px; --qltodo-item-border-color: <?= $params->getItemBorderColor() ?>;">
    <button type="button" class="btn btn-danger btn-sm mod_qltodo close-btn float-left float-start" id="qltodocloseSidebarBtn"><?= Text::_('MOD_QLTODO_GUI_CLOSE') ?></button>

    <?php if ($displayData->isDisplayTypeList()) : ?>
    <form method="post" action="<?= UrlWizard::getPageUrlCleanedUp() ?>" class="float-left float-start">
        <button type="submit" name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_FILTER_ALL ?>"
                class="float-right float-end btn btn-sm btn-ternary btn-outline-secondary ms-1"><?= Text::_('MOD_QLTODO_BUTTON_FILTER_ALL') ?></button>
        <button type="submit" name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_FILTER_CURRENT ?>"
                class="float-right float-end btn btn-sm btn-ternary btn-outline-secondary ms-1"><?= Text::_('MOD_QLTODO_BUTTON_FILTER_CURRENT') ?></button>
        <?= HTMLHelper::_('form.token') ?>
    </form>
    <form method="post" class="float-right float-end form-validate">
        <button type="submit" name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_CREATE ?>"
                class="float-right float-end btn btn-sm btn-success"><?= Text::_('MOD_QLTODO_BUTTON_CREATE') ?></button>
        <?= HTMLHelper::_('form.token') ?>
    </form>
    <?php endif; ?>

    <<?= $params->getModuleTag() ?> class="<?php echo 'qltodo ' . $params->getModuleClassSuffix(); ?>">
        <?php if ($params->displayTitle()) : ?>
            <<?= $params->getTitleTag() ?>>
                <?= $params->getTitle() ?>
            </<?= $params->getTitleTag() ?>>
         <?php endif; ?>
    <div class="module-content clearfix">
        <?php
        if ($displayData->isDisplayTypeForm()) {
            require 'default_form.php';
        } else {
            require 'default_list.php';
        }
        ?>
    </div>
    </<?= $params->getModuleTag() ?>>
</aside>

<div class="mod_qltodo overlay" id="qltodooverlay"></div>
