<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  
  <h1 style="padding-left: 20px;"><?php echo $heading_title; ?></h1>
  
  <div class="container">
    <div class="span-24 product-info">
      <div class="span-16">
        <?php if ($thumb || $images) { ?>
          <?php if ($thumb) { ?>
          <?php $imgPopup = $popup;
          $imgPopup = str_replace("/cache", "", $imgPopup);
          $imgPopup = str_replace("-500x500", "", $imgPopup); ?>
            <div class="image">
              <a href="<?php echo $imgPopup; ?>" title="<?php echo $heading_title; ?>" id="zoom01" 
                <? if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) { 
                  echo 'class="cloud-zoom" rel="position:\'right\', zoomWidth:320, zoomHeight:320, adjustX:10, adjustY:0, tint:\'#FFFFFF\', showTitle:false, softFocus:1, smoothMove:5, tintOpacity:0.8"';
                } else { 
                  echo 'rel="prettyPhoto"';
                } ?> >
                <img width="`320" height="320" src="<?php echo $imgPopup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" />
              </a>
            </div>
          <?php } ?>
        <?php } ?>
        <br />
        <?php if ($images) { ?>
          <div class="image-additional gallery">
            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" <? if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) { echo 'rel="useZoom: \'zoom01\', smallImage: \''.$thumb.'\'" class="cloud-zoom-gallery"';} else { echo 'rel="prettyPhoto[pp_gal]"';} ?>><img width="102" height="102" class="fade-image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php foreach ($images as $image) { ?>
            <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" <? if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) { echo 'rel="useZoom: \'zoom01\', smallImage: \''.$image['zoom_thumb'].'\'" class="cloud-zoom-gallery"';} else { echo 'rel="prettyPhoto[pp_gal]"';} ?>><img class="fade-image" src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" width="102" height="102" /></a>
            <?php } ?>
            <div class="clear"></div>
          </div>
        <?php } ?>
      </div>
      <div class="span-7">
        <div class="right">
          <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
              <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
          </div>
          <div class="product_title"><h2><?php echo $heading_title; ?></h2></div>

          <?php if ($price) { ?>
            <div class="price"><b><?php echo $text_price; ?></b>
              <?php if (!$special) { ?>
                <?php echo $price; ?>
              <?php } else { ?>
                <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
              <?php } ?>
        
              <?php if ($tax) { ?>
                <br><span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
              <?php } ?><br />
              <?php if ($points) { ?>
                <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
              <?php } ?>
              <?php if ($discounts) { ?>
                <div class="discount">
                  <?php foreach ($discounts as $discount) { ?>
                    <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
                  <?php } ?>
                </div>
              <?php } ?>
            </div><br />
          <?php } ?>
          <div class="description">
            <!-- <div class="right-rating" onclick="$('a[href=\'#tab-review\']').trigger('click');"><img class="fade-image" src="catalog/view/theme/metroshop/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" /></div> -->
            <?php if ($manufacturer) { ?>
              <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
            <?php } ?>
            <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
            <?php if ($reward) { ?>
              <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
            <?php } ?>
            <span><?php echo $text_stock; ?></span> <?php echo $stock; ?></div><br />
      
            <?php if ($options) { ?>
              <div class="options">
                <h2><?php echo $text_option; ?></h2>       
            
                <?php foreach ($options as $option) { ?>
                  <?php if ($option['type'] == 'select') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                      <b><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <select name="option[<?php echo $option['product_option_id']; ?>]">
                        <option value=""><?php echo $text_select; ?></option>
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                          <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                          <?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                          <?php } ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                    <br />
                  <?php } ?>
                  <!-- Modified for option quantity ============================================================== -->
                  <!-- <?php echo $option['type'] . '<br />'; ?> -->
                  <?php if ($option['type'] == 'checkboxQuantity') { ?>
                      <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                        <table border="0">
                        <tr>
                        <th colspan=2>
                        <?php if ($option['required']) { ?>
                        <span class="required">*</span>
                        <?php } ?>
                        <?php echo $option['name']; ?>:
                        </th><th><?php echo $text_qty; ?></th>
                        </tr>
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                        <tr><td>
                        <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                        </td><td>
                        <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                          <?php if ($option_value['price']) { ?>
                          (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                          <?php } ?>
                        </label>
                    </td><td>
                    <input type="number" name="option-quantity[<?php echo $option_value['product_option_value_id']; ?>][]" style="width:50px" id="option-value-quantity-<?php echo $option_value['product_option_value_id']; ?>" value="0" min="0" class="leoptionQuantity" />
                    </td></tr>          
                        <?php } ?>
                        </table>
                      </div>
                      <br />
                      <?php } ?>    
                  <!-- ============================================================================================== -->
                  <?php if ($option['type'] == 'radio') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                      <b><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <?php foreach ($option['option_value'] as $option_value) { ?>
                        <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                        <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                          <?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                          <?php } ?>
                        </label>
                        <br />
                      <?php } ?>
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'checkbox') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">          
                      <b><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <?php foreach ($option['option_value'] as $option_value) { ?>
                        <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                        <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                          <?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                          <?php } ?>
                        </label>
                        <br />
                      <?php } ?>
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'image') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">          
                      <b><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <table class="option-image">
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                          <tr>
                            <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                            <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
                            <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                            <?php if ($option_value['price']) { ?>
                              (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                            <?php } ?>
                            </label></td>
                          </tr>
                        <?php } ?>
                      </table>
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'text') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">          
                      <b><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'textarea') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">         
                      <b> <?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'file') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">          
                      <b><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
                      <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'date') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">          
                      <b> <?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'datetime') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                      <b><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
                    </div>
                    <br />
                  <?php } ?>
                  <?php if ($option['type'] == 'time') { ?>
                    <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                      <b> <?php if ($option['required']) { ?>
                        <span class="required">*</span>
                      <?php } ?><?php echo $option['name']; ?>:</b>
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
                    </div>
                    <br />
                  <?php } ?>
                <?php } ?>
              </div>
            <?php } ?>
      
            <div class="product-info-buttons">
              <div class="input-qty" style="display:none;">
                <span><?php echo $text_qty; ?></span>
                <input type="number" id="leQuantity" min="1" max="99" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
              </div><br />
              <a class="button" id="button-cart"><?php echo $button_cart; ?></a> 
            </div>
            <!--
            <div class="product-info-buttons2 box-product">
              <div class="btn-wish" onclick="addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></div>
              <div class="btn-compare" onclick="addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></div>
            </div> -->
            <?php if ($minimum > 1) { ?>
              <div class="minimum"><?php echo $text_minimum; ?></div>
            <?php } ?>
      
      
            <?php if ($review_status) { ?>
              <div class="review">
                <span class='st_facebook_large' displayText='Facebook'></span>
                <span class='st_twitter_large' displayText='Tweet'></span>
                <span class='st_pinterest_large' displayText='Pinterest'></span>
                <span class='st_plusone_large' displayText='Google +1'></span>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>


  <div class="product-info">

  <div id="tabs" class="htabs">
    <?php if ($attribute_groups) { ?>
      <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
    <?php } ?>
    <a href="#tab-description"><?php echo $tab_description; ?></a>
    <?php if ($review_status) { ?>
      <a href="#tab-review"><?php echo $tab_review; ?></a>
    <?php } ?>
    
<?
if($this->config->get('metroshop_status') == '1') { $metroshop_layout_related = $this->config->get('metroshop_layout_related');} else {$metroshop_layout_related = 'tab';}

if($metroshop_layout_related == 'tab')
{
?>
    
    <?php if ($products) { ?>
      <a href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
    <?php } ?>
<? } ?>

  </div>
  <?php if ($attribute_groups) { ?>
  <div id="tab-attribute" class="tab-content">
    <table class="attribute">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td colspan="2"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td><?php echo $attribute['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <?php } ?>
  <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-content">
    <div id="review"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="" />
    <br />
    <br />
    <b><?php echo $entry_review; ?></b>
    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
    <br />
    <!<b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
    <input type="radio" name="rating" value="1" />
    &nbsp;
    <input type="radio" name="rating" value="2" />
    &nbsp;
    <input type="radio" name="rating" value="3" />
    &nbsp;
    <input type="radio" name="rating" value="4" />
    &nbsp;
    <input type="radio" name="rating" value="5" />
    &nbsp;<span><?php echo $entry_good; ?></span><br />
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="" />
    <br />
    <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
    <br />
    <div class="buttons">
      <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
    </div>
  </div>
  <?php } ?>

<?
if($this->config->get('metroshop_status') == '1') { $metroshop_layout_related = $this->config->get('metroshop_layout_related');} else {$metroshop_layout_related = 'tab';}

if($metroshop_layout_related == 'tab')
{
?>
  
  <?php if ($products) { ?>
  <div id="tab-related" class="tab-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>

<div class="box-product-item">
        <div class="view-first">
          <div class="view-content">  
            <?php if ($product['thumb']) { ?>
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
              
            <div class="bottom-block">
              <div class="name"><a href="<?php echo $product['href']; ?>"><?php
              mb_internal_encoding("UTF-8");
              if(strlen($product['name']) > 23) { $product['name'] = mb_substr($product['name'],0,23).'...'; } echo $product['name']; ?></a></div>
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
  <?php } ?>
  
  
<? }?>


<?
if($this->config->get('metroshop_status') == '1') { $metroshop_layout_related = $this->config->get('metroshop_layout_related');} else {$metroshop_layout_related = 'tab';}

if(($metroshop_layout_related == 'carousel')&&($products))
{
?>
  <div class="box">
  <div class="box-heading"><?php echo $tab_related; ?><div class="navigate navigate-related"><div class="prev"></div><div class="next"></div></div></div>
  <div class="clear"></div>
  <div class="box-product">
    <div class="caruofredsel caruofredsel-related">
      <?php foreach ($products as $product) { ?>
      
      <div class="box-product-item">
        <div class="view-first">
          <div class="view-content">  
            <?php if ($product['thumb']) { ?>
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
              
            <div class="bottom-block">
              <div class="name"><a href="<?php echo $product['href']; ?>"><?php if(strlen($product['name']) > 23) { $product['name'] = substr($product['name'],0,23).'...'; } echo $product['name']; ?></a></div>
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

<script type="text/javascript"><!--
$(document).ready(function() {
      
        
	// Using default configuration
	$(".caruofredsel-related").carouFredSel({
      
                  infinite: false,
                  auto 	: false,
		  width : "100%",
                  prev	: {	
                          button	: ".navigate-related .prev",
                          key		: "left"
                  },
                  next	: { 
                          button	: ".navigate-related .next",
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
  
  <?php if ($tags) { ?>
  <div class="tags content"><img src="catalog/view/theme/metroshop/image/tags.png" align="absmiddle"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>

<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
  var totalCount = 0;
  $(".leoptionQuantity").each(function(){
    totalCount += parseInt($(this).val());
  });
  $("#leQuantity").val(totalCount);
  
  var p = $("input[name='product_id']").val();
  var q = $("input[name='quantity']").val();
  var URL = "http://testing.flevosiergras.nl/index.php?route=product/quantity&p=" + p + "&q=" + q;
  console.log(URL);
  $.get( URL, function( data ) {
    if(data.trim() != "ok"){
      alert("Er zijn nog maar "  + data + " beschikbaar van dit product!\r\nBekijk de omschrijving om te achterhalen wanneer er weer ( meer ) op voorraad zijn!");
      return false;
    }else{
      /* Modified for option quantity ===================================================================== */
      var validInput = true;
      $('input[type=number]').each(function () {
        var currentId = $(this).attr('id');
        if(typeof currentId != "undefined"){
          checkboxId = currentId.replace("quantity-", "");
          if($('#'+checkboxId).prop('checked') == true){
            if(isNaN($(this).val())) {
              $(this).focus(); 
              $(this).css({'background-color' : '#FF0000'});
              validInput = false;
            } else if($(this).val() <= 0) {
              $(this).focus();
              $(this).css({'background-color' : '#FF0000'});
              validInput = false;
            }
          }
        }
      });
      if(validInput){
        $('input[type=number]').each(function () {
          $(this).css({'background-color' : '#FFFFFF'});
        }); 
    /* ================================================================================================== */
      $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        /* Modified for option quantity ===================================================================== */
          data: $('.product-info input[type=\'text\'], .product-info input[type=\'number\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info input[type=\'checkboxQuantity\'], .product-info select, .product-info textarea'),
    /* ================================================================================================== */
        // data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
        dataType: 'json',
        success: function(json) {
          $('.success, .warning, .attention, information, .error').remove();
          
          if (json['error']) {
            console.log("The json has an error");
            if (json['error']['option']) {
              for (i in json['error']['option']) {
                $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
              }
            }
            console.log(json);
          } 
          
          if (json['success']) {
            $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/metroshop/image/close.png" alt="" class="close" /></div>');
              
            $('.success').fadeIn('slow');
              
            $('#cart-total').html(json['total']);
            
            $('html, body').animate({ scrollTop: 0 }, 'slow'); 
          } 
        }
      });
        /* Modified for option quantity ===================================================================== */    
      }
    /* ================================================================================================== */
  }
});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/metroshop/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
	$('.date, .datetime, .time').bgIframe();
}

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});


$(document).ready(function(){
  
<?
  if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) {
?>      
       $('#zoom01, .cloud-zoom-gallery').CloudZoom();
<?
} 
?>
 

    });  
//--></script>


<?php echo $footer; ?>