<?php

namespace QlformNamespace\Module\Qltodo\Site\Helper\php;

use Hoochicken\Dbtable\Database;
use Hoochicken\ParameterBag\ParameterBag;
use Joomla\Registry\Registry;
use PDO;
use Qltodo;

class QltodoTable extends Database
{
    const TABLE_NAME = 'qltodo';
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

    private ?ParameterBag $config = null;

    protected static array $definition = [];

    public function __construct(string $host, string $database, string $user, string $password, int $port = self::PORT_DEFAULT)
    {
        parent::__construct($host, $database, $user, $password, $port);
        $this->setTable(static::TABLE_NAME);
        $this->setDefinition();
    }

    public function createTableStatistics()
    {
        $this->createTable(static::getTable(), static::$definition);
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
            static::COLUMN_CREATED_AT => sprintf('`%s` timestamp DEFAULT NULL DEFAULT current_timestamp()', static::COLUMN_CREATED_AT),
            static::COLUMN_CREATED_BY => sprintf('`%s` int(20) NOT NULL', static::COLUMN_CREATED_BY),
            static::COLUMN_MODIFIED_AT => sprintf('`%s` timestamp DEFAULT NULL DEFAULT current_timestamp()', static::COLUMN_MODIFIED_AT),
            static::COLUMN_MODIFIED_BY => sprintf('`%s` int(20) NOT NULL', static::COLUMN_MODIFIED_BY),
            static::COLUMN_DELETED_AT => sprintf('`%s` timestamp DEFAULT NULL DEFAULT current_timestamp()', static::COLUMN_DELETED_AT),
            static::COLUMN_DELETED_BY => sprintf('`%s` int(20) NOT NULL', static::COLUMN_DELETED_BY),
        ];
    }

    public function getDefinition()
    {
        return static::$definition;
    }

    public function add(string $title = '', string $description = '')
    {
        $this->addEntry($title, $description);
    }

    private function initQltodoTable(): Qltodo
    {
        $qltodo = new \Qltodo();
        $qltodo->initDb($this->getDbHost(), $this->getDbDatabase(), $this->getDbUser(), $this->getDbPassword());
        $qltodo->setTable($this->getDbTablename());
        if (!$qltodo->tableExists()) {
            $qltodo->createTable();
        }
        return $qltodo;
    }

    protected function getDbHost(): string
    {
        return $this->config->get('host', '');
    }

    protected function getDbPrefix(): string
    {
        return $this->config->get('dbprefix', '');
    }

    protected function getDbDatabase(): string
    {
        return $this->config->get('db', '');
    }

    protected function getDbUser(): string
    {
        return $this->config->get('user', '');
    }

    protected function getDbPassword(): string
    {
        return $this->config->get('password', '');
    }
}