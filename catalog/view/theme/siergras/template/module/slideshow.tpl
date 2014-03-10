<div class="flexslider">
  <ul class="slides">
    <?php foreach ($banners as $banner) { 
    
    $pos = strpos($banner['title'], "mini");
    $pos2 = strpos($banner['title'], "ads");
    if (($pos === false)&&($pos2 === false)) {
    ?>
    <li>
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
    <?php } ?>
    </li>
    <? } ?>
    
    <?php } ?>
  </ul>
</div>
<?
$metroshop_layout_rightbaners = 'show';

if($this->config->get('metroshop_status') == '1') { $metroshop_layout_rightbaners = $this->config->get('metroshop_layout_rightbaners'); }

if($metroshop_layout_rightbaners == 'show') {
?>	
<div class="mini-sliders">
  <?php
  
    $i = 0;
    
    foreach ($banners as $banner) { 
    
    $pos = strpos($banner['title'], "mini");
    
    if ($pos !== false) {
    $i++;
    ?>
  
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img class="fade-image" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"/></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
    <?php } ?>
  
    <? } ?>
    
    <?php }
    
    if($i>0)
    {
      echo '<style type="text/css">.flexslider {
	width:690px;float:left;
}

</style>';
    }
    
    ?>
</div>
<div class="clear"></div>

<? } ?>

<?
$metroshop_layout_bottombaners = 'show';

if($this->config->get('metroshop_status') == '1') { $metroshop_layout_bottombaners = $this->config->get('metroshop_layout_bottombaners'); }

if($metroshop_layout_bottombaners == 'show') {
?>
<div class="mini-ads">
  <?php
  
    $j = 0;
    
    foreach ($banners as $banner) { 
    
    $pos = strpos($banner['title'], "ads");
    if ($pos !== false) {
    $j++;
    ?>
  
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img class="fade-image" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"/></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
    <?php } ?>
  
    <? } ?>
    
    <?php }
    
    if($j==0)
    {
      echo '<style type="text/css">.mini-ads {
	display:none;
}</style>';
    }
    
    
    ?>
</div>
<div class="clear"></div>

<? } ?>
<?
$metroshop_effects_slideranim = 'fade';

if($this->config->get('metroshop_status') == '1') { $metroshop_effects_slideranim = $this->config->get('metroshop_effects_slideranim'); }

?>
<script type="text/javascript"><!--
$(document).ready(function() {
 	
  $('.flexslider').flexslider({
    animation: "<?=$metroshop_effects_slideranim;?>",
    controlNav: false,
    directionNav: true,
    start: function(slider) {
	  
	
	  
      }
  });

     
  
});
--></script>