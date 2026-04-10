<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoRepository;
use Hoochicken\Module\Qltodo\Site\Helper\SeverityItem;
use Hoochicken\Module\Qltodo\Site\Helper\TodoItem;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
$entry = $displayData->getQltodoEntry();
$severityLevel = $entry->severity?->level ?? SeverityItem::SEVERITY_LOW_VALUE;
?>

<<?= $params->getModuleTag() ?> class="<?php echo 'mod_qltodo ' . $params->getModuleClassSuffix(); ?>">
<?php if ($params->displayTitle()) : ?>
    <<?= $params->getTitleTag() ?>>
    <?= $params->getTitle() ?>
    </<?= $params->getTitleTag() ?>>
<?php endif; ?>
<div class="module-content">
    <form method="post" class="form-validate">
        <div class="control-group">
            <label for="mod_qltodo_title"><?= Text::_('JGLOBAL_TITLE') ?></label>
            <input
                id="mod_qltodo_title"
                name="<?= QltodoRepository::COLUMN_TITLE ?>"
                type="text"
                class="required"
                value="<?= htmlspecialchars($entry->title, ENT_QUOTES, 'UTF-8') ?>"
                required
            />
        </div>
        <div class="control-group">
            <label for="mod_qltodo_description"><?= Text::_('JGLOBAL_DESCRIPTION') ?></label>
            <textarea
                id="mod_qltodo_description"
                name="<?= QltodoRepository::COLUMN_DESCRIPTION ?>"
                rows="4"
            ><?= htmlspecialchars($entry->description, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="control-group">
            <label for="mod_qltodo_severity"><?= Text::_('COM_MODULES_FIELD_STATUS_LABEL') ?></label>
            <select id="mod_qltodo_severity" name="<?= QltodoRepository::COLUMN_SEVERITY ?>">
                <option value="<?= SeverityItem::SEVERITY_LOW_VALUE ?>" <?= $severityLevel === SeverityItem::SEVERITY_LOW_VALUE ? 'selected' : '' ?>>
                    <?= Text::_(SeverityItem::SEVERITY_LOW_LABEL) ?>
                </option>
                <option value="<?= SeverityItem::SEVERITY_MINOR_VALUE ?>" <?= $severityLevel === SeverityItem::SEVERITY_MINOR_VALUE ? 'selected' : '' ?>>
                    <?= Text::_(SeverityItem::SEVERITY_MINOR_LABEL) ?>
                </option>
                <option value="<?= SeverityItem::SEVERITY_MAJOR_VALUE ?>" <?= $severityLevel === SeverityItem::SEVERITY_MAJOR_VALUE ? 'selected' : '' ?>>
                    <?= Text::_(SeverityItem::SEVERITY_MAJOR_LABEL) ?>
                </option>
                <option value="<?= SeverityItem::SEVERITY_CRITICAL_VALUE ?>" <?= $severityLevel === SeverityItem::SEVERITY_CRITICAL_VALUE ? 'selected' : '' ?>>
                    <?= Text::_(SeverityItem::SEVERITY_CRITICAL_LABEL) ?>
                </option>
                <option value="<?= SeverityItem::SEVERITY_URGENT_VALUE ?>" <?= $severityLevel === SeverityItem::SEVERITY_URGENT_VALUE ? 'selected' : '' ?>>
                    <?= Text::_(SeverityItem::SEVERITY_URGENT_LABEL) ?>
                </option>
            </select>
        </div>
        <input type="hidden" name="<?= QltodoRepository::COLUMN_ID ?>" value="<?= (int) $entry->id ?>" />
        <button type="submit" class="btn btn-primary"><?= Text::_('MOD_QLTODO_BUTTON_SUBMIT') ?></button>
        <?= HTMLHelper::_('form.token') ?>
    </form>
</div>
</<?= $params->getModuleTag() ?>>
