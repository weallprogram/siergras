<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?><div class="navigate navigate-latest"><div class="prev"></div><div class="next"></div></div></div>
  <div class="clear"></div>
  <div class="box-content">
    <div class="box-product caruofredsel caruofredsel-latest">
      <?php foreach ($products as $product) { ?>
           <div class="box-product-item">
        <div class="view-first">
          <div class="view-content">  
            <?php if ($product['thumb']) { ?>
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
              
            <div class="bottom-block">
              <div class="name"><a href="<?php echo $product['href']; ?>"><?php mb_internal_encoding("UTF-8"); if(strlen($product['name']) > 23) { $product['name'] = mb_substr($product['name'],0,23).'...'; } echo $product['name']; ?></a></div>
              <div class="link-cart" onclick="addToCart('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></div>
              <?php if ($product['price']) { ?>
              <div class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
          </div>
          
	  <div class="slide-block"><div class="image-rating"><?php if ($product['rating']) { ?><img src="catalog/view/theme/metroshop/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /><?php } ?></div><div class="btn-wish" onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></div><div class="btn-compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></div></div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<div class="clear"></div>
<?
if($this->config->get('metroshop_status') == '1') { $metroshop_effects_carousel = $this->config->get('metroshop_effects_carousel');} else {$metroshop_effects_carousel = 'enable';}

if($metroshop_effects_carousel == 'enable')
{
?>
<script type="text/javascript"><!--
$(document).ready(function() {
      
	// Using default configuration
	$(".caruofredsel-latest").carouFredSel({
      
                  infinite: false,
                  auto 	: false,
		  width : "100%",
                  prev	: {	
                          button	: ".navigate-latest .prev",
                          key		: "left"
                  },
                  next	: { 
                          button	: ".navigate-latest .next",
                          key		: "right"
                  }
                  ,swipe           : {
                      onTouch     : false,
                      onMouse     : false
                  }
		  ,onCreate : function(data) { $(this).css("height","auto");  }
        
        })

});

--></script>
<? } ?>