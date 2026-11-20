<?php
/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

use Joomla\Registry\Registry;
use stdClass;

require_once __DIR__ . '/ParametersBasicInterface.php';
require_once __DIR__ . '/ParametersCustomInterface.php';

class ParametersCustom extends ParametersBasic implements ParametersBasicInterface, ParametersCustomInterface
{
    public function __construct(Registry $params, stdClass $module)
    {
        parent::__construct($params, $module);
    }

    public const DEFAULT_ITEM_BORDER_WIDTH = 0;
    public const DEFAULT_ITEM_BORDER_COLOR = '#fff';

    public function getItemBorderWidth(): int
    {
        return max(0, (int) $this->params->get('item_border_width', static::DEFAULT_ITEM_BORDER_WIDTH));
    }

    public function getItemBorderColor(): string
    {
        $color = trim((string) $this->params->get('item_border_color', static::DEFAULT_ITEM_BORDER_COLOR));
        // only allow hex colours, as the value is written into a style attribute
        return preg_match('/^#([0-9a-f]{3}|[0-9a-f]{4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $color)
            ? $color
            : static::DEFAULT_ITEM_BORDER_COLOR;
    }
}
