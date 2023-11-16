<?php

use Hoochicken\ParameterBag\ParameterBag;
use QlformNamespace\Module\Qltodo\Site\Helper\php\QltodoTable;

class Qltodo
{
    const PORT_DEFAULT = 3306;
    const TABLE_NAME = 'statistics';
    const DATE_FORMAT = 'Y-m-d H:i:s';
    private ?QltodoTable $qltodoTable;
    private static ?ParameterBag $server;
    private static string $sessionId = '';

    private static $dataToBeCollected = [
        QltodoTable::COLUMN_TITLE,
        QltodoTable::COLUMN_DESCRIPTION,
        QltodoTable::COLUMN_CREATED_AT,
        QltodoTable::COLUMN_PAGE_URL,
        QltodoTable::COLUMN_MENU_ITEM_ID,
        QltodoTable::COLUMN_MENU_ITEM_TITLE,
    ];

    public function initDb(string $host, string $database, string $user, string $password, int $port = self::PORT_DEFAULT)
    {
        $this->qltodoTable = new QltodoTable($host, $database, $user, $password, $port);
        $this->setTable(self::TABLE_NAME);
    }

    public function setTable(string $tablename)
    {
        $this->qltodoTable->setTable($tablename);
    }

    public function getTable(): string
    {
        return $this->qltodoTable->getTable();
    }

    public function getData(): array
    {
        return $this->qltodoTable->getData();
    }

    public function createTable()
    {
        $this->qltodoTable->createTableStatistics();
    }

    public function tableExists(): bool
    {
        return $this->qltodoTable->tableExists($this->qltodoTable->getTable());
    }

    public function getServer(): ParameterBag
    {
        return static::$server;
    }

    public function addEntry(string $title = '', string $description = '')
    {
        $entry = [
            QltodoTable::COLUMN_TITLE => $title,
            QltodoTable::COLUMN_DESCRIPTION => $description,
            QltodoTable::COLUMN_CREATED_AT => date(static::DATE_FORMAT),
            QltodoTable::COLUMN_PAGE_URL => self::getPageUrl(),
        ];

        $dataToBeCollected = static::getDataToBeCollected();
        $entry = array_filter($entry, function($key) use ($dataToBeCollected) {
            return in_array($key, $dataToBeCollected);
        }, ARRAY_FILTER_USE_KEY);
        // $entry = array_intersect_key($entry, array_flip(self::getDataToBeCollected()));
        $this->qltodoTable->addEntry($entry);
    }

    public function setDataToBeCollected(array $value)
    {
        static::$dataToBeCollected = $value;
    }

    public function getDataToBeCollected(): array
    {
        return static::$dataToBeCollected;
    }

    public function getBrowser(): string
    {
        return static::getServer()->getString('HTTP_USER_AGENT');
    }

    public function getPageUrl(): string
    {
        return static::getServer()->getString('REQUEST_URI');
    }
}
