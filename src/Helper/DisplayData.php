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

class DisplayData implements DisplayDataInterface
{
    private const DISPLAY_TYPE_LIST = 'list';
    private const DISPLAY_TYPE_DETAIL = 'detail';
    private const DISPLAY_TYPE_DEFAULT = self::DISPLAY_TYPE_LIST;

    private const DISPLAY_TYPES_ALL  = [self::DISPLAY_TYPE_LIST, self::DISPLAY_TYPE_DETAIL];

    private string $displayType = self::DISPLAY_TYPE_DEFAULT;
    private ParametersCustomInterface $params;
    private array $qltodoEntries = [];

    public function __construct(ParametersCustomInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @return array{message: string|null, params: Registry, module: stdClass}
     */
    public function toArray(): array
    {
        return [
            'data' => $this->params,
            'message' => $this->params->getMessage(),
            'params' => $this->getParams(),
            'module' => $this->getParams()->getModule(),
        ];
    }

    public function getParams(): ParametersCustom
    {
        return $this->params;
    }

    public function setMessage(?string $message): void
    {
        $this->params->setMessage($message);
    }

    public function setQltodoEntries(array $entries): void
    {
        $this->qltodoEntries = $entries;
    }

    public function getQltodoEntries(): array
    {
        return $this->qltodoEntries;
    }

    public function setDisplayType(string $displayType): string
    {
        $this->displayType = static::existsDisplayType($displayType)
            ? $displayType
            : static::DISPLAY_TYPE_DEFAULT;
    }

    public function isDisplayTypeList(): bool
    {
        return self::DISPLAY_TYPE_LIST === $this->displayType || !static::existsDisplayType($this->displayType);
    }

    public function isDisplayTypeDetail(): bool
    {
        return self::DISPLAY_TYPE_DETAIL === $this->displayType;
    }

    public function getDisplayType(): string
    {
        return static::existsDisplayType($this->displayType)
            ? $this->displayType
            : static::DISPLAY_TYPE_DEFAULT;
    }

    private static function existsDisplayType(string $displayType): bool
    {
        return in_array($displayType, static::DISPLAY_TYPES_ALL);
    }
}
