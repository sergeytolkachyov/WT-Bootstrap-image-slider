<?php
/**
 * WT Bootstrap image slider
 * @version        3.0.0
 * @package        Bootstrap image slider for Joomla
 * @copyright      Copyright (C) 2023 Sergey Tolkachyov
 * @license        GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @link           https://web-tolk.ru
 */

namespace Joomla\Module\Wtbootstrapimageslider\Site\Fields;

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\Field\ListField;

class JshoppingcategoriesField extends ListField
{

	protected $type = 'Jshoppingcategories';

	protected function getOptions()
	{

		$options = array();

		if(!class_exists('JSHelper') && file_exists(JPATH_SITE . '/components/com_jshopping/bootstrap.php')){
			require_once(JPATH_SITE . '/components/com_jshopping/bootstrap.php');
		} elseif(!file_exists(JPATH_SITE . '/components/com_jshopping/bootstrap.php')) {
			return '-- JoomShopping component is not installled --';
		} 

		$allcats = \JSHelper::buildTreeCategory(0);

		foreach ($allcats as $category)
		{
			if($category->category_id == 0){
				unset($category);
			} else{
				$options[] = HTMLHelper::_('select.option', $category->category_id, $category->name);
			}
		}

		return $options;

	}
}