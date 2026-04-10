<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoForm;
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
$levels = SeverityItem::getLevels();
?>

<<?= $params->getModuleTag() ?> class="<?php echo QltodoForm::MODULE_PREFIX . ' ' . $params->getModuleClassSuffix(); ?>">
<?php if ($params->displayTitle()) : ?>
    <<?= $params->getTitleTag() ?>>
    <?= $params->getTitle() ?>
    </<?= $params->getTitleTag() ?>>
<?php endif; ?>
<div class="module-content">
    <form method="post" class="form-validate">
        <div class="control-group">
            <label for="<?= QltodoForm::MODULE_PREFIX ?>_title"><?= Text::_('JGLOBAL_TITLE') ?></label>
            <input
                id="<?= QltodoForm::MODULE_PREFIX ?>_title"
                name="<?= QltodoRepository::COLUMN_TITLE ?>"
                type="text"
                class="required"
                value="<?= htmlspecialchars($entry->title, ENT_QUOTES, 'UTF-8') ?>"
                required
            />
        </div>
        <div class="control-group">
            <label for="<?= QltodoForm::MODULE_PREFIX ?>_description"><?= Text::_('JGLOBAL_DESCRIPTION') ?></label>
            <textarea
                id="<?= QltodoForm::MODULE_PREFIX ?>_description"
                name="<?= QltodoRepository::COLUMN_DESCRIPTION ?>"
                rows="4"
            ><?= htmlspecialchars($entry->description, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="control-group">
            <label for="<?= QltodoForm::MODULE_PREFIX ?>_severity"><?= Text::_('MOD_QLTODO_STATUS_LABEL') ?></label>
            <select id="<?= QltodoForm::MODULE_PREFIX ?>_severity" name="<?= QltodoRepository::COLUMN_SEVERITY ?>">
                <?php foreach ($levels as $level => $label) : ?>
                    <option value="<?= (int) $level ?>" <?= (int) $severityLevel === (int) $level ? 'selected' : '' ?>>
                        <?= Text::_($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" name="<?= QltodoForm::PARAM_TODO_ID ?>" value="<?= (int) $entry->id ?>" />
        <button type="submit" class="btn btn-primary"><?= Text::_('MOD_QLTODO_BUTTON_SUBMIT') ?></button>
        <?= HTMLHelper::_('form.token') ?>
    </form>
</div>
</<?= $params->getModuleTag() ?>>
