<?php

class QltodoSeverity
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

    private static array $options = [
        self::SEVERITY_LOW_VALUE => self::SEVERITY_LOW_LABEL,
        self::SEVERITY_MINOR_VALUE => self::SEVERITY_MINOR_LABEL,
        self::SEVERITY_MAJOR_VALUE => self::SEVERITY_MAJOR_LABEL,
        self::SEVERITY_CRITICAL_VALUE => self::SEVERITY_CRITICAL_LABEL,
        self::SEVERITY_URGENT_VALUE => self::SEVERITY_URGENT_LABEL,
    ];

    public static function getOptions(): array
    {
        return self::$options;
    }

    public static function getLabelBySeverity(int $severity): string
    {
        return self::$options[$severity];
    }
}