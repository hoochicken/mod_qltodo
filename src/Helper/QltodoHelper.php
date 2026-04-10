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

class QltodoHelper
{

    private ?QltodoRepository $qltodoRepository = null;

    public function __construct(array $config = [])
    {
        $this->qltodoRepository = $config[QltodoRepository::class] ?? null;
    }

    public function getQlTodoEntries(): array
    {
        return $this->getQltodoRepository()->getData();
    }

    public function getQlTodoEntryById(int $id): ?TodoItem
    {
        return $this->getQltodoRepository()->getEntryById($id);
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

    private function getQltodoRepository(): ?QltodoRepository
    {
        return $this->qltodoRepository;
    }
}