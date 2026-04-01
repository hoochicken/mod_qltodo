<?php

namespace Hoochicken\Module\Qltodo\Site\Helper;

class SeverityItem
{ 
    const SEVERITY_LOW_VALUE = 1;
    const SEVERITY_LOW_LABEL = 'QLTODO_SEVERITY_LOW';

    const SEVERITY_MINOR_VALUE = 2;
    const SEVERITY_MINOR_LABEL = 'QLTODO_SEVERITY_MINOR';

    const SEVERITY_MAJOR_VALUE = 3;
    const SEVERITY_MAJOR_LABEL = 'QLTODO_SEVERITY_MAJOR';

    const SEVERITY_CRITICAL_VALUE = 4;
    const SEVERITY_CRITICAL_LABEL = 'QLTODO_SEVERITY_CRITICAL';

    const SEVERITY_URGENT_VALUE = 5;
    const SEVERITY_URGENT_LABEL = 'QLTODO_SEVERITY_URGENT';

    protected static array $levels = [
        self::SEVERITY_LOW_VALUE => self::SEVERITY_LOW_LABEL,
        self::SEVERITY_MINOR_VALUE => self::SEVERITY_MINOR_LABEL,
        self::SEVERITY_MAJOR_VALUE => self::SEVERITY_MAJOR_LABEL,
        self::SEVERITY_CRITICAL_VALUE => self::SEVERITY_CRITICAL_LABEL,
        self::SEVERITY_URGENT_VALUE => self::SEVERITY_URGENT_LABEL,
    ];

    public int $level;
    public string $label;
    
    public function __construct(int $level)
    {
        $this->level = $level;
        $this->label = static::getLabelByLevel($level);
    }

    public static function getLabelByLevel(int $level): string
    {
        return static::$levels[$level] ?? '';
    }
}
