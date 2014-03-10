<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($products) { ?>
   <div class="product-filter clearfix">
    <div class="display"><b><?php echo $text_display; ?></b> <a title="<?php echo $text_list; ?>" class="list-switch active"></a><a class="grid-switch" title="<?php echo $text_grid; ?>" onclick="display('grid');"></a><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
    
    <div class="limit"><b><?php echo $text_limit; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="sort"><b><?php echo $text_sort; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="product-grid box-product" style="display:none;">
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
            
    <?php }//end products loop ?>
  </div>
  
  
 <div class="product-list box-product">
    <?php foreach ($products as $product) { ?>
    
  <div class="list-product-item">
        
	  <div class="left-block">
	    <?php if ($product['thumb']) { ?>
	    <div class="image"><a href="<?php echo $product['href']; ?>"><img class="fade-image" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
	    <?php } ?>
	  </div>
	  
	  <div class="center-block">
	    <div class="list-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
	    
	    
	    <div class="description"><?php echo $product['description']; ?></div>
	    
	    <div class="btn-product">
		    <div class="btn-wish" onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></div>
	    	    <div class="btn-compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></div>
	    </div>
	  </div>
	  
	  <div class="right-block">
	    <?php if ($product['price']) { ?>
	    
	    <div class="list-price">
	      <?php if (!$product['special']) { ?>
	      <?php echo $product['price']; ?>
	      <?php } else { ?>
	      <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
	      <?php } ?>
	    </div>
	    <?php } ?>
	    <div class="btn-cart"><a class="button" onclick="addToCart('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></a></div>
	    <div class="list-image-rating"><?php if ($product['rating']) { ?><img src="catalog/view/theme/metroshop/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /><?php } ?></div>
	    
	  </div>
	
      <div class="clear"></div>
      </div>
            
    <?php }//end products loop ?>
  </div>
 
      
  
  
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } ?>
  <?php if (!$products) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').css('display', 'none');
                $('.product-list').css('display', 'inline');
                  
		$('.display').html('<b><?php echo $text_display; ?></b> <a title="<?php echo $text_list; ?>" class="list-switch active"></a><a class="grid-switch" title="<?php echo $text_grid; ?>" onclick="display(\'grid\');"></a><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a>');
		
		$.cookie('display', 'list'); 
	} else {
		$('.product-list').css('display', 'none');
                $('.product-grid').css('display', 'inline');
                
		$('.display').html('<b><?php echo $text_display; ?></b> <a class="list-switch" title="<?php echo $text_list; ?>" onclick="display(\'list\');"></a><a class="grid-switch active" title="<?php echo $text_grid; ?>" ></a><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a>');
		
		$.cookie('display', 'grid');
	}
}

view = $.cookie('display');

<?

  if(($this->config->get('metroshop_status') == '1')&&(($this->config->get('metroshop_layout_pdisplay')))<>'')
  {
    $metroshop_layout_pdisplay = $this->config->get('metroshop_layout_pdisplay');
  }
  else
  {
    $metroshop_layout_pdisplay = 'list';
  }
?>
if (view) {
	display(view);
} else {
	display('<?=$metroshop_layout_pdisplay?>');
}
//--></script> 
<?php echo $footer; ?>