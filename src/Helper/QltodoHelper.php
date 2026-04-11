<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

defined('_JEXEC') or die;

use Joomla\Input\Input;

class QltodoHelper
{

    private ?QltodoRepository $qltodoRepository;
    private ?SessionHelper $sessionHelper;

    public function __construct(array $config = [])
    {
        $this->qltodoRepository = $config[QltodoRepository::class] ?? null;
        $this->sessionHelper = $config[SessionHelper::class] ?? null;
    }

    public function isSessionCurrent(): bool
    {
        return $this->sessionHelper->isCurrent();
    }

    public function isSidebarVisible(): bool
    {
        return $this->sessionHelper->isSidebarVisible();
    }

    public function getQlTodoEntries(): array
    {
        return $this->getQltodoRepository()->getData();
    }

    public function getQlTodoEntriesCurrent(): array
    {
        $pageUrl = UrlWizard::getPageUrl();
        $menuItemId = UrlWizard::getMenuItemId();
        return $this->getQltodoRepository()->getCurrent([], 1000, $pageUrl, $menuItemId);
    }

    public function getQlTodoEntryById(int $id): ?TodoItem
    {
        return $this->getQltodoRepository()->getEntryById($id);
    }

    public function saveEntry(TodoItem $entry): TodoItem
    {
        $id = empty($entry->id)
            ? $this->createEntry($entry)
            : $this->updateEntry($entry);
        return $this->qltodoRepository->getEntryById($id);
    }

    public function deleteEntry(int $id): void
    {
        $this->qltodoRepository->delete($id);
    }

    public function createEntry(TodoItem $entry): int
    {
        return $this->qltodoRepository->create($entry->title, $entry->description, $entry->page_url, $entry->menu_item_title, $entry->menu_item_id);
    }

    public function updateEntry(TodoItem $entry): int
    {
        $this->qltodoRepository->update($entry);
        return $entry->id;
    }

    public function getTodoItemFromInput(Input $input): TodoItem
    {
        $item = new TodoItem();
        $item->id = $input->getInt(QltodoForm::PARAM_TODO_ID, 0);
        $item->title = $input->getString('title');
        $item->description = $input->getString('description');
        $item->severity = new SeverityItem($input->getInt('severity'));
        $item->page_url = $input->getString('page_url', UrlWizard::getPageUrlCleanedUp()());
        $item->menu_item_title = $input->getString('page_url', UrlWizard::getMenuTitle());
        $item->menu_item_id = $input->getString('page_url', UrlWizard::getMenuItemId());
        return $item;
    }

    private function getQltodoRepository(): ?QltodoRepository
    {
        return $this->qltodoRepository;
    }
}