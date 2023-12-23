<?php
/**
 * @package        mod_qlqltodo
 * @copyright    Copyright (C) 2023 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Hoochicken\ParameterBag\ParameterBag;

defined('_JEXEC') or die;

class QltodoHelper
{
    public Joomla\Registry\Registry $params;
    public Joomla\Registry\Registry $config;
    public stdClass $module;
    public ParameterBag $request;
    public ?QltodoTable $qltodoTable;
    public $db;
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const GETPARAM_MODULEID = 'modqltodo';
    const GETPARAM_ENTRYID = 'modqltodoentryid';
    const QLTODO = 'qlbdtable';
    const QLTODO_TAGS = 'qlbdtable_tags';
    const QLTODO_RAW_DATA = 'qlbdtable_raw_data';
    const QLTODO_URL = 'url';
    const URL_SCHEME = '%s://%s%s';

    const COLUMN_ID = 'id';
    const FORM_ID = 'qltodo_id';
    const FORM_ACTION_SAVE = 'qltodo_save';
    const FORM_ACTION_LOAD = 'qltodo_load';
    const FORM_ACTION_DELETE = 'qltodo_delete';
    const FORM_ACTION_UPDATE = 'qltodo_update';
    const FORM_TITLE = 'qltodo_title';
    const FORM_DESCRIPTION = 'qltodo_description';
    const FORM_MENUITEMTITLE = 'qltodo_menuItemTitle';
    const FORM_MENUITEMTID = 'qltodo_menuItemId';
    const FORM_STATE = 'qltodo_state';
    const FORM_WORKFLOW = 'qltodo_workflow';
    const FORM_SEVERITY = 'qltodo_severity';

    function __construct($module, $params, $db, $config, ParameterBag $request)
    {
        $this->module = $module;
        $this->params = $params;
        $this->db = $db;
        $this->config = $config;
        $this->request = $request;
    }

    public function initDbTable($config)
    {
        // init database table
        $this->qltodoTable = new QltodoTable($config->get('host', ''), $config->get('db', ''), $config->get('user', ''), $config->get('password', ''), $config->get('port', 3306));
        $this->qltodoTable->setTable(str_replace('#__', $config->get('dbprefix', ''), QltodoTable::TABLE_NAME));
        if (!$this->qltodoTable->tableExistsQltodo()) {
            $this->qltodoTable->createTableQltodo();
        }
    }

    public function createQltodo(ParameterBag $request)
    {
        $this->qltodoTable->createQltodo(
            $request->getString(static::FORM_TITLE, ''),
            $request->getString(static::FORM_DESCRIPTION, ''),
            $request->getString(static::FORM_MENUITEMTITLE, ''),
            $request->getInt(static::FORM_MENUITEMTID, 0),
            $request->getInt(static::FORM_STATE, 1),
            $request->getInt(static::FORM_WORKFLOW, 1),
            $request->getInt(static::FORM_SEVERITY, 1),
            $request->getString('REQUEST_URI', $request->getString('SCRIPT_NAME', ''))
        );
    }

    public function removeEntryById(int $id)
    {
        $this->qltodoTable->removeEntryById($id);;
    }

    public function getEntryById(int $id): array
    {
        return $this->qltodoTable->getEntryById($id);
    }

    public function updateQltodo(int $id, array $data): array
    {
        $this->qltodoTable->updateQltodo($id, $data);
        return $this->qltodoTable->getEntryById($id);
    }

    public function getData(): array
    {
        return $this->qltodoTable->getData();
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
        if (is_null($entry)) {
            return null;
        }
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
        if (is_null($entry)) {
            return null;
        }
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

    public function getBaseUrl(): string
    {
        return (empty($this->request->getString('HTTPS', '')) ? 'http' : 'https') . '://' . $this->request->getString('HTTP_HOST', '') . $this->request->getString('REQUEST_URI', '');
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
