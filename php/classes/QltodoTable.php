<?php

// namespace QlformNamespace\Module\Qltodo\Site\Helper\php;

use Hoochicken\Dbtable\Database;
use Hoochicken\ParameterBag\ParameterBag;

class QltodoTable extends Database
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

    private ?ParameterBag $config;

    protected static array $definition = [];

    public function __construct(string $host, string $database, string $user, string $password, int $port = self::PORT_DEFAULT)
    {
        parent::__construct($host, $database, $user, $password, $port);
        $this->setTable(static::TABLE_NAME);
        $this->setDefinition();
    }

    public function createTableQltodo()
    {
        $this->createTable(static::getTable(), static::$definition);
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
            static::COLUMN_STATE => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_STATE),
            static::COLUMN_WORKFLOW => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_WORKFLOW),
            static::COLUMN_SEVERITY => sprintf('`%s` varchar(255) DEFAULT NULL', static::COLUMN_SEVERITY),
            static::COLUMN_CREATED_AT => sprintf('`%s` timestamp DEFAULT current_timestamp()', static::COLUMN_CREATED_AT),
            static::COLUMN_CREATED_BY => sprintf('`%s` int(20) NULL', static::COLUMN_CREATED_BY),
            static::COLUMN_MODIFIED_AT => sprintf('`%s` timestamp DEFAULT NULL', static::COLUMN_MODIFIED_AT),
            static::COLUMN_MODIFIED_BY => sprintf('`%s` int(20) DEFAULT NULL', static::COLUMN_MODIFIED_BY),
            static::COLUMN_DELETED_AT => sprintf('`%s` timestamp DEFAULT NULL', static::COLUMN_DELETED_AT),
            static::COLUMN_DELETED_BY => sprintf('`%s` int(20) DEFAULT NULL', static::COLUMN_DELETED_BY),
        ];
    }

    public function getDefinition()
    {
        return static::$definition;
    }

    public function addQltodo(string $title = '', string $description = '')
    {
        $this->addEntry([
            static::COLUMN_TITLE => $title,
            static::COLUMN_DESCRIPTION => $description,
            static::COLUMN_CREATED_AT => date(static::DB_DATE_FORMAT),
        ]);
    }

    public function removeQltodo(int $id)
    {
        $this->removeEntryById($id);
    }

    public function updateQltodo(int $id, array $data)
    {
        if (empty($data)) {
            return;
        }
        $this->updateEntries($data, sprintf('id = %s', $id));
    }

    public function getData(array $selector = [], int $limit = 1000): array
    {
        return parent::getData($selector, $limit);
    }

    public function getEntryById(int $id): array
    {
        $this->setWhere(sprintf('id = %s', $id));
        $data = parent::getData([], 1);
        return $data[0] ?? [];
    }

    public function getTable(): string
    {
        return static::$table;
    }
}