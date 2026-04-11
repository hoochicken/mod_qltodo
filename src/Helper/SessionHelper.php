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
    private const SIDEBAR_SHOW = 'qltodo.sidebar';
    private const FILTER = 'qltodo.filter';
    private const FILTER_ALL = 'all';
    private const FILTER_CURRENT = 'current';
    
    public function __construct(private SessionInterface $session)
    {
        $session->start();
        $session->set(self::FILTER, static::FILTER_ALL);
        $session->set(self::SIDEBAR_SHOW, false);
    }

    public function isSidebarVisible(): bool
    {
        return $this->session->get(static::SIDEBAR_SHOW, false);
    }

    public function setSidebarVisible(bool $visible): void
    {
        $this->session->set(static::SIDEBAR_SHOW, $visible);
    }

    public function getFilter(): string
    {
        return $this->session->get(static::FILTER);
    }

    public function setAll(): void
    {
        $this->session->set(static::FILTER, static::FILTER_ALL);
    }

    public function setCurrent(): void
    {
        $this->session->set(static::FILTER, static::FILTER_CURRENT);
    }

    public function isAll(): bool
    {
        return $this->session->get(static::FILTER) === self::FILTER_ALL;
    }

    public function isCurrent(): bool
    {
        return $this->session->get(static::FILTER) === self::FILTER_CURRENT;
    }
}
