<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

use Hoochicken\Datagrid\Datagrid;
use Hoochicken\Module\Qltodo\Site\Helper\DisplayData;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoRepository;
use Hoochicken\Module\Qltodo\Site\Helper\TodoItem;

defined('_JEXEC') or die;

/** @var ?DisplayData $displayData */
$params = $displayData->getParams();
$columns = [
    QltodoRepository::COLUMN_TITLE => 'Title',
    QltodoRepository::COLUMN_DESCRIPTION => 'Description',
    QltodoRepository::COLUMN_SEVERITY => 'Severity',
    QltodoRepository::COLUMN_STATE  => 'State',
    QltodoRepository::COLUMN_CREATED_AT => 'Created at',
];

/** @var TodoItem[] $entries */
$entries = $displayData->getQltodoEntries();
$entries = array_map(fn($item) => $item->toArray(), $entries);
$datagrid = new DataGrid();
?>

<<?= $params->getModuleTag() ?> class="<?php echo 'mod_qltodo ' . $params->getModuleClassSuffix(); ?>">
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
