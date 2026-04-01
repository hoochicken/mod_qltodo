<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2025 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

use Hoochicken\Module\Qltodo\Site\Helper\ParametersCustom;

/** @var ?ParametersCustom $displayData */
?>

<<?= $displayData->getModuleTag() ?> class="<?php echo 'mod_qltodo ' . $displayData->getModuleClassSuffix(); ?>">
    <?php if ($displayData->displayTitle()) : ?>
        <<?= $displayData->getTitleTag() ?>>
            <?= $displayData->getTitle() ?>
        </<?= $displayData->getTitleTag() ?>>
    <?php endif; ?>
    <div class="module-content">
        <?= $displayData->getMessage(); ?>
    </div>
</<?= $displayData->getModuleTag() ?>>