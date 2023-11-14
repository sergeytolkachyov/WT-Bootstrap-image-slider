<?php
/**
 * WT Bootstrap image slider
 * @version        3.0.0
 * @package        Bootstrap image slider for Joomla
 * @copyright      Copyright (C) 2023 Sergey Tolkachyov
 * @license        GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @link           https://web-tolk.ru
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * The module service provider.
 *
 * @since  3.0.0
 */
return new class () implements ServiceProviderInterface
{
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   4.0.0
     */
    public function register(Container $container) : void
    {
        $container->registerServiceProvider(new ModuleDispatcherFactory('\\Joomla\\Module\\Wtbootstrapimageslider'));
        $container->registerServiceProvider(new Module);
    }
};