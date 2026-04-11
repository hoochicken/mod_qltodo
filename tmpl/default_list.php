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
$returnUrl = base64_encode(Uri::getInstance()->toString());
$entries = array_map(fn($item) => $item->toArray(), $entries);

$entries = array_map(function ($item) use ($returnUrl) {
    $id = (int)$item['id'] ?? 0;
    $baseUrl = (string)($item[QltodoRepository::COLUMN_PAGE_URL] ?? '');
    $separator = str_contains($baseUrl, '?') ? '&' : '?';
    $urlWizard = new UrlWizard($baseUrl, $separator);
    $pageUrl = !empty($item['page_url']) ? $item['page_url'] : '';
    $menutItemTitle = !empty($item['menu_item_title']) ? $item['menu_item_title'] : (!empty($pageUrl) ? $pageUrl : 'menu item');

    $item['gotolink'] = sprintf('<a href="%s">%s</a>', $pageUrl, substr($menutItemTitle, -20));
    $item['edit'] = sprintf('<a href="%s" class="btn btn-secondary btn-sm">%s</a>', $urlWizard->getEditUrl($id), Text::_('JACTION_EDIT'));
    $item['delete'] = sprintf(
            '<a href="%s" class="btn btn-danger btn-sm" onclick="return confirm(\'%s\');">%s</a>',
            $urlWizard->getDeleteUrl($id),
            Text::_('JGLOBAL_CONFIRM_DELETE'),
            Text::_('JACTION_DELETE')
    );
    return $item;
}, $entries);

$datagrid = new DataGrid();
?>

<?= $datagrid->getTable($entries, $columns) ?>
<?= $params->getMessage() ?>
