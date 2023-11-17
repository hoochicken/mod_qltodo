<?php
/**
 * @package		mod_qltodo
 * @copyright	Copyright (C) 2022 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// namespace QlformNamespace\Module\Qltodo\Site\Helper;

// no direct access
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseInterface;
// use QlformNamespace\Module\Qltodo\Site\Helper\php\QltodoTable;

defined('_JEXEC') or die;
require_once __DIR__ . '/QltodoHelper.php';
require_once __DIR__ . '/php/classes/QltodoError.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/php/classes/QltodoTable.php';

/** @var stdClass $module */
/** @var \Joomla\Registry\Registry $params */

try {
    // set up
    $errores = new QltodoError;
    $app = Factory::getApplication();
    $config = Factory::getContainer()->get('config');
    $input = Factory::getApplication()->getInput();
    $helper = new QltodoHelper($module, $params, Factory::getContainer()->get(DatabaseInterface::class), $config);
    $originalUrl = $helper->getOriginalUrl($helper->getCurrentUrl());
    $baseUrl = QltodoHelper::getBaseUrl();
    $columnsLinked = explode(',', $params->get('columnsLinked', ''));
    $entry = [];
    $displayNavigation = (bool)$params->get('navigation', false);
    $cardLinkDisplay = $params->get('cardLinkDisplay', false);
    array_walk($columnsLinked, function(&$item) {$item = trim($item);});

    // init database table
    $qltodoTable = new QltodoTable($config->get('host', ''), $config->get('db', ''), $config->get('user', ''), $config->get('password', ''), $config->get('port', 3306));
    $qltodoTable->setTable(str_replace('#__', $config->get('dbprefix', ''), QltodoTable::TABLE_NAME));
    if (!$qltodoTable->tableExistsQltodo()) {
        $qltodoTable->createTableQltodo();
    }

    // add
    $qltodoTable->addQltodo('Georgina Marshall', true);

    // remove
    $id = 2;
    $qltodoTable->removeEntryById($id);

    // get entry by id
    $entry = $qltodoTable->getEntryById(4);

    // update entry by id
    $qltodoTable->updateQltodo(4, []);

    // get data
    $data = $qltodoTable->getData();




    /* initiate mappings of table, cards and entry */
    $entryStructure = $helper->getEntryColumnType();
    $typeMappingEntry = $helper->getEntryColumnType();
    $typeMappingTable = $helper->getColumnType();
    $typeMappingCards = [
        $params->get('cardImageColumn', '') => QltodoHelper::TYPE_IMAGE,
        $params->get('cardLabelColumn', '') => QltodoHelper::TYPE_TEXT,
    ];
    $typeMapping = $params->get('display', QltodoHelper::DISPLAY_TABLE) === QltodoHelper::DISPLAY_CARDS
        ? $typeMappingCards
        : $typeMappingTable;

    // display vars initiated
    $displayEntry = $helper->checkDisplayEntry($input);
    $displayList = !$displayEntry || $params->get('list_display', true);
    $displayBackToList = (bool)$params->get('back_to_list', false);
    $ident = $input->getInt(QltodoHelper::GETPARAM_ENTRYID, 0);
    $label = Text::_($params->get('label_more', ''));

    /* get data of single entry, if needed */
    if ($displayEntry) {
        $entry = $helper->getEntry($ident);
        $entry = $helper->flattenData($entry, $typeMapping, (bool)$params->get('entry_display', false), (bool)$params->get('imageTag', false), $columnsLinked);
    }

    /* get data image for cards */
    if (QltodoHelper::DISPLAY_CARDS === $params->get('display')) {
        $imageColumn = $params->get('cardImageColumn', '');
        $labelColumn = $params->get('cardLabelColumn', '');
        $cardCssClass = $params->get('cardCssClass', 'col-md-2');
        if (empty($imageColumn)) {
            $app->enqueueMessage('MOD_QLTODO_MSG_SET_IMAGECOLUMN');
        }
        if (empty($labelColumn)) {
            $app->enqueueMessage('MOD_QLTODO_MSG_SET_LABELCOLUMN');
        }
    }

    /* get data of rows */
    $columns = $helper->getColumnLabels();
    $data = $helper->getData();

    foreach ($data as $k => $item) {
        $data[$k] = $helper->flattenData($item, $typeMapping, (bool)$params->get('entry_display', false), (bool)$params->get('imageTag', false), $columnsLinked);
    }

    $prev = $helper->getPrev($data, $entry, $params->get('identColumn', 'id'));
    $next = $helper->getNext($data, $entry, $params->get('identColumn', 'id'));

    /* finally display */
    require ModuleHelper::getLayoutPath('mod_qltodo', $params->get('layout', 'default'));
} catch (Exception $e) {
    $app->enqueueMessage(implode('<br >', [$e->getMessage(), $e->getFile(), $e->getLine()]));
}
