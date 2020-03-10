<?php
/*
 * @version		mod_wt_boostrap4_slider.php 1.0
 * @package		Bootstrap 4 image slider for Joomla
 * @copyright   Copyright (C) 2020 Sergey Tolkachyov
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
defined('_JEXEC') or die;

$doc = JFactory::getDocument();

$moduleId = $module->id;
$fields = $params->get('fields');
		$use_individual_time_interval = $params->get('use_individual_time_interval');
		$time_interval = $params->get('time_interval')*1000;
		$use_controls = $params->get('use_controls');
		$crossfade = $params->get('crossfade');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_wt_boostrap4_slider', $params->get('layout', 'default'));
