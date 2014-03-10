<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
      	<a href="#tab-general"><?php echo $tab_general; ?></a>
        <?php if ($gift_promotion_id) { ?>
        <a href="#tab-history"><?php echo $tab_gift_promotion_history; ?></a>
        <?php } ?>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $entry_name; ?></td>
              <td><input name="name" value="<?php echo $name; ?>" size="50"/>
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_quantity_total; ?></td>
              <td><input type="text" name="quantity_total" value="<?php echo $quantity_total; ?>" />
              <?php if ($error_quantity_total) { ?>
                <span class="error"><?php echo $error_quantity_tota; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_total; ?></td>
              <td><input type="text" name="total" value="<?php echo $total; ?>" />
              <?php if ($error_total) { ?>
                <span class="error"><?php echo $error_total; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_product; ?></td>
              <td>
              <table><tr><td>
              <?php echo $entry_category; ?><br/>
              <div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
					<?php 
                    if(isset($match_category_ids)){
                        if(in_array($category['category_id'],$match_category_ids)){
                        	$checked = 'checked="checked"';
                        }else{
                        	$checked = '';
                        }
                       }
                    ?>
                    <input type="checkbox" name="category[]" value="<?php echo $category['category_id']; ?>" <?php if(isset($checked)){ echo $checked; } ?> />                    <?php echo $category['name']; ?> </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true); CategorySelectAll();"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false); CategorySelectAll();"><?php echo $text_unselect_all; ?></a></td>
                </td>
                <td>&nbsp;</td>
                <td><?php echo $entry_manufacturer; ?><br/>
                  <div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($manufacturers as $manufacturer) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
					<?php 
                    if(isset($match_manufacturer_ids)){
                        if(in_array($manufacturer['manufacturer_id'],$match_manufacturer_ids)){
                        	$checked = 'checked="checked"';
                        }else{
                        	$checked = '';
                        }
                       }
                    ?>
                    <input type="checkbox" name="manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" <?php if(isset($checked)){ echo $checked; } ?> />                    <?php echo $manufacturer['name']; ?> </div>
                  <?php } ?>
                </div><a onclick="$(this).parent().find(':checkbox').attr('checked', true); CategoryManufacturerSelectAll();"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false); CategoryManufacturerSelectAll();"><?php echo $text_unselect_all; ?></a>
                </td>
            </tr>
            <td>&nbsp;</td>
            <tr>
              <td><?php echo $entry_product_product; ?><br/>
              <input type="text" name="product_suggest" value="" />
              </td>
              <td>&nbsp;</td>
              <td><div class="scrollbox" id="gift_promotion-product">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($gift_promotion_product as $gift_promotion_product) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="gift_promotion-product<?php echo $gift_promotion_product['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $gift_promotion_product['name']; ?><img src="view/image/delete.png" />
                    <input type="hidden" name="product[]" value="<?php echo $gift_promotion_product['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div>
               </td>
            </tr>
            </table>
           </td>
           </tr> 
            
           <tr>
              <td><?php echo $entry_quantity; ?></td>
              <td><input type="text" name="quantity" value="<?php echo $quantity; ?>" />
              <?php if ($error_quantity) { ?>
                <span class="error"><?php echo $error_quantity; ?></span>
                <?php } ?>
              </td>
            </tr>  
                        
           <tr>
              <td><?php echo $entry_product_gift; ?></td>
              <td><table>
            <tr>
              <td><?php echo $entry_product_product; ?><br/>
              <input type="text" name="product_gift_suggest" value="" />
              </td>
              <td>&nbsp;</td>
              <td><div class="scrollbox" id="gift_promotion-product_gift">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($gift_promotion_product_gift as $gift_promotion_product_gift) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="gift_promotion-product_gift<?php echo $gift_promotion_product_gift['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $gift_promotion_product_gift['name']; ?><img src="view/image/delete.png" />
                    <input type="hidden" name="product_gift[]" value="<?php echo $gift_promotion_product_gift['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            </table>
           </td> 
            </tr>                                     
            
            <tr>
              <td><?php echo $entry_quantity_gift; ?></td>
              <td><input type="text" name="quantity_gift" value="<?php echo $quantity_gift; ?>" />
              <?php if ($error_quantity_gift) { ?>
                <span class="error"><?php echo $error_quantity_gift; ?></span>
                <?php } ?>
              </td>
            </tr>
                        
            <tr>
              <td><?php echo $entry_logged; ?></td>
              <td><?php if ($logged) { ?>
                <input type="radio" name="logged" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="logged" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="logged" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="logged" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>
            
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $gift_promotion_store)) { ?>
                    <input type="checkbox" name="store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($stores as $store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($store['store_id'], $gift_promotion_store)) { ?>
                    <input type="checkbox" name="store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                    <?php echo $store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="store[]" value="<?php echo $store['store_id']; ?>" />
                    <?php echo $store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                <?php if ($error_store) { ?>
                <span class="error"><?php echo $error_store; ?></span>
                <?php } ?>
                </td>
            </tr>
           
            <tr>
              <td><?php echo $entry_customer_group; ?></td>
              <td><div class="scrollbox">
                 <?php if ($gift_promotion_customer_group) { ?> 
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($customer_group['customer_group_id'], $gift_promotion_customer_group)) { ?>
                    <input type="checkbox" name="customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                    <?php echo $customer_group['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                    <?php echo $customer_group['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                  <?php } else { ?>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="customer_group[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                    <?php echo $customer_group['name']; ?>
                  </div>
                  <?php } ?>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                <br/>
                <?php if ($error_customer_group) { ?>
                <span class="error"><?php echo $error_customer_group; ?></span>
                <?php } ?>
                </td>
            </tr> 
            
            <tr>
              <td><?php echo $entry_day; ?></td>
              <td><div class="scrollbox">
                   <?php if ($gift_promotion_day) { ?> 
                  <?php foreach ($days as $day) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($day, $gift_promotion_day)) { ?>
                    <input type="checkbox" name="day[]" value="<?php echo $day; ?>" checked="checked"  />
                    <?php echo $day; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="day[]" value="<?php echo $day; ?>" />
                    <?php echo $day; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                  <?php } else { ?>
                  <?php foreach ($days as $day) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <input type="checkbox" name="day[]" value="<?php echo $day; ?>" checked="checked"  />
                    <?php echo $day; ?>
                  </div>
                  <?php } ?>
                  <?php } ?>
                </div><a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
                <br/>
            <?php if ($error_day) { ?>
                <span class="error"><?php echo $error_day; ?></span>
                <?php } ?>
                </td>
            </tr>                                  
            
            <tr>
              <td><?php echo $entry_date_start; ?></td>
              <td><input type="text" name="date_start" value="<?php echo $date_start; ?>" size="12" id="date-start" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_end; ?></td>
              <td><input type="text" name="date_end" value="<?php echo $date_end; ?>" size="12" id="date-end" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_uses_total; ?></td>
              <td><input type="text" name="uses_total" value="<?php echo $uses_total; ?>" />
              <?php if ($error_uses_total) { ?>
                <span class="error"><?php echo $error_uses_total; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_uses_customer; ?></td>
              <td><input type="text" name="uses_customer" value="<?php echo $uses_customer; ?>" />
              <?php if ($error_uses_customer) { ?>
                <span class="error"><?php echo $error_uses_customer; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            
          </table>
        </div>
        
       <?php if ($gift_promotion_id) { ?>
        <div id="tab-history">
          <div id="history"></div>
        </div>
        <?php } ?>
        
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function CategorySelectAll(){ 
	var category_id;
	var filter_category_id = document.getElementsByName('category[]');
	
	for(j=0;j<(filter_category_id.length);j++){
	category_id = document.getElementsByName('category[]').item(j).value;
																					//alert(category_id);
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_category_id=' +  category_id + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_category_id).attr('checked') == 'checked') {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product').append('<div id="gift_promotion-product' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="gift_promotion_product[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product div:odd').attr('class', 'odd');
			$('#gift_promotion-product div:even').attr('class', 'even');			
		}
	});
	}
}

