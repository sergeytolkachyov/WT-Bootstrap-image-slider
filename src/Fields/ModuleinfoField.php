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

use Joomla\CMS\Form\Field\SpacerField;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

class ModuleinfoField extends SpacerField
{

	protected $type = 'Moduleinfo';

	/**
	 * Method to get the field input markup for a spacer.
	 * The spacer does not have accept input.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   1.7.0
	 */
	protected function getInput()
	{
		return ' ';
	}

	/**
	 * Method to get the field title.
	 *
	 * @return  string  The field title.
	 *
	 * @since   1.7.0
	 */
	protected function getTitle()
	{
		return $this->getLabel();
	}

	/**
	 * @return  string  The field label markup.
	 *
	 * @since   1.7.0
	 */
	protected function getLabel()
	{
		$data   = $this->form->getData();
		$module = $data->get('module');
		$doc    = Factory::getApplication()->getDocument();
		$doc->addStyleDeclaration("
			.plugin-info-img-svg:hover * {
				cursor:pointer;
			}
		");

		$wt_module_info = simplexml_load_file(JPATH_SITE . "/modules/" . $module . "/" . $module . ".xml");

		?>
	
		<div class="d-flex shadow p-4">
		  <div class="flex-shrink-0">
			<a href="https://web-tolk.ru" target="_blank">
					<svg class="plugin-info-img-svg" width="200" height="50" xmlns="http://www.w3.org/2000/svg">
						<g>
							<title>Go to https://web-tolk.ru</title>
							<text font-weight="bold" xml:space="preserve" text-anchor="start"
								  font-family="Helvetica, Arial, sans-serif" font-size="32" id="svg_3" y="36.085949"
								  x="8.152073" stroke-opacity="null" stroke-width="0" stroke="#000"
								  fill="#0fa2e6">Web</text>
							<text font-weight="bold" xml:space="preserve" text-anchor="start"
								  font-family="Helvetica, Arial, sans-serif" font-size="32" id="svg_4" y="36.081862"
								  x="74.239105" stroke-opacity="null" stroke-width="0" stroke="#000"
								  fill="#384148">Tolk</text>
						</g>
					</svg>
				</a>
		  </div>
		  <div class="flex-grow-1 ms-3">
			<span class="badge bg-success text-white">v.<?php echo $wt_module_info->version; ?></span>
				<?php echo Text::_(strtoupper($module) . "_DESC"); ?>
		  </div>
		</div>
		
		<?php

	}

}