<?php
/**
 * WT Bootstrap image slider
 * @version        3.0.0
 * @package        Bootstrap image slider for Joomla
 * @copyright      Copyright (C) 2023 Sergey Tolkachyov
 * @license        GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @link           https://web-tolk.ru
 */
defined('_JEXEC') or die();

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;

FormHelper::loadFieldClass('list');

class JFormFieldVmcategories extends JFormFieldList
{

	protected $type = 'vmcategories';

	protected function getOptions()
	{

		$options = array();
		if (!file_exists(JPATH_ROOT . '/administrator/components/com_virtuemart/helpers/config.php'))
		{
			$options[]    = HTMLHelper::_('select.option', 0, '-- Virtuemart component is not installled --');
			return $options;
		}

		$options = array();
		if (!class_exists('VmConfig')) require(JPATH_ROOT . '/administrator/components/com_virtuemart/helpers/config.php');
		VmConfig::loadConfig();
		vmLanguage::loadJLang('com_virtuemart');

		$cats = VirtueMartModelCategory::getCatsTree(false, '', 0, 10, false, VmConfig::isSite());
		
		if (!empty($cats))
		{
			foreach ($cats as $key => $category)
			{

				$categoryTree = '';
				if ($category->level >= 1)
				{
					$categoryTree .= str_repeat(' - ', ($category->level));
				}
				$categoryTree .= $category->category_name;
				$options[]    = HTMLHelper::_('select.option', $category->virtuemart_category_id, $categoryTree);

			}
		}

		return $options;
	}


}