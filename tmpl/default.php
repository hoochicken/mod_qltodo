<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;

defined('_JEXEC') or die;

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
?>
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
