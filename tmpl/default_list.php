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
use Hoochicken\Module\Qltodo\Site\Helper\UrlWizard;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
$columns = [
    QltodoRepository::COLUMN_TITLE => 'Title',
    // QltodoRepository::COLUMN_DESCRIPTION => 'Description',
    'gotolink' => 'Go to',
    QltodoRepository::COLUMN_SEVERITY => 'Severity',
    QltodoRepository::COLUMN_STATE => 'State',
    // QltodoRepository::COLUMN_CREATED_AT => 'Created at',
    'edit' => '',
    'delete' => '',
];

/** @var TodoItem[] $entries */
$entries = $displayData->getQltodoEntries();
$httpDomain = Uri::root();
$returnUrl = base64_encode($httpDomain);
$entries = array_map(fn($item) => $item->toArray(), $entries);

$entries = array_map(function ($item) use ($httpDomain, $returnUrl) {
    $id = (int)($item['id'] ?? 0);
    $baseUrl = (string)($item[QltodoRepository::COLUMN_PAGE_URL] ?? '');
    $separator = str_contains($baseUrl, '?') ? '&' : '?';
    $urlWizard = new UrlWizard($httpDomain, $baseUrl, $separator);
    $pageUrl = !empty($item['page_url']) ? $item['page_url'] : '';
    $menutItemTitle = !empty($item['menu_item_title']) ? $item['menu_item_title'] : (!empty($pageUrl) ? $pageUrl : 'menu item');

    $item['gotolink'] = sprintf(
        '<a href="%s">%s</a>',
        htmlspecialchars($pageUrl, ENT_QUOTES, 'UTF-8'),
        htmlspecialchars(mb_substr($menutItemTitle, -20), ENT_QUOTES, 'UTF-8')
    );
    // $item['edit'] = sprintf('<a href="%s" class="btn btn-secondary btn-sm">%s</a>', $urlWizard->getEditUrl($id), Text::_('JACTION_EDIT'));
    $item['edit'] = sprintf('<a href="%s" class="btn btn-sm btn-secondary" title="%s" aria-label="%s">%s</a>', $urlWizard->getEditUrl($id), Text::_('JACTION_EDIT'), Text::_('JACTION_EDIT'), '&#9998;');
    $item['delete'] = sprintf(
            '<a href="%s" class="btn btn-sm btn-danger" title="%s" aria-label="%s" onclick="return confirm(\'%s\');">%s</a>',
            $urlWizard->getDeleteUrl($id),
            Text::_('JACTION_DELETE'),
            Text::_('JACTION_DELETE'),
            Text::_('JGLOBAL_CONFIRM_DELETE', true),
            // Text::_('JACTION_DELETE')
            '&#10006;'
    );
    return $item;
}, $entries);

$datagrid = new DataGrid();
$datagrid->setTableClass('table table-sm table-striped table-hover align-middle');
?>

<div class="table-responsive">
    <?= $datagrid->getTable($entries, $columns) ?>
</div>
<?= $params->getMessage() ?>
