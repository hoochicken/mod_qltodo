<?php

namespace Hoochicken\Module\Qltodo\Site\Helper;

use DateTimeImmutable;
use Joomla\CMS\Language\Text;

class TodoItem
{
    public int $id = 0;
    public string $title = '';
    public string $description = '';
    public string $page_url = '';
    public int $menu_item_id = 0;
    public string $menu_item_title = '';
    public int $state = 1;
    public int $workflow = 1;
    public ?SeverityItem $severity = null;
    public ?DateTimeImmutable $created_at;
    public int $created_by = 0;
    public ?DateTimeImmutable $modified_at;
    public int $modified_by = 0;
    public ?DateTimeImmutable $deleted_at;
    public int $deleted_by = 0;

    public function toArray(): array
    {
        return [
            QltodoRepository::COLUMN_ID => $this->id,
            QltodoRepository::COLUMN_TITLE => $this->title,
            QltodoRepository::COLUMN_DESCRIPTION => $this->description,
            QltodoRepository::COLUMN_PAGE_URL => $this->page_url,
            QltodoRepository::COLUMN_SEVERITY => Text::_($this->severity?->label ?? ''),
            QltodoRepository::COLUMN_STATE => (string) $this->state,
            QltodoRepository::COLUMN_CREATED_AT => $this->created_at?->format('d.m.Y') ?? '',
        ];
    }

    public function getPageUrl(): string
    {
        return $this->page_url;
    }

    public function setPageUrl(string $page_url): TodoItem
    {
        $this->page_url = $page_url;
        return $this;
    }

    public function getMenuItemId(): int
    {
        return $this->menu_item_id;
    }

    public function setMenuItemId(int $menu_item_id): TodoItem
    {
        $this->menu_item_id = $menu_item_id;
        return $this;
    }

    public function getMenuItemTitle(): string
    {
        return $this->menu_item_title;
    }

    public function setMenuItemTitle(string $menu_item_title): TodoItem
    {
        $this->menu_item_title = $menu_item_title;
        return $this;
    }
}
