<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2025 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

/** @var ?\Hoochicken\Module\Qltodo\Site\Helper\DisplayData $displayData */

$params = $displayData->getParams();
?>

<<?= $params->getModuleTag() ?> class="<?php echo 'mod_qltodo ' . $params->getModuleClassSuffix(); ?>">
    <?php if ($params->displayTitle()) : ?>
        <<?= $params->getTitleTag() ?>>
            <?= $params->getTitle() ?>
        </<?= $params->getTitleTag() ?>>
    <?php endif; ?>
    <div class="module-content">
        <?= $params->getMessage(); ?>
    </div>
</<?= $params->getModuleTag() ?>>
