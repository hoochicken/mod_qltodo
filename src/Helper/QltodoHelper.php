<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\Database\DatabaseInterface;
use Hoochicken\Module\Qltodo\Site\Helper\QltodoRepository;

class QltodoHelper
{

    private ?QltodoRepository $qltodoTable = null;

    public function getQlTodoEntries(): array
    {
        // init database table
        require_once JPATH_BASE . '/modules/mod_qltodo/vendor/autoload.php';
        $config = Factory::getContainer()->get('config');
        $this->qltodoTable = $this->getDbTable($config);

        // $this->qltodoTable->create('test', 'description');
        return $this->qltodoTable->getData();
    }

    private function getDbTable(Registry $config): QltodoRepository
    {
        $tableName = str_replace('#__', $config->get('dbprefix', ''), QltodoRepository::TABLE_NAME);
        $table = new QltodoRepository($config->get('host', ''), $config->get('db', ''), $config->get('user', ''), $config->get('password', ''), $config->get('port', 3306));
        $table->setTable($tableName);
        // $table->create('test' . rand(1,1000), 'description');
        if ($table->tableExistsQltodo()) {
            return $table;
        }
        return $table->createTableQltodo();
    }

    public function getMessage(Registry $params, $app): string
    {
        try {
            // Get the Joomla database object
            $db = Factory::getContainer()->get(DatabaseInterface::class);

            // Example database query
            /*
            $query = $db->getQuery(true)
                ->select($db->quoteName(['id', 'title', 'alias']))
                ->from($db->quoteName('#__content'))
                ->where($db->quoteName('state') . ' = 1')
                ->order($db->quoteName('ordering') . ' ASC');
            
            $db->setQuery($query);
            $items = $db->loadObjectList();
            */

            // Example: Get parameters
            return (string) $params->get('message', '');

            // Example: Load component parameters
            /*
            $componentParams = ComponentHelper::getParams('com_content');
            $defaultLimit = $componentParams->get('default_limit', 10);
            */

            // Example: Process data
            /*
            foreach ($items as &$item) {
                $item->link = Route::_('index.php?option=com_content&view=article&id=' . $item->id);
                $item->introtext = HTMLHelper::_('content.prepare', $item->introtext);
            }
            */
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}