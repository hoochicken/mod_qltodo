<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('mod_qltodo');
$wa->useStyle('mod_qltodo');

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
?>
<button class="mod_qltodo toggle-btn" id="qltodoopenSidebarBtn">☰ <?= Text::_('MOD_QLTODO_GUI_OPEN') ?></button>

<aside class="mod_qltodo sidebar" id="qltodosidebar">
    <button class="mod_qltodo close-btn" id="qltodocloseSidebarBtn"><?= Text::_('MOD_QLTODO_GUI_CLOSE') ?></button>

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
