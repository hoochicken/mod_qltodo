<?php
/**
 * @package        mod_qlqltodo
 * @copyright    Copyright (C) 2023 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class QltodoHelper
{
    public Joomla\Registry\Registry $params;
    public stdClass $module;
    public $db;
    const NUMBER_COLUMNS = 10;
    const DISPLAY_DEFAULT = 'table';
    const DISPLAY_TABLE = 'table';
    const DISPLAY_CARDS = 'cards';
    const TYPE_COLNAME = 'colname';
    const TYPE_LABEL = 'label';
    const TYPE_TYPE = 'type';
    const PRFX_ENTRY = 'entry_';
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const HTML_IMG = '<img src="%s" />';
    const HTML_AHREF = '<a href="%s" />%s</a>';
    const HTML_AHREF_BUTTON = '<a class="btn btn-outline-secondary" href="%s" />%s</a>';
    const GETPARAM_MODULEID = 'modqltodo';
    const GETPARAM_ENTRYID = 'modqltodoentryid';
    const QLTODO = 'qlbdtable';
    const QLTODO_TAGS = 'qlbdtable_tags';
    const QLTODO_RAW_DATA = 'qlbdtable_raw_data';
    const QLTODO_ID = 'id';
    const QLTODO_MODULEID = 'module_id';
    const QLTODO_LINK = 'link';
    const QLTODO_URL = 'url';
    const URL_SCHEME = '%s://%s%s';

    function __construct($module, $params, $db)
    {
        $this->module = $module;
        $this->params = $params;
        $this->db = $db;
    }

    public function getData(): array
    {
        $data = $this->getDataRaw();
        foreach ($data as $k => $entry) {
            $data[$k] = $this->enrichEntryWithDefaults($entry);
        }
        return $data;
    }

    public function getIdentFromEntry(array $entry, string $identColumn)
    {
        return $entry[$identColumn] ?? null;
    }

    public function getEntryByAttribute(array $data, string $attrColumn, string $value): array
    {
        $entries = array_filter($data, function($entry) use ($attrColumn, $value) {
            return $entry[$attrColumn] == $value;
        });
        return is_array($entries) && 0 < count($entries) ? array_pop($entries) : [];
    }

    public function getPrev(array $data, ?array $entry, string $identColumn): ?array
    {
        $keyPrev = null;
        $identEntry = $this->getIdentFromEntry($entry, $identColumn);
        foreach ($data as $key => $item) {
            $identTmp = $this->getIdentFromEntry($item, $identColumn);
            if ($identTmp == $identEntry) {
                break;
            }
            $keyPrev = $key;
        }
        return is_null($keyPrev)
            ? null
            : $data[$keyPrev] ?? null;
    }

    public function getNext(array $data, ?array $entry, string $identColumn): ?array
    {
        $keyNext = null;
        $next = false;
        $identEntry = $this->getIdentFromEntry($entry, $identColumn);
        foreach ($data as $key => $item) {
            $identTmp = $this->getIdentFromEntry($item, $identColumn);
            if ($next) {
                $keyNext = $key;
                break;
            }
            if ($identTmp == $identEntry) {
                $next = true;
            }
        }
        return is_null($keyNext)
            ? null
            : $data[$keyNext] ?? null;
    }

    public function getDataRaw(): array
    {
        return $this->params->get('use_raw_query', false)
            ? $this->getDataByRawQuery()
            : $this->getDataByTable();
    }

    public function setImageMultiple(array $data, array $columnsDataMap = [], string $defaultImage = ''): array
    {
        if (0 === count($data) || 0 === count($columnsDataMap)) {
            return $data;
        }
        foreach ($data as $k => $item) {
            $data[$k] = $this->setImage($item, $columnsDataMap, $defaultImage);
        }
        return $data;
    }

    public function setImage(array $entry, array $columnsDataMap = [], string $defaultImage = ''): array
    {
        foreach ($columnsDataMap as $colname => $type) {
            if (QltodoHelper::TYPE_IMAGE !== $type || (empty($entry[$colname]) && empty($defaultImage))) {
                continue;
            }
            $entry[$colname] = empty($entry[$colname]) ? $defaultImage : $entry[$colname];
            $entry[QltodoHelper::QLTODO_TAGS][$colname] = static::generateHtmlImage($entry[$colname]);
        }
        return $entry;
    }

    public function addTags(array $entry, string $linkText, int $moduleId, string $baseUrl = '', string $identColumn = 'id'): array
    {
        $id = $entry[$identColumn] ?? sprintf('Column %s was not found', $identColumn);
        $url = QltodoHelper::getUrl($baseUrl, $moduleId, $id);
        $entry[QltodoHelper::QLTODO_TAGS][QltodoHelper::QLTODO_LINK] = QltodoHelper::getLink($baseUrl, $linkText, $moduleId, $id);
        $entry[QltodoHelper::QLTODO][QltodoHelper::GETPARAM_ENTRYID] = $id;
        $entry[QltodoHelper::QLTODO][QltodoHelper::GETPARAM_MODULEID] = $moduleId;
        $entry[QltodoHelper::QLTODO][QltodoHelper::QLTODO_URL] = $url;
        return $entry;
    }

    public function flattenData(array $entry, array $typeMapping, bool $entryDisplay = false, bool $imageTag = false, array $columnsLinked = []): array
    {
        foreach($typeMapping as $columnName => $type) {
            if ($imageTag && static::TYPE_IMAGE === $type) {
                $entry[$columnName] = $entry[QltodoHelper::QLTODO_TAGS][$columnName] ?? $entry[$columnName];
            }
            if ($entryDisplay && in_array($columnName, $columnsLinked)) {
                $url = $entry[static::QLTODO][static::QLTODO_URL];
                $entry[$columnName] = static::generateHtmlLink($url, $entry[$columnName] ?? '');
            }
        }
        return $entry;
    }

    public static function getBaseUrl(): string
    {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public static function getLink(string $baseUrl, string $linkText, int $moduleId, $ident): string
    {
        $url = static::getUrl($baseUrl, $moduleId, $ident);
        return static::generateHtmlLink($url, $linkText);
    }

    public static function generateHtmlLink(string $url, string $linkText): string
    {
        return sprintf(QltodoHelper::HTML_AHREF, $url, $linkText);
    }

    public static function generateHtmlButton(string $url, string $linkText): string
    {
        return sprintf(QltodoHelper::HTML_AHREF_BUTTON, $url, $linkText);
    }

    public static function generateHtmlImage(string $imagePath): string
    {
        return sprintf(QltodoHelper::HTML_IMG, $imagePath);
    }

    public static function getUrl(string $baseUrl, int $moduleId, $ident): string
    {
        $link = sprintf('%s=%s&%s=%s',
            QltodoHelper::GETPARAM_MODULEID, $moduleId,
            QltodoHelper::GETPARAM_ENTRYID, $ident
        );

        $regex = QltodoHelper::GETPARAM_MODULEID . '|' . QltodoHelper::GETPARAM_ENTRYID;
        $baseUrl = preg_replace('/(&|\?)(' . $regex . ')=([0-9]*)/', '', $baseUrl);

        if (false !== strpos($baseUrl, '?')) {
            $link = $baseUrl . '&' . $link;
        } else {
            $link = $baseUrl . '?' . $link;
        }
        return $link;
    }

    public function getColumnType(string $prefix = ''): array
    {
        return $this->getColumnInfo(QltodoHelper::TYPE_TYPE, $prefix);
    }

    public function getEntryStructure(): array
    {
        return $this->getStructure(QltodoHelper::PRFX_ENTRY);
    }

    public function getEntryColumnType(): array
    {
        return $this->getColumnInfo(QltodoHelper::TYPE_TYPE, QltodoHelper::PRFX_ENTRY);
    }

    public function getColumnLabels(string $prefix = ''): array
    {
        return $this->getColumnInfo(QltodoHelper::TYPE_LABEL, $prefix);
    }

    public function getEntryColumnLabels(): array
    {
        return $this->getColumnInfo(QltodoHelper::TYPE_LABEL, QltodoHelper::PRFX_ENTRY);
    }

    public function getColumnInfo(string $type, string $prefix = '')
    {
        $structure = $this->getStructure($prefix);
        array_walk($structure, function (&$item) use ($type) {
            $item = $item[$type];
        });
        return $structure;
    }

    public function getStructure(string $prefix = ''): array
    {
        $columnField = $prefix . 'column%s';

        $structure = [];
        for ($i = 1; $i <= QltodoHelper::NUMBER_COLUMNS; $i++) {

            $fieldname = sprintf($columnField, $i);
            $column = $this->params->get($fieldname);
            $columnDisplay = explode(';', (string)$column);
            if (3 !== count($columnDisplay)) {
                continue;
            }
            $columnName = $columnDisplay[0];
            $columnLabel = $columnDisplay[1];
            $columnType = $columnDisplay[2];

            $structure[$columnName] = [
                'column' => $columnName,
                QltodoHelper::TYPE_COLNAME => $columnName,
                QltodoHelper::TYPE_TYPE => $columnType,
                QltodoHelper::TYPE_LABEL => $columnLabel,
            ];
        }
        return $structure;
    }

    private function getDataByRawQuery(): array
    {
        $this->db->setQuery($this->params->get('raw_query'));
        return $this->db->loadAssocList();
    }

    private function getDataByTable(): array
    {
        $tablename = $this->params->get('tablename', '');
        if (empty($tablename)) {
            return [];
        }

        $query = $this->db->getQuery(true);
        $query->select('*');
        $query->from($tablename);

        $condition = trim($this->params->get('conditions', ''));
        if (!empty($condition)) {
            $query->where($condition);
        }

        $orderBy = trim((string)$this->params->get('order_by', ''));
        if (!empty($orderBy)) {
            $query->order($orderBy);
        }

        $this->db->setQuery($query);

        return $this->db->loadAssocList();
    }

    public function checkDisplayEntry(Joomla\Input\Input $input): bool
    {
        return
            $this->params->get('entry_display', false)
            && (int)$this->module->id === (int)$input->get(QltodoHelper::GETPARAM_MODULEID)
            && is_numeric($input->get(QltodoHelper::GETPARAM_ENTRYID));
    }

    public function getEntry($ident): array
    {
        $entry = $this->getEntryRaw($ident);
        return $this->enrichEntryWithDefaults($entry);
    }

    public function getEntryRaw($ident): array
    {
        $tablename = $this->params->get('tablename', '');
        $identColumn = $this->params->get('identColumn', '');
        if (empty($tablename) || empty($identColumn)) {
            return [];
        }

        $query = $this->db->getQuery(true);
        $query->select('*');
        $query->from($tablename);
        $where = sprintf('%s = %s', $identColumn, $query->escape($ident));
        $query->where($where);

        $condition = trim($this->params->get('conditions'));
        if (!empty($condition)) {
            $query->where($condition);
        }

        $this->db->setQuery($query);
        return $this->db->loadAssoc() ?? [];
    }

    public function enrichEntryWithDefaults(array $entry): array
    {
        $entry[QltodoHelper::QLTODO_RAW_DATA] = $entry;
        $entry[QltodoHelper::QLTODO_TAGS] = [];
        $entry[QltodoHelper::QLTODO] = [];
        return $entry;
    }

    public function getCurrentUrl(): string
    {
        return sprintf(static::URL_SCHEME, $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
    }

    public function getOriginalUrl(string $url): string
    {
        $regex = sprintf('/([?&])%s=([0-9]*)/', static::GETPARAM_ENTRYID);
        return preg_replace($regex, '', $url);
    }
}
