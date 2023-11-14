<?php

/**
 * WT Bootstrap image slider
 * @version        3.0.0
 * @package        Bootstrap image slider for Joomla
 * @copyright      Copyright (C) 2023 Sergey Tolkachyov
 * @license        GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @link           https://web-tolk.ru
 */

namespace Joomla\Module\Wtbootstrapimageslider\Site\Helper;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Application\SiteApplication;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Registry\Registry;
use Joomla\Database\DatabaseAwareInterface;
use Joomla\Database\DatabaseAwareTrait;

\defined('_JEXEC') or die;

/**
 * The helper class of a module
 *
 * @since  1.0
 */
class WtbootstrapimagesliderHelper implements DatabaseAwareInterface
{

    use DatabaseAwareTrait;

    /**
     * Retrieve list of module entries
     *
     * @param Registry  &$params module parameters
     * @param SiteApplication $app
     * @return  object
     *
     * @since   4.2.0
     */
    public function getList(Registry $params, SiteApplication $app): object
    {

        $fields = new Registry();
        $i = 0;
        $url = '';
        foreach ($params->get('fields') as $field) {

            $field = new Registry($field);

            if ($field->get('cta_btn', 1) == 1) {
                /**
                 * Формируем ссылки
                 */

                if ($field->get('link_type') == 'com_jshopping' && !empty($field->get('jshoppingcategories'))) {
                        if (!class_exists('JSHelper') && file_exists(JPATH_SITE . '/components/com_jshopping/bootstrap.php')) {
                            require_once(JPATH_SITE . '/components/com_jshopping/bootstrap.php');
                        } elseif (!file_exists(JPATH_SITE . '/components/com_jshopping/bootstrap.php')) {
                            continue;
                        }

                        $jshop_link = 'index.php?option=com_jshopping&controller=category&task=view&category_id=' . $field->get('jshoppingcategories');
                        $jshop_itemid = \JSHelper::getDefaultItemid($jshop_link);
                        $url = Route::_($jshop_link . '&Itemid=' . $jshop_itemid);

                } elseif ($field->get('link_type') == 'com_virtuemart' && !$field->get('virtuemartcategories') == '0') {
                    // Убираем "верхний уровень категории с virtuemart_category_id=0
                    $url = Route::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $field->get('virtuemartcategories'));

                } elseif ($field->get('link_type') == 'com_phocacart' && !empty($field->get('phocacartcategory'))) {

                    $url = Route::_('index.php?option=com_phocacart&view=category&id=' . $field->get('phocacartcategory'));

                } elseif ($field->get('link_type') == 'com_content') {
                    $url = Route::_('index.php?option=com_content&view=category&id=' . $field->get('contentcategories'));

                } elseif ($field->get('link_type') == 'menuitem') {
                    $menu_item = $app->getMenu('site')->getItem($field->get('menuitem'));
                    $url = Route::_($menu_item->link . '&Itemid=' . $menu_item->id);

                } elseif ($field->get('link_type') == 'custom' && !empty($field->get('cta_btn_url'))) {

                    $url = $field->get('cta_btn_url');

                } elseif ($field->get('link_type') == 'com_content_article' && !empty($field->get('com_content_article_id'))) {
                    $model = $app->bootComponent('com_content')
                        ->getMVCFactory()
                        ->createModel('Article', 'Site', ['ignore_request' => true]);
                    // Set application parameters in model
                    $model->setState('params', $app->getParams());
                    $article = $model->getItem($field->get('com_content_article_id'));
                    $url = Route::link('site', RouteHelper::getArticleRoute($field->get('com_content_article_id'), $article->catid, $article->language));

                } elseif ($field->get('link_type') == 'file' && !empty($field->get('file_uri'))) {
                    $url = $field->get('file_uri');

                }
            }

            $field->set('cta_btn_url',$url);
            $fields->set('fields'.$i, $field->toObject());
            $i++;
        }//end foreach
        return $fields->toObject();
    }
}