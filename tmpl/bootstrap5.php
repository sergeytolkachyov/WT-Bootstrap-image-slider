<?php
/**
 * WT Bootstrap image slider
 * @version        3.0.0
 * @package        Bootstrap image slider for Joomla
 * @copyright      Copyright (C) 2023 Sergey Tolkachyov
 * @license        GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @link           https://web-tolk.ru
 */


use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die('Restricted access');

//echo '<pre>';
//print_r($params);
//echo '</pre>';
if ($use_individual_time_interval == 0 && !empty($time_interval)) {
    $time_interval = 'interval: ' . $time_interval;
} else {
    $time_interval = "";
}

$script = '
		document.addEventListener("DOMContentLoaded", function() {
			const carousel = new bootstrap.Carousel("#wt_bootstrap_image_slider-' . $moduleId . '");
		});
	';

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->useScript('bootstrap.carousel');
$wa->addInlineScript($script);


?>

<div id="wt_bootstrap_image_slider-<?php echo $moduleId; ?>"
     class="carousel slide <?php if ($params->get("crossfade") == 1) {
         echo "carousel-fade";
     }
     echo $moduleclass_sfx; ?>" data-bs-ride="carousel">

    <?php
    if ($params->get("use_indicators") == 1):?>
        <div class="carousel-indicators">
            <?php for ($i = 0; $i < count((array)$params->get("fields")); $i++) {
                echo '<button type="button" data-bs-target="#wt_bootstrap_image_slider-' . $moduleId . '" data-bs-slide-to="' . $i . '" ' . (($i + 1 == 1) ? 'class="active"' : '') . ' aria-label="Slide ' . $i . '"></button>';
            } ?>
        </div>
    <?php endif; ?>
    <div class="carousel-inner">
        <?php
        $k = 0;
        foreach ($params->get("fields") as $field):?>
            <article class="carousel-item <?php if ($k + 1 == 1) {
                echo "active";
            } ?>"
                <?php
                if ($params->get("use_individual_time_interval") == 1) {
                    echo "data-bs-interval=\"" . ((int)$field->individual_time_interval * 1000) . "\"";
                } ?>
            >

                <?php
                /**
                 * Look for slide type from module settings.
                 * Default type is image
                 */

                if ($field->slide_type == 'image'):

                    // Use HTML5 picture tag for responsive images
                    if ($field->responsive_images && count((array)$field->responsive_images) > 0) :?>

                        <picture>
                        <?php

                        foreach ($field->responsive_images as $responsive_image):
                                $clean_image_path = HTMLHelper::cleanImageURL($responsive_image->image);
                                $clean_image_path = $clean_image_path->url;
                            ?>
                            <source srcset="<?php echo $clean_image_path; ?>"
                                    media="<?php echo $responsive_image->media_query; ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php
                        $clean_image_path = HTMLHelper::cleanImageURL($field->image);
                        /**
                         * Here we don't use $clean_image_path->attributes object:
                         * In Joomla 4, when filling in a media type field (selecting an image in the admin panel),
                         * file sizes are saved to the database. Then these file sizes are inserted as the url
                         * parameters of the image. This is done in order to make it easier to get the image sizes
                         * if the front of the site is written in JS frameworks (Vue, Angular, etc.).
                         * If the file size is changed not through the admin panel, but directly via FTP,
                         * the same file sizes will remain in the database, which may lead to incorrect
                         * display of the slide. On the other hand, this object contains the height and width
                         * attributes of the image, which affects the page rendering speed and, as a result,
                         * the Google Page speed indicators.
                         */

                        $img_attribs = [
                            'class' => 'd-block w-100'
                        ];
                        // echo HTMLHelper::image($clean_image_path->url, $field->title, $clean_image_path->attributes);
                        echo HTMLHelper::image($clean_image_path->url, $field->title, $img_attribs);

                    // Use HTML5 picture tag for responsive images - Close picture tag
                    if ($field->responsive_images && count((array)$field->responsive_images) > 0) :?>
                        </picture>
                    <?php endif; ?>
                    <?php if (!empty($field->title) || !empty($field->subtitle) || $field->cta_btn == 1): ?>
                    <div class="carousel-caption d-none d-md-block">
                        <?php if (!empty($field->title)): ?>
                            <h5 class="carousel-caption-title"><?php echo $field->title; ?></h5>
                        <?php endif; ?>
                        <?php if (!empty($field->subtitle)): ?>
                            <p class="carousel-caption-subtitle"><?php echo $field->subtitle; ?></p>
                        <?php endif; ?>

                        <?php if (!empty($field->cta_btn) == 1): ?>
                            <a class="carousel-caption-btn <?php echo $field->cta_btn_css; ?>"
                               href="<?php echo $field->cta_btn_url; ?>" <?php
                            if (!empty($field->cta_btn_goals)) {
                                echo "onclick='" . $field->cta_btn_goals . "'";
                            } ?>><?php echo $field->cta_btn_text; ?></a>
                        <?php endif; ?>
                    </div>
                <?php
                endif;
                /**
                 * Slide type is custom HTML.
                 */
                elseif ($field->slide_type == 'custom_html'):
                    echo HTMLHelper::_('content.prepare', $field->slide_custom_html, '', 'mod_wtbootstrapimageslider.content');
                endif;// END OF if ($field->slide_type == 'image'):
                $k++;
                ?>
            </article>
        <?php endforeach; ?>
        <?php if ($use_controls == 1): ?>
            <button class="carousel-control-prev" type="button"
                    data-bs-target="#wt_bootstrap_image_slider-<?php echo $moduleId; ?>" role="button"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button"
                    data-bs-target="#wt_bootstrap_image_slider-<?php echo $moduleId; ?>" role="button"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        <?php endif; ?>
    </div>
</div>