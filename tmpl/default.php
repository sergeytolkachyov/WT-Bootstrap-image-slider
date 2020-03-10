<?php
/*
 * @version		mod_wt_boostrap4_slider.php 1.0
 * @package		Bootstrap 4 image slider for Joomla
 * @copyright   Copyright (C) 2020 Sergey Tolkachyov
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
defined('_JEXEC') or die('Restricted access');


	if($use_individual_time_interval == 0 and $time_interval != ""){
		$time_interval = 'interval: '.$time_interval;
	} else {
		$time_interval = "";
	}
	$script ='
	jQuery(document).ready(function() {
		jQuery("#wt_bs4_image_slider-'.$moduleId.'").carousel({'.$time_interval.'});
	});
	';
	$doc->addScriptDeclaration($script);
?>

<div id="wt_bs4_image_slider-<?php echo $moduleId; ?>" class="carousel slide <?php if($params->get("crossfade") == 1){echo "carousel-fade";} echo $moduleclass_sfx; ?>" data-ride="carousel">
  
  <?php 
  if ($params->get("use_indicators") == 1):?>
	  <ol class="carousel-indicators">
	  <?php for($i=0;$i<count((array)$params->get("fields"));$i++){
			echo "<li data-target=\"#wt_bs4_image_slider-".$moduleId."\" data-slide-to=\"".$i."\" ".(($i+1 == 1)? "class='active'":"")."></li>";
	  }?>
	  </ol>
  <?php endif;?>
  
  <div class="carousel-inner">
  
   <?php 
   $k=0;
   foreach($params->get("fields") as $field):
      ?>
   <div class="carousel-item <?php if($k+1 == 1) {echo "active";} ?>" <?php 
   if($params->get("use_individual_time_interval") == 1){
	   echo "data-interval=\"".($field->individual_time_interval*1000)."\"";}?>>
      <img src="<?php echo $field->image;?>" class="d-block w-100" alt="<?php echo $field->title;?>">
     <?php if (!empty($field->title) || !empty($field->subtitle) || $field->cta_btn == 1):?> 
		  <div class="carousel-caption d-none d-md-block">
			<?php if (!empty($field->title)):?>
				<h5 class="carousel-caption-title"><?php echo $field->title;?></h5>
			<?php endif;?>
			<?php if (!empty($field->subtitle)):?>
				<p class="carousel-caption-subtitle"><?php echo $field->subtitle;?></p>
			<?php endif;?>
			
			<?php if (!empty($field->cta_btn) == 1):?>
				<a class="carousel-caption-btn <?php echo $field->cta_btn_css;?>" href="<?php echo $field->cta_btn_url;?>" <?php 
				if(!empty($field->cta_btn_goals)) {echo "onclick='".$field->cta_btn_goals."'";}?>><?php echo $field->cta_btn_text;?></a>
			<?php endif;?>
			
			
		  </div>
	  <?php $k++; endif;?>

	  
  </div>
  <?php endforeach;?>
  <?php if ($use_controls == 1):?>
  <a class="carousel-control-prev" href="#wt_bs4_image_slider-<?php echo $moduleId; ?>" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#wt_bs4_image_slider-<?php echo $moduleId; ?>" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  <?php endif;?>
</div>
