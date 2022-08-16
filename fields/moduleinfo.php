<?php
/**
 * @package       WebTolk plugin info field
 * @version       1.0.0
 * @Author        Sergey Tolkachyov, https://web-tolk.ru
 * @copyright     Copyright (C) 2020 Sergey Tolkachyov
 * @license       GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @since         1.0.0
 */

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\Version;

FormHelper::loadFieldClass('spacer');

class JFormFieldModuleinfo extends JFormFieldSpacer
{

	protected $type = 'moduleinfo';

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
		$inline_css = ".plugin-info-img{
			    margin-right:auto;
			    max-width: 100%;
			}
			.plugin-info-img-svg:hover * {
				cursor:pointer;
			}";
		if ((new Version())->isCompatible('4.0'))
			{
				// Joomla 4
				/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
				$wa = $doc->getWebAssetManager();
				$wa->addInlineStyle($inline_css);
			}
			else
			{
				// Joomla 3
				$doc->addStyleDeclaration($inline_css);
			}
		

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

?>