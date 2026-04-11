<?php

namespace Hoochicken\Module\Qltodo\Site\Helper;

use DateTimeImmutable;
use Hoochicken\Dbtable\Database;

class QltodoRepository extends Database
{
    const TABLE_NAME = '#__qltodo';
    const DB_DATE_FORMAT = 'Y-m-d H:i:s';
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
    const DB_HOST = 'host';
    const DB_DATABASE = 'database';
    const DB_USER = 'user';
    const DB_PASSWORD = 'password';
    const DB_PORT = 'port';

    private $config;

    protected static array $definition = [];

    public function __construct(string $host, string $database, string $user, string $password, int $port = self::PORT_DEFAULT)
    {
        parent::__construct($host, $database, $user, $password, $port);
        $this->setTable(static::TABLE_NAME);
        $this->setDefinition();
    }

    public function createTableQltodo(): self
    {
        $this->createTable(static::getTable(), static::$definition);
        return $this;
    }

    public function tableExistsQltodo(): bool
    {
        return $this->tableExists(static::getTable());
    }

    private function setDefinition()
    {
        static::$definition = [
            static::COLUMN_ID => sprintf('`%s` int(20) NOT NULL', static::COLUMN_ID),
            static::COLUMN_TITLE => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_TITLE),
            static::COLUMN_DESCRIPTION => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_DESCRIPTION),
            static::COLUMN_PAGE_URL => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_PAGE_URL),
            static::COLUMN_MENU_ITEM_TITLE => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_MENU_ITEM_TITLE),
            static::COLUMN_MENU_ITEM_ID => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_MENU_ITEM_ID),
            static::COLUMN_STATE => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_STATE),
            static::COLUMN_WORKFLOW => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_WORKFLOW),
            static::COLUMN_SEVERITY => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_SEVERITY),
            static::COLUMN_CREATED_AT => sprintf('`%s` datetime DEFAULT NULL', static::COLUMN_CREATED_AT),
            static::COLUMN_CREATED_BY => sprintf('`%s` int(20) NULL', static::COLUMN_CREATED_BY),
            static::COLUMN_MODIFIED_AT => sprintf('`%s` datetime DEFAULT NULL', static::COLUMN_MODIFIED_AT),
            static::COLUMN_MODIFIED_BY => sprintf('`%s` int(20) DEFAULT NULL', static::COLUMN_MODIFIED_BY),
            static::COLUMN_DELETED_AT => sprintf('`%s` datetime DEFAULT NULL', static::COLUMN_DELETED_AT),
            static::COLUMN_DELETED_BY => sprintf('`%s` int(20) DEFAULT NULL', static::COLUMN_DELETED_BY),
        ];
    }

    public function getDefinition()
    {
        return static::$definition;
    }

    public function create(string $title = '', string $description = '', string $pageUrl = '', string $menuItemTitle = '', string $menuItemId = '', int $severity = 1, int $state = 1, int $workflow = 1): int
    {
        $id = $this->addEntry([
            static::COLUMN_TITLE => $title,
            static::COLUMN_DESCRIPTION => $description,
            static::COLUMN_MENU_ITEM_TITLE => $menuItemTitle,
            static::COLUMN_MENU_ITEM_ID => $menuItemId,
            static::COLUMN_STATE => $state,
            static::COLUMN_WORKFLOW => $workflow,
            static::COLUMN_SEVERITY => $severity,
            static::COLUMN_PAGE_URL => $pageUrl,
            static::COLUMN_CREATED_AT => date(static::DB_DATE_FORMAT),
        ]);
        return $id;
    }

    public function delete(int $id): void
    {
        $this->removeEntryById($id);
    }

    public function update(TodoItem $entry): void
    {
        if (empty($entry)) {
            return;
        }
        $this->updateEntries([
            QltodoRepository::COLUMN_TITLE => $entry->title,
            QltodoRepository::COLUMN_DESCRIPTION => $entry->description,
        ], sprintf('id = %s', $entry->id));
    }

    /**
     * @param array $selector
     * @param int $limit
     * @return TodoItem[]
     */
    public function getData(array $selector = [], int $limit = 1000): array
    {
        $selector = !empty($selector)
            ? $selector
            : [
                static::COLUMN_ID,
                static::COLUMN_TITLE,
                static::COLUMN_DESCRIPTION,
                static::COLUMN_MENU_ITEM_TITLE,
                static::COLUMN_MENU_ITEM_ID,
                static::COLUMN_STATE,
                static::COLUMN_WORKFLOW,
                static::COLUMN_SEVERITY,
                static::COLUMN_PAGE_URL,
                static::COLUMN_CREATED_AT,
            ];
        $data = parent::getData($selector, $limit);
        return array_map(fn($item) => $this->convertToTodoItem($item), $data);
    }

    public function getEntryById(int $id): ?TodoItem
    {
        $this->setWhere(sprintf('id = %s', $id));
        $data = parent::getData([], 1);
        if (empty($data)) {
            return null;
        }
        $this->resetWhere();
        return $this->convertToTodoItem($data[0]);
    }

    public function getTable(): string
    {
        return static::$table;
    }

    private function convertToTodoItem($item): TodoItem
    {
        $todoItem = new TodoItem();
        $todoItem->id = (int) ($item['id'] ?? 0);
        $todoItem->title = $item['title'];
        $todoItem->description = $item['description'];
        $todoItem->page_url = (string) ($item['page_url'] ?? '');
        $todoItem->state = (int) ($item['state'] ?? 1);
        $todoItem->created_at = !empty($item['created_at']) ? new DateTimeImmutable($item['created_at']) : null;
        $todoItem->severity = new SeverityItem((int) ($item['severity'] ?? 1));
        $todoItem->menu_item_title = (string)$item['menu_item_title'] ?? '';
        $todoItem->menu_item_id = (int)$item['menu_item_id'] ?? 0;
        return $todoItem;
    }
}