<?php
/**
 * Bootstrap image slider
 *
 * @version        2.1.0
 * @package        Bootstrap image slider for Joomla
 * @copyright      Copyright (C) 2022 Sergey Tolkachyov
 * @link           https://web-tolk.ru
 * @license        GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

$doc = Factory::getApplication()->getDocument();

$moduleId                     = $module->id;
$fields                       = $params->get('fields');
$use_individual_time_interval = $params->get('use_individual_time_interval');
$time_interval                = (int) $params->get('time_interval') * 1000;
$use_controls                 = $params->get('use_controls');
$crossfade                    = $params->get('crossfade');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require ModuleHelper::getLayoutPath('mod_wtbootstrapimageslider', $params->get('layout', 'bootstrap4'));
