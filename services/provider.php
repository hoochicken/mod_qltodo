<?php
/**
 * @package     Hoochicken\Module\Qltodo
 *
 * @copyright   Copyright (C) 2026 Mareike Riegel. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class() implements ServiceProviderInterface
{
    private const MODULE_NAME = 'Qltodo';
    private const MODULE_NAMESPACE_BASIC = '\\Hoochicken\\Module\\' . self::MODULE_NAME;
    private const MODULE_NAMESPACE_HELPER = self::MODULE_NAMESPACE_BASIC . '\\Site\\Helper';

    public function register(Container $container)
    {
        $container->registerServiceProvider(new ModuleDispatcherFactory(self::MODULE_NAMESPACE_BASIC));
        $container->registerServiceProvider(new HelperFactory(self::MODULE_NAMESPACE_HELPER));
        $container->registerServiceProvider(new Module());
    }
};
