<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Datagrid\Datagrid;
use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoForm;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoRepository;
use Hoochicken\Module\Qltodo\Site\Helper\TodoItem;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
$columns = [
    QltodoRepository::COLUMN_TITLE => 'Title',
    QltodoRepository::COLUMN_DESCRIPTION => 'Description',
    QltodoRepository::COLUMN_SEVERITY => 'Severity',
    QltodoRepository::COLUMN_STATE  => 'State',
    QltodoRepository::COLUMN_CREATED_AT => 'Created at',
    'edit' => 'Edit',
    'delete' => 'Delete',
];

/** @var TodoItem[] $entries */
$entries = $displayData->getQltodoEntries();
$returnUrl = base64_encode(Uri::getInstance()->toString());
$entries = array_map(fn($item) => $item->toArray(), $entries);

$entries = array_map(function ($item) use ($returnUrl) {
    $id = (int)$item['id'] ?? 0;
    $baseUrl = (string) ($item[QltodoRepository::COLUMN_PAGE_URL] ?? '');
    $separator = str_contains($baseUrl, '?') ? '&' : '?';
    $editUrl = sprintf(
        '%s%s%s=%s&%s=%d&return=%s',
        $baseUrl,
        $separator,
        QltodoForm::PARAM_TODO_TASK,
        QltodoForm::TASK_EDIT,
        QltodoForm::PARAM_TODO_ID,
        $id,
        $returnUrl
    );
    $deleteUrl = sprintf(
        '%s%s%s=%s&%s=%d&return=%s',
        $baseUrl,
        $separator,
        QltodoForm::PARAM_TODO_TASK,
        QltodoForm::TASK_DELETE,
        QltodoForm::PARAM_TODO_ID,
        $id,
        $returnUrl
    );

    $item['edit'] = sprintf('<a href="%s" class="btn btn-secondary btn-sm">%s</a>', $editUrl, Text::_('JACTION_EDIT'));
    $item['delete'] = sprintf(
        '<a href="%s" class="btn btn-danger btn-sm" onclick="return confirm(\'%s\');">%s</a>',
        $deleteUrl,
        Text::_('JGLOBAL_CONFIRM_DELETE'),
        Text::_('JACTION_DELETE')
    );
    return $item;
}, $entries);


$datagrid = new DataGrid();
?>

<<?= $params->getModuleTag() ?> class="<?php echo 'qltodo ' . $params->getModuleClassSuffix(); ?>">
<?php if ($params->displayTitle()) : ?>
    <<?= $params->getTitleTag() ?>>
    <?= $params->getTitle() ?>
    </<?= $params->getTitleTag() ?>>
<?php endif; ?>
<div class="module-content">
    <?= $datagrid->getTable($entries, $columns) ?>
    <?= $params->getMessage() ?>
</div>
</<?= $params->getModuleTag() ?>>
