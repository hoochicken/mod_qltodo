<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2025 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

use Hoochicken\Module\Qltodo\Site\Helper\ParametersCustom;

/** @var ?\Hoochicken\Module\Qltodo\Site\Helper\DisplayData $displayData */
?>

<<?= $displayData->getParams()->getModuleTag() ?> class="<?php echo 'mod_qltodo ' . $displayData->getParams()->getModuleClassSuffix(); ?>">
    <?php if ($displayData->getParams()->displayTitle()) : ?>
        <<?= $displayData->getParams()->getTitleTag() ?>>
            <?= $displayData->getParams()->getTitle() ?>
        </<?= $displayData->getParams()->getTitleTag() ?>>
    <?php endif; ?>
    <div class="module-content">
        <?= $displayData->getParams()->getMessage(); ?>
    </div>
</<?= $displayData->getParams()->getModuleTag() ?>>