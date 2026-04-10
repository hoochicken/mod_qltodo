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
    public const TASK_EDIT = 'todo.edit';
    public const TASK_DELETE = 'todo.delete';
}
