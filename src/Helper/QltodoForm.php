<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

defined('_JEXEC') or die;

class QltodoForm
{
    public const MODULE_PREFIX = 'mod_qltodo';
    public const PARAM_TODO_ID = 'qltodoid';
    public const PARAM_TODO_TASK = 'qltodotask';
    public const TASK_TASK = 'task';
    public const TASK_CLOSE = 'todo.close';
    public const TASK_CREATE = 'todo.create';
    public const TASK_EDIT = 'todo.edit';
    public const TASK_SAVE = 'todo.save';
    public const TASK_SAVE_AND_CLOSE = 'todo.save.close';
    public const TASK_DELETE = 'todo.delete';

    public static function isTaskClose(?string $task): bool
    {
        return $task === self::TASK_CLOSE;
    }

    public static function isTaskDelete(?string $task): bool
    {
        return $task === self::TASK_DELETE;
    }

    public static function isTaskSave(?string $task): bool
    {
        return $task === self::TASK_SAVE || self::isTaskSaveAndClose($task);
    }

    public static function isTaskSaveAndClose(?string $task): bool
    {
        return $task === self::TASK_SAVE_AND_CLOSE;
    }
}
