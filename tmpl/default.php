<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Joomla\CMS\Factory;

defined('_JEXEC') or die;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('mod_qltodo');
$wa->useStyle('mod_qltodo');

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
?>
<button class="mod_qltodo toggle-btn" id="openSidebarBtn">☰ Open Menu</button>

<aside class="mod_qltodo sidebar" id="sidebar">
    <button class="mod_qltodo close-btn" id="closeSidebarBtn">Close</button>
    <h2>Sidebar Module</h2>
    <p>
        This is a collapsible left sidebar. You can put Joomla module content here.
    </p>

    <nav>
        <a href="#">Dashboard</a>
        <a href="#">News</a>
        <a href="#">Downloads</a>
        <a href="#">Contact</a>
    </nav>
</aside>

<div class="mod_qltodo overlay" id="overlay"></div>
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
