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

<form method="post" class="form-validate clear-both">
    <div class="control-group">
        <!--label for="<?= QltodoForm::MODULE_PREFIX ?>_title"><?= Text::_('JGLOBAL_TITLE') ?></label-->
        <input
                id="<?= QltodoForm::MODULE_PREFIX ?>_title"
                name="<?= QltodoRepository::COLUMN_TITLE ?>"
                type="text"
                class="form-control required"
                placeholder="<?= Text::_('JGLOBAL_TITLE') ?>"
                value="<?= htmlspecialchars($entry->title, ENT_QUOTES, 'UTF-8') ?>"
                required
        />
    </div>
    <div class="control-group">
        <!--label for="<?= QltodoForm::MODULE_PREFIX ?>_title"><?= Text::_('MOD_QLTODO_PAGE_URL') ?></label-->
        <input
                id="<?= QltodoForm::MODULE_PREFIX ?>_title"
                name="<?= QltodoRepository::COLUMN_PAGE_URL ?>"
                type="text"
                disabled="form-control disabled"
                value="<?= $entry->page_url ?>"
                required
        />
    </div>
    <div class="control-group">
        <!--label for="<?= QltodoForm::MODULE_PREFIX ?>_description"><?= Text::_('JGLOBAL_DESCRIPTION') ?></label-->
        <textarea
                id="<?= QltodoForm::MODULE_PREFIX ?>_description"
                name="<?= QltodoRepository::COLUMN_DESCRIPTION ?>"
                placeholder="<?= Text::_('JGLOBAL_DESCRIPTION') ?>"
                class="form-control"
                rows="4"
        ><?= htmlspecialchars($entry->description, ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>
    <div class="control-group">
        <label for="<?= QltodoForm::MODULE_PREFIX ?>_severity"><?= Text::_('MOD_QLTODO_STATUS_LABEL') ?></label>
        <select id="<?= QltodoForm::MODULE_PREFIX ?>_severity" name="<?= QltodoRepository::COLUMN_SEVERITY ?>" class="form-control">
            <?php foreach ($levels as $level => $label) : ?>
                <option value="<?= (int)$level ?>" <?= (int)$severityLevel === (int)$level ? 'selected' : '' ?>>
                    <?= Text::_($label) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="hidden" name="<?= QltodoForm::PARAM_TODO_ID ?>" value="<?= (int)$entry->id ?>"/>
    <input type="hidden" name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_SAVE ?>"/>
    <button type="submit" name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_CLOSE ?>"class="btn btn-secondary"><?= Text::_('MOD_QLTODO_BUTTON_CLOSE') ?></button>
    <button type="submit" class="btn btn-secondary"><?= Text::_('MOD_QLTODO_BUTTON_SAVE') ?></button>
    <button type="submit" name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_SAVE_AND_CLOSE ?>"
            class="btn btn-primary"><?= Text::_('MOD_QLTODO_BUTTON_SAVE_AND_CLOSE') ?></button>
    <?= HTMLHelper::_('form.token') ?>
</form>

<form method="post" class="form-validate float-right clear-both mt-5">
    <button type="submit" onclick="confirm('<?= Text::_('MOD_QLFORM_MSG_DELETION_CONFIRM') ?>')"
            name="<?= QltodoForm::PARAM_TODO_TASK ?>" value="<?= QltodoForm::TASK_DELETE ?>"
            class="btn btn-secondary"><?= Text::_('MOD_QLTODO_BUTTON_DELETE') ?></button>
    <?= HTMLHelper::_('form.token') ?>
</form>
