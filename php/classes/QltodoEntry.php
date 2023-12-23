<?php
class QltodoEntry extends \Hoochicken\ParameterBag\ParameterBag
{
    const COLUMN_ID = 'id';
    const COLUMN_TITLE = 'title';
    const COLUMN_DESCRIPTION = 'description';
    const COLUMN_PAGE_URL = 'page_url';
    const COLUMN_MENU_ITEM_ID = 'menu_item_id';
    const COLUMN_MENU_ITEM_TITLE = 'menu_item_title';
    const COLUMN_STATE = 'state';
    const COLUMN_WORKFLOW = 'workflow';
    const COLUMN_SEVERITY = 'severity';
    const COLUMN_CREATED_AT = 'created_at';
    const COLUMN_CREATED_BY = 'created_by';
    const COLUMN_MODIFIED_AT = 'modified_at';
    const COLUMN_MODIFIED_BY = 'modified_by';
    const COLUMN_DELETED_AT = 'deleted_at';
    const COLUMN_DELETED_BY = 'deleted_by';

    public function getId(): int
    {
        return $this->getInt(self::COLUMN_ID, 0);
    }

    public function getTitle(): string
    {
        return $this->getString(self::COLUMN_TITLE, 0);
    }

    public function getDescription(): string
    {
        return $this->getString(self::COLUMN_DESCRIPTION, 0);
    }

    public function getPageUrl(): string
    {
        return $this->getString(self::COLUMN_PAGE_URL, '');
    }

    public function getMenuItemId(): int
    {
        return $this->getInt(self::COLUMN_MENU_ITEM_ID, 0);
    }

    public function getMenuItemTitle(): string
    {
        return $this->getString(self::COLUMN_MENU_ITEM_TITLE, '');
    }

    public function getState(): int
    {
        return $this->getInt(self::COLUMN_STATE, 1);
    }

    public function getWorkflow(): int
    {
        return $this->getInt(self::COLUMN_WORKFLOW, 1);
    }

    public function getSeverity(): int
    {
        return $this->getInt(self::COLUMN_SEVERITY, 1);
    }

    public function getCreatedBy(): int
    {
        return $this->getInt(self::COLUMN_CREATED_BY, 0);
    }

    public function getCreatedAt(): string
    {
        return $this->getString(self::COLUMN_CREATED_AT, '');
    }

    public function getModifiedBy(): int
    {
        return $this->getInt(self::COLUMN_MODIFIED_BY, 0);
    }

    public function getModifiedAt(): string
    {
        return $this->getString(self::COLUMN_MODIFIED_AT, '');
    }

    public function getDeletedBy(): int
    {
        return $this->getInt(self::COLUMN_DELETED_BY, 0);
    }

    public function getDeletedAt(): string
    {
        return $this->getString(self::COLUMN_DELETED_AT, '');
    }
}