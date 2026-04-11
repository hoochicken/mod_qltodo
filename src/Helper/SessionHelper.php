<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

namespace Hoochicken\Module\Qltodo\Site\Helper;

use Joomla\Session\SessionInterface;

defined('_JEXEC') or die;

class SessionHelper
{
    private const SESSION_FILTER = 'qltodo.filter';
    private const SESSION_FILTER_ALL = 'all';
    private const SESSION_FILTER_CURRENT = 'current';



    public function __construct(private SessionInterface $session)
    {
        $session->start();
        $session->set(self::SESSION_FILTER, static::SESSION_FILTER_ALL);
    }

    public function getFilter(): string
    {
        return $this->session->get(static::SESSION_FILTER);
    }

    public function setAll(): void
    {
        $this->session->set(static::SESSION_FILTER, static::SESSION_FILTER_ALL);
    }

    public function setCurrent(): void
    {
        $this->session->set(static::SESSION_FILTER, static::SESSION_FILTER_CURRENT);
    }

    public function isAll(): bool
    {
        return $this->session->get(static::SESSION_FILTER) === self::SESSION_FILTER_ALL;
    }

    public function isCurrent(): bool
    {
        return $this->session->get(static::SESSION_FILTER) === self::SESSION_FILTER_CURRENT;
    }
}
