<?php
/**
 * WT Bootstrap image slider
 * @version        3.0.0
 * @package        Bootstrap image slider for Joomla
 * @copyright      Copyright (C) 2023 Sergey Tolkachyov
 * @license        GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @link           https://web-tolk.ru
 */

namespace Joomla\Module\Wtbootstrapimageslider\Site\Dispatcher;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\Module\Wtbootstrapimageslider\Site\Helper\WtbootstrapimagesliderHelper;

/**
 * Dispatcher class for mod_wtyandexmapitems
 *
 * @since  1.0.0
 */
class Dispatcher extends AbstractModuleDispatcher
{
    /**
     * Returns the layout data.
     *
     * @return  array
     *
     * @since   1.0.0
     */
    protected function getLayoutData() : array
    {
        $data = parent::getLayoutData();
        $data['moduleId']                     = $data['module']->id;
        $fields                               = (new WtbootstrapimagesliderHelper)->getList($data['params'], $this->getApplication());
        $data['params']->set('fields',$fields);
        $data['use_individual_time_interval'] = $data['params']->get('use_individual_time_interval');
        $data['time_interval']                = (int) $data['params']->get('time_interval', 0) * 1000;
        $data['use_controls']                 = $data['params']->get('use_controls');
        $data['crossfade']                    = $data['params']->get('crossfade');
        $moduleclass_sfx                      = $data['params']->get('moduleclass_sfx');
        $data['moduleclass_sfx']              = (!empty($moduleclass_sfx) ? htmlspecialchars($moduleclass_sfx, ENT_COMPAT, 'UTF-8') : '');
        return $data;
    }
}