$('input[name=\'category[]\']').bind('change', function() {
	var filter_category_id = this;
	
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_category_id=' +  filter_category_id.value + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_category_id).attr('checked') == 'checked') {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product').append('<div id="gift_promotion-product' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="product[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product div:odd').attr('class', 'odd');
			$('#gift_promotion-product div:even').attr('class', 'even');			
		}
	});
});

function CategoryManufacturerSelectAll(){ 
	var category_id;
	var filter_category_id = document.getElementsByName('manufacturer[]');
	
	for(j=0;j<(filter_category_id.length);j++){
	category_id = document.getElementsByName('manufacturer[]').item(j).value;
																					//alert(category_id);
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_manufacturer_id=' +  category_id + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_category_id).attr('checked') == 'checked') {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product').append('<div id="gift_promotion-product' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="gift_promotion_product[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product div:odd').attr('class', 'odd');
			$('#gift_promotion-product div:even').attr('class', 'even');			
		}
	});
	}
}

$('input[name=\'manufacturer[]\']').live('change', function() {
	var filter_manufacturer_id = this;
	
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_manufacturer_id=' +  filter_manufacturer_id.value + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_manufacturer_id).attr('checked') == 'checked') {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product').append('<div id="gift_promotion-product' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="product[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product div:odd').attr('class', 'odd');
			$('#gift_promotion-product div:even').attr('class', 'even');			
		}
	});
});

