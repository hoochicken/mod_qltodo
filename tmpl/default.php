<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoForm;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('mod_qltodo');
$wa->useStyle('mod_qltodo');

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
$cssClassShowPanel = $displayData->isDisplayTypeForm() ? 'open' : '';
$cssClassShowButton = $displayData->isDisplayTypeForm() ? 'hide' : '';
?>
<button class="mod_qltodo toggle-btn <?= $cssClassShowButton ?>" id="qltodoopenSidebarBtn">☰ <?= Text::_('MOD_QLTODO_GUI_OPEN') ?></button>

<aside class="mod_qltodo sidebar <?= $cssClassShowPanel ?>" id="qltodosidebar">
    <button class="mod_qltodo close-btn float-left" id="qltodocloseSidebarBtn"><?= Text::_('MOD_QLTODO_GUI_CLOSE') ?></button>

    <?php if ($displayData->isDisplayTypeList()) : ?>
    <form method="post" class="float-right form-validate">
        <button type="submit" name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_CREATE ?>"
                class="float-right btn btn-primary btn-success"><?= Text::_('MOD_QLTODO_BUTTON_CREATE') ?></button>
        <?= HTMLHelper::_('form.token') ?>
    </form>
    <?php endif; ?>

    <<?= $params->getModuleTag() ?> class="<?php echo 'qltodo ' . $params->getModuleClassSuffix(); ?>">
        <?php if ($params->displayTitle()) : ?>
            <<?= $params->getTitleTag() ?>>
                <?= $params->getTitle() ?>
            </<?= $params->getTitleTag() ?>>
         <?php endif; ?>
    <div class="module-content">
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
