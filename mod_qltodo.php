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
require_once __DIR__ . '/php/classes/QltodoSeverity.php';
require_once __DIR__ . '/php/classes/QltodoEntry.php';

/** @var stdClass $module */
/** @var \Joomla\Registry\Registry $params */

try {
    // set up
    $errores = new QltodoError;
    $app = Factory::getApplication();
    $config = Factory::getContainer()->get('config');
    $input = Factory::getApplication()->getInput();
    $request = new Hoochicken\ParameterBag\ParameterBag([...$_REQUEST, ...$_SERVER]);

    $helper = new QltodoHelper($module, $params, Factory::getContainer()->get(DatabaseInterface::class), $config, $request);
    $helper->initDbTable($config);

    $displayNavigation = (bool)$params->get('navigation', false);
    $displayList = $params->get('displayList', true);
    $displayEntry = false;
    $displayBackToList = false;
    $entry = new QltodoEntry();
    $entryData = [];

    // create
    if ($request->getString(QltodoHelper::FORM_ACTION_SAVE, 0)) {
        $helper->createQltodo($request);
    }

    // delete
    if ($request->getString(QltodoHelper::FORM_ACTION_DELETE, 0)) {
        $helper->removeEntryById($request->getString(QltodoHelper::FORM_ID, 0));
    }

    // load
    if ($request->getString(QltodoHelper::FORM_ACTION_LOAD, 0)) {
        $entryData = $helper->getEntryById($request->getString(QltodoHelper::FORM_ID, 0));
        $entry->setMultiple($entryData);
        $displayEntry = true;
    }

    // load
    if ($request->getString(QltodoHelper::FORM_ACTION_UPDATE, 0)) {
        $data = [];
        $entryData = $helper->updateQltodo($request->getString(QltodoHelper::FORM_ID), $data);
        $entry->setMultiple($entryData);
    }

    $helper->qltodoTable->setWhere('');
    $data = $helper->getData();
    $prev = $helper->getPrev($data, $entryData, $params->get('identColumn', 'id'));
    $next = $helper->getNext($data, $entryData, $params->get('identColumn', 'id'));
    array_walk($data, function(&$item) { $item = new QltodoEntry($item); });

    $displayForm = !$displayEntry;

    /* finally display */
    require ModuleHelper::getLayoutPath('mod_qltodo', $params->get('layout', 'default'));
} catch (Exception $e) {
    $app->enqueueMessage(implode('<br >', [$e->getMessage(), $e->getFile(), $e->getLine()]));
}