$('input[name=\'product_suggest\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#gift_promotion-product' + ui.item.value).remove();
		
		$('#gift_promotion-product').append('<div id="gift_promotion-product' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="product[]" value="' + ui.item.value + '" /></div>');

		$('#gift_promotion-product div:odd').attr('class', 'odd');
		$('#gift_promotion-product div:even').attr('class', 'even');
		
		$('input[name=\'product_suggest\']').val('');
		
		return false;
	}
});

$('#gift_promotion-product div img').live('click', function() {
	$(this).parent().remove();
	
	$('#gift_promotion-product div:odd').attr('class', 'odd');
	$('#gift_promotion-product div:even').attr('class', 'even');	
});
//--></script> 

<script type="text/javascript"><!--
function CategoryGiftSelectAll(){ 
	var category_id;
	var filter_category_id = document.getElementsByName('category_gift[]');
	
	for(j=0;j<(filter_category_id.length);j++){
	category_id = document.getElementsByName('category_gift[]').item(j).value;
																					//alert(category_id);
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_category_id=' +  category_id + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_category_id).attr('checked') == 'checked') {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product_gift').append('<div id="gift_promotion-product_gift' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="product_gift[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product_gift div:odd').attr('class', 'odd');
			$('#gift_promotion-product_gift div:even').attr('class', 'even');			
		}
	});
	}
}

$('input[name=\'category_gift[]\']').bind('change', function() {
	var filter_category_id = this;
	
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_category_id=' +  filter_category_id.value + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_category_id).attr('checked') == 'checked') {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product_gift').append('<div id="gift_promotion-product_gift' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="product_gift[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product_gift div:odd').attr('class', 'odd');
			$('#gift_promotion-product_gift div:even').attr('class', 'even');			
		}
	});
});

function CategoryGiftManufacturerSelectAll(){ 
	var category_id;
	var filter_category_id = document.getElementsByName('manufacturer_gift[]');
	
	for(j=0;j<(filter_category_id.length);j++){
	category_id = document.getElementsByName('manufacturer_gift[]').item(j).value;
																					//alert(category_id);
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_manufacturer_id=' +  category_id + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_category_id).attr('checked') == 'checked') {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product_gift').append('<div id="gift_promotion-product_gift' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="product_gift[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product_gift div:odd').attr('class', 'odd');
			$('#gift_promotion-product_gift div:even').attr('class', 'even');			
		}
	});
	}
}

$('input[name=\'manufacturer_gift[]\']').bind('change', function() {
	var filter_manufacturer_id = this;
	
	$.ajax({
		url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_manufacturer_id=' +  filter_manufacturer_id.value + '&limit=10000',
		dataType: 'json',
		success: function(json) {
			for (i = 0; i < json.length; i++) {
				if ($(filter_manufacturer_id).attr('checked') == 'checked') {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
					
					$('#gift_promotion-product_gift').append('<div id="gift_promotion-product_gift' + json[i]['product_id'] + '">' + json[i]['name'] + '<img src="view/image/delete.png" /><input type="hidden" name="product_gift[]" value="' + json[i]['product_id'] + '" /></div>');
				} else {
					$('#gift_promotion-product_gift' + json[i]['product_id']).remove();
				}			
			}
			
			$('#gift_promotion-product_gift div:odd').attr('class', 'odd');
			$('#gift_promotion-product_gift div:even').attr('class', 'even');			
		}
	});
});

$('input[name=\'product_gift_suggest\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/gift_promotion/autocompleteGiftPromotion&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#gift_promotion-product_gift' + ui.item.value).remove();
		
		$('#gift_promotion-product_gift').append('<div id="gift_promotion-product_gift' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="product_gift[]" value="' + ui.item.value + '" /></div>');

		$('#gift_promotion-product_gift div:odd').attr('class', 'odd');
		$('#gift_promotion-product_gift div:even').attr('class', 'even');
		
		$('input[name=\'product_gift_suggest\']').val('');
		
		return false;
	}
});

$('#gift_promotion-product_gift div img').live('click', function() {
	$(this).parent().remove();
	
	$('#gift_promotion-product_gift div:odd').attr('class', 'odd');
	$('#gift_promotion-product_gift div:even').attr('class', 'even');	
});
//--></script> 


<script type="text/javascript"><!--
$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
//--></script>
<?php if ($gift_promotion_id) { ?>
<script type="text/javascript"><!--
$('#history .pagination a').live('click', function() {
	$('#history').load(this.href);
	
	return false;
});			

$('#history').load('index.php?route=sale/gift_promotion/history&token=<?php echo $token; ?>&gift_promotion_id=<?php echo $gift_promotion_id; ?>');
//--></script>
<?php } ?>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script> 

<?php echo $footer; ?>