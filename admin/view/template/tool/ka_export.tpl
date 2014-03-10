<?php 
/*
  Project: CSV Product Export
  Author : karapuz <support@ka-station.com>

  Version: 3.2 ($Revision: 6 $)

*/

echo $header;

?>

<style type="text/css">
<!--

span.important_note {
  color: red;
  font-weight: normal;
}

div.scroll {
  height: 200px;
  width: 100%;
  overflow: auto;
  border: 1px solid black;
  background-color: #ccc;
  padding: 8px;
}

a.download {
  font-size: 28px;
  align: justify;
  width: 100%;
/*  display: none; */
}

.list td a.link {
  text-decoration: underline;
  color: blue;
}

#export_status {
  color: black;
}

-->
</style>

<div id="content">

  <?php echo $ka_top; ?>

  <div class="box">

    <?php if (!empty($is_wrong_db)) { ?>

      <?php echo $this->language->get('Database is not compatible...'); ?>
  
    <?php } elseif ($params['step'] == 1) { ?>

    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?>: <?php echo $this->language->get('STEP 1 of 3'); ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button"><span><?php echo $this->language->get('Next'); ?></span></a>
      </div>
    </div>
    <div class="content">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <input type="hidden" name="mode" value="" />

        <table class="form">      
          <tr>
            <td colspan="3">
            <?php echo $this->language->get('This page allows you to export...'); ?><br /><br />
            </td>
          </tr>
          <tr>
            <td width="25%"><?php echo $this->language->get('Profile'); ?></td>
            <td>
              <?php if (!empty($profiles)) { ?>
                <?php echo $this->showSelector("profile_id", $profiles, $params['profile_id']); ?>

                <input type="button" value="Load" onclick="javascript: loadProfile();" />
                <input type="button" value="Delete" onclick="javascript: deleteProfile();" />
               <?php } else { ?>
                <?php echo $this->language->get('no profiles present'); ?>
               <?php } ?>
            </td>
            <td width="50%"><span class="help"><?php echo $this->language->get('Profiles may store export p...'); ?></td>
          </tr>
        </table>
      
        <div id="tabs" class="htabs">
          <a href="#tab-general"><?php echo $this->language->get('General'); ?></a>
          <a href="#tab-extra"><?php echo $this->language->get('Extra'); ?></a>
        </div>
          
        <div id="tab-general">
        <table class="form">
          <tr>
            <td width="25%"><?php echo $this->language->get('Field Delimiter'); ?></td>
            <td>
              <select name="delimiter">               
                <option <?php if ($params['delimiter'] == 't') { ?>selected="selected" <?php } ?>value="t"><?php echo $this->language->get('tab'); ?></option>
                <option <?php if ($params['delimiter'] == 's') { ?>selected="selected" <?php } ?>value="s"><?php echo $this->language->get('semicolon'); ?> ";"</option>
                <option <?php if ($params['delimiter'] == 'c') { ?>selected="selected" <?php } ?>value="c"><?php echo $this->language->get('comma'); ?> ","</option>
              </select>
            </td>
            <td width="50%"><span class="help"><?php echo $this->language->get('the \'tab\' delimiter is reco...'); ?></td>
          </tr>

          <tr>
            <td width="25%"><?php echo $this->language->get('File Charset'); ?></td>
            <td colspan="2">
              <input type="hidden" id="charset_option" name="charset_option" value="<?php echo $params['charset_option']; ?>" />
              <table width="400px">

                <tr id="predefined_charset_row" <?php if ($params['charset_option'] != 'predefined') { ?> style="display:none" <?php } ?>>
                  <td width="280px">
                    <?php echo $this->showSelector("charset", $charsets, $params['charset']); ?>
                  </td>
                  <td><a href="javascript: void(0);" onclick="javascript: activateCharset('custom');">make editable</a></td>
                </tr>

                <tr id="custom_charset_row" <?php if ($params['charset_option'] == 'predefined') { ?> style="display:none" <?php } ?>>
                  <td width="250px">
                    <input type="text" style="width: 240px" id="custom_charset" name="custom_charset" value="<?php echo $params['charset']; ?>" />
                  </td>
                  <td><a href="javascript: void(0);" onclick="javascript: activateCharset('predefined');"><?php echo $this->language->get('select from predefined values'); ?></a></td>
                </tr>

              </table>
              <span class="help"><?php echo $this->language->get('You have to keep in mind th...'); ?></span>
            </td>
          </tr>

          <tr>
            <td width="25%"><?php echo $this->language->get('Category Separator'); ?></td>
            <td colspan="2">
              <input type="text" name="cat_separator" maxlength="8" size="8" value="<?php echo $params['cat_separator']; ?>" />
            </td>
          </tr>

          <tr>
            <td width="25%"><?php echo $this->language->get('Image Path'); ?></td>
            <td>
              <select name="image_path">
                <option value="path" <?php if ($params['image_path'] == 'path') { ?>selected="selected"<?php } ?>><?php echo $this->language->get('Server Path'); ?></option>
                <option value="url" <?php if ($params['image_path'] == 'url') { ?>selected="selected"<?php } ?>><?php echo $this->language->get('URL'); ?></option>
              </select>                
            </td>
            <td width="50%">&nbsp;</td>
          </tr>

          <tr>
            <td width="25%"><?php echo $this->language->get('Products From Categories'); ?></td>
            <td colspan="2">
                <input type="radio" name="products_from_categories" onclick="javascript: showCategories('all');" value="all" <?php if ($params['products_from_categories'] == 'all') { ?> checked="checked" <?php } ?> /><?php echo $this->language->get('All'); ?>&nbsp;&nbsp;
                <input type="radio" name="products_from_categories" onclick="javascript: showCategories('selected');" value="selected" <?php if ($params['products_from_categories'] == 'selected') { ?> checked="checked" <?php } ?> /><?php echo $this->language->get('Selected'); ?>
            </td>
            </tr>
          </tr>

          <tr id="export_selected_categories" <?php if ($params['products_from_categories'] != 'selected') { ?>style="display:none" <?php } ?>>
            <td width="25%"><?php echo $this->language->get('Categories'); ?></td>
            <td colspan="2">
                <div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($categories as $category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($category['category_id'], $params['category_ids'])) { ?>
                    <input type="checkbox" name="category_ids[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                    <?php echo $category['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="category_ids[]" value="<?php echo $category['category_id']; ?>" />
                    <?php echo $category['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $this->language->get('Select All'); ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $this->language->get('Unselect All'); ?></a>
            </td>
          </tr>

          <tr>
            <td width="25%"><?php echo $this->language->get('Products From Manufacturers'); ?></td>
            <td colspan="2">
                <input type="radio" name="products_from_manufacturers" onclick="javascript: showManufacturers('all');" value="all" <?php if ($params['products_from_manufacturers'] == 'all') { ?> checked="checked" <?php } ?> /><?php echo $this->language->get('All'); ?>&nbsp;&nbsp;
                <input type="radio" name="products_from_manufacturers" onclick="javascript: showManufacturers('selected');" value="selected" <?php if ($params['products_from_manufacturers'] == 'selected') { ?> checked="checked" <?php } ?> /><?php echo $this->language->get('Selected'); ?>
            </td>
            </tr>
          </tr>
                    
          <tr id="export_selected_manufacturers" <?php if ($params['products_from_manufacturers'] != 'selected') { ?>style="display:none" <?php } ?>>
            <td width="25%"><?php echo $this->language->get('Manufacturers'); ?></td>
            <td colspan="2">
                <div class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($manufacturers as $manufacturer) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($manufacturer['manufacturer_id'], $params['manufacturer_ids'])) { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                    <?php echo $manufacturer['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="manufacturer_ids[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                    <?php echo $manufacturer['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $this->language->get('Select All'); ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $this->language->get('Unselect All'); ?></a>
            </td>
          </tr>
          
          <tr>
            <td width="25%"><?php echo $this->language->get('Copy the exported file to'); ?></td>
            <td colspan="2">
              <?php echo $store_root_dir . DIRECTORY_SEPARATOR; ?> <input type="text" name="copy_path" value="<?php echo $params['copy_path'];?>" /><br />
              <span class="help"><?php echo $this->language->get('it may be used when the exp...'); ?></span>
            </td>
          </tr>
          
        </table>
      </div>

      <div id="tab-extra">
        <table class="form">
          <tr>
            <td width="25%"><?php echo $this->language->get('Language'); ?></td>
            <td>
              <select name="language_id">
                <?php foreach ($languages as $language) { ?>
                  <option value="<?php echo $language['language_id']; ?>" <?php if ($language['language_id'] == $params['language_id']) { ?>selected="selected"<?php } ?>><?php echo $language['name']; ?></option>
                <?php } ?>
              </select>
            </td>
            <td width="50%">&nbsp;</td>
          </tr>

          <tr>
            <td width="25%"><?php echo $this->language->get('Currency'); ?></td>
            <td>
              <select name="currency">
                <?php foreach ($currencies as $cur) { ?>
                  <option value="<?php echo $cur['code']; ?>" <?php if ($cur['code'] == $params['currency']['code']) { ?>selected="selected"<?php } ?>><?php echo $cur['title']; ?></option>
                <?php } ?>
              </select>
            </td>
            <td width="50%">&nbsp;</td>
          </tr>
          
          <tr>
            <td width="25%"><?php echo $this->language->get('Store'); ?></td>
            <td>              
              <select name="store_id">
                <?php foreach($stores as $store) { ?>
                  <option <?php if ($store['store_id'] == $params['store_id']) { ?>selected="selected" <?php } ?>value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                <?php } ?>
              </select>
            </td>
            <td width="50%">&nbsp;</td>
          </tr>

          <tr>
            <td width="25%"><?php echo $this->language->get('Apply Taxes to Prices'); ?></td>
            <td>
              <input type="checkbox" id="apply_taxes" name="apply_taxes" value="Y" <?php if (!empty($params['apply_taxes'])) { ?>checked="checked" <?php } ?> onclick="javascript: applyTaxesChanged();" />
            </td>
            <td width="50%">&nbsp;</td>
          </tr>

          <?php if (!empty($geo_zones)) { ?>
            <tr id="geo_zone_select" <?php if (empty($params['apply_taxes'])) { ?> style="display: none" <?php } ?>>
              <td width="25%"><?php echo $this->language->get('Use Taxes for Geo Zone'); ?></td>
              <td>
                <select name="geo_zone_id">
                  <?php foreach($geo_zones as $gz) { ?>
                    <option <?php if ($gz['geo_zone_id'] == $params['geo_zone_id']) { ?>selected="selected" <?php } ?>value="<?php echo $gz['geo_zone_id']; ?>"><?php echo $gz['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
              <td width="50%">&nbsp;</td>
            </tr>
          <?php } ?>         

          <tr>
            <td width="25%"><?php echo $this->language->get('Use special/discounted price'); ?></td>
            <td>
              <input type="checkbox" id="use_special_price" name="use_special_price" value="Y" <?php if (!empty($params['use_special_price'])) { ?>checked="checked" <?php } ?> onclick="javascript: useSpecialPriceChanged();" />
            </td>
            <td width="50%"><span class="help"><?php echo $this->language->get('main product price will be ...'); ?></span></td>
          </tr>
          
          <?php if (!empty($customer_groups)) { ?>
            <tr id="customer_group_select" <?php if (empty($params['use_special_price'])) { ?> style="display: none" <?php } ?>>
              <td width="25%"><?php echo $this->language->get('Use Prices for Customer Group'); ?></td>
              <td>
                <select name="customer_group_id">
                  <?php foreach($customer_groups as $cg) { ?>
                    <option <?php if ($cg['customer_group_id'] == $params['customer_group_id']) { ?>selected="selected" <?php } ?>value="<?php echo $cg['customer_group_id']; ?>"><?php echo $cg['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
              <td width="50%">&nbsp;</td>
            </tr>
          <?php } ?>
                    
        </table>
      </form>
    </div>

<script type="text/javascript"><!--

$(document).ready(function() {
  $('#tabs a').tabs();
});

function applyTaxesChanged() {
  if ($('#apply_taxes').attr('checked')) {
    $('#geo_zone_select').show();
        
  } else {
    $('#geo_zone_select').hide();
  }
}

function useSpecialPriceChanged() {

  if ($('#use_special_price').attr('checked')) {
    $('#customer_group_select').show();
        
  } else {
    $('#customer_group_select').hide();
  }
}

function showCategories(id) {
  if (id == 'all') {
    $('#export_selected_categories').hide();
  } else if (id == 'selected') {
    $('#export_selected_categories').show();
  }
}

function showManufacturers(id) {
  if (id == 'all') {
    $('#export_selected_manufacturers').hide();
  } else if (id == 'selected') {
    $('#export_selected_manufacturers').show();
  }
}


function activateCharset(id) {
  if (id == 'predefined') {
    $('#predefined_charset_row').show();
    $('#custom_charset_row').hide();
    $('#charset_option').val('predefined');

  } else if (id == 'custom') {
    $('#predefined_charset_row').hide();
    $('#custom_charset_row').show();
    $('#charset_option').val('custom');
  }
}

function loadProfile() {

  $("#form input[name='mode']").attr('value', 'load_profile');
  $("#form").submit();
}

function deleteProfile() {

  $("#form input[name='mode']").attr('value', 'delete_profile');
  $("#form").submit();
}


//--></script> 

    <?php } elseif ($params['step'] == 2) { ?>

    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?>: <?php echo $this->language->get('STEP 2 of 3'); ?></h1>
      <div class="buttons">
        <a onclick="location='<?php echo $back_action; ?>'" class="button"><span><?php echo $this->language->get('Back'); ?></span></a>
        <a onclick="$('#form').submit();" class="button"><span><?php echo $this->language->get('Next'); ?></span></a>    
      </div>
    </div>
    <div class="content">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

        <input type="hidden" name="mode" value="" />
      
        <table style="padding-bottom: 10px">
          <tr>
            <td width="25%">Profile</td>
            <td>
              <input type="hidden" name="profile_id" value="<?php echo $params['profile_id']; ?>" />
              <input type="text" name="profile_name" value="<?php echo $params['profile_name']; ?>" />
            </td>
            <td>
              <input type="button" value="Save" onclick="javascript: saveProfile();" />
            </td>
          </tr>
        </table>
          
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $this->language->get('General'); ?></a>
        <a href="#tab-attributes"><?php echo $this->language->get('Attributes'); ?></a>
        <?php if ($filters_enabled) { ?>
          <a href="#tab-filters"><?php echo $this->language->get('Filters'); ?></a>
        <?php } ?>
        <a href="#tab-options"><?php echo $this->language->get('Options'); ?></a>
        <a href="#tab-discounts"><?php echo $this->language->get('Discounts'); ?></a>
        <a href="#tab-specials"><?php echo $this->language->get('Specials'); ?></a>
        <a href="#tab-reward_points"><?php echo $this->language->get('Reward Points'); ?></a>
      </div>

        <div id="tab-general">

          <?php echo $this->language->get('Check fields to include the...'); ?><br /><br />

        <table class="list">

          <thead>
            <tr>
              <td class="left" width="25%"><?php echo $this->language->get('Product Field'); ?></td>
              <td><?php echo $this->language->get('Column in File'); ?></td>
              <td>Include <br />(<a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[general]&quot;]').attr('checked','checked');"><?php echo $this->language->get('all'); ?></a>
              / <a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[general]&quot;]').not('[disabled=&quot;disabled&quot;]').removeAttr('checked');"><?php echo $this->language->get('none'); ?></a>)</td>
              <td width="50%"><?php echo $this->language->get('Notes'); ?></td>
            </tr>
          </thead>

          <tbody>
          <?php foreach($general as $k => $v) { 
            if (!empty($columns['general'][$v['field']]['column'])) {
              $v['column'] = $columns['general'][$v['field']]['column'];
            } else {
              $v['column'] = $v['field'];
            }            
          ?>
            <tr>
              <td width="25%"><?php echo $v['name'] ?>
                <?php if (!empty($v['required'])) { ?><span class="required">*</span><?php } ?>
              </td>
              <td>
                <input type="input" value="<?php echo $v['column']; ?>" name="columns[general][<?php echo $v['field']; ?>][column]" />
              </td>
              <td>
                <input type="checkbox" value="Y" name="columns[general][<?php echo $v['field']; ?>][checked]" 
                  <?php if (!empty($v['required'])) { ?> disabled="disabled" <?php } ?> 
                  <?php if (!empty($v['required']) || !empty($columns['general'][$v['field']]['checked'])) { ?> checked="checked" <?php } ?> 
                />
              </td>
              <td width="50%"><span class="help"><?php echo $v['descr']; ?></span></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>

        <div id="tab-attributes">

        <?php echo $this->language->get('Check attributes to include...'); ?><br /><br />

        <table class="list">
          <thead>
            <tr>
              <td class="left" width="25%"><?php echo $this->language->get('Atribute Name'); ?></td>
              <td><?php echo $this->language->get('Column in File'); ?></td>
              <td><?php echo $this->language->get('Include'); ?> <br />(<a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[attributes]&quot;]').attr('checked','checked');"><?php echo $this->language->get('all'); ?></a>
              / <a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[attributes]&quot;]').not('[disabled=&quot;disabled&quot;]').removeAttr('checked');"><?php echo $this->language->get('none'); ?></a>)</td>
              <td width="5%"><?php echo $this->language->get('Attribute Group'); ?></td>
            </tr>
          </thead>

          <tbody>
          <?php foreach($attributes as $k => $v) { 
            if (!empty($columns['attributes'][$v['attribute_id']]['column'])) {
              $v['column'] = $columns['attributes'][$v['attribute_id']]['column'];
            } else {
              $v['column'] = 'attribute:' . $v['name'];
            }
          ?>
            <tr>
              <td width="25%"><?php echo $v['name'] ?></td>
              <td>
                <input type="text" value="<?php echo $v['column']; ?>" name="columns[attributes][<?php echo $v['attribute_id']; ?>][column]" />
              </td>
              <td>
                <input type="checkbox" value="Y" name="columns[attributes][<?php echo $v['attribute_id']; ?>][checked]" 
                  <?php if (!empty($columns['attributes'][$v['attribute_id']]['checked'])) { ?> checked="checked" <?php } ?> 
                />
              </td>
              <td width="50%"><?php echo $v['attribute_group']; ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>

        
        <?php if ($filters_enabled) { ?>
          <div id="tab-filters">

          <?php echo $this->language->get('Check filters to include th...'); ?><br /><br />
          
          <table class="list">
            <thead>
              <tr>
                <td class="left" width="25%"><?php echo $this->language->get('Filter Group'); ?></td>
                <td><?php echo $this->language->get('Column in File'); ?></td>
                <td><?php echo $this->language->get('Include'); ?> <br />(<a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[filter_groups]&quot;]').attr('checked','checked');"><?php echo $this->language->get('all'); ?></a>
                / <a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[filter_groups]&quot;]').not('[disabled=&quot;disabled&quot;]').removeAttr('checked');"><?php echo $this->language->get('none'); ?></a>)</td>
                <td width="5%">&nbsp;</td>
              </tr>
            </thead>

            <tbody>
            <?php foreach($filter_groups as $k => $v) { ?>           
              <tr>
                <td width="25%"><?php echo $v['name'] ?></td>
                <td>
                  <?php echo $v['name']; ?>
                  <input type="hidden" value="<?php echo $v['name']; ?>" name="columns[filter_groups][<?php echo $v['filter_group_id']; ?>][name]" />
                </td>
                <td>
                  <input type="checkbox" value="Y" name="columns[filter_groups][<?php echo $v['filter_group_id']; ?>][checked]" 
                    <?php if (!empty($columns['filter_groups'][$v['filter_group_id']]['checked'])) { ?> checked="checked" <?php } ?> 
                  />
                </td>
                <td width="50%">&nbsp;</td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
          </div>
        <?php } ?>
        
        <div id="tab-options">

        <?php echo $this->language->get('Check options to include th...'); ?><br /><br />

        <table class="list">
          <thead>
            <tr>
              <td class="left" width="25%"><?php echo $this->language->get('Option Name'); ?></td>
              <td><?php echo $this->language->get('Column in File'); ?></td>
              <td><?php echo $this->language->get('Include'); ?> <br />(<a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[options]&quot;]').attr('checked','checked');"><?php echo $this->language->get('all'); ?></a>
              / <a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[options]&quot;]').not('[disabled=&quot;disabled&quot;]').removeAttr('checked');"><?php echo $this->language->get('none'); ?></a>)</td>
              <td width="50%"><?php echo $this->language->get('Type'); ?></td>
            </tr>
          </thead>

          <tbody>
          <?php foreach($options as $k => $v) { ?>            
            <tr>
              <td width="25%"><?php echo $v['name'] ?></td>
              <td>
                <?php echo $v['name']; ?>
                <input type="hidden" value="<?php echo $v['name']; ?>" name="columns[options][<?php echo $v['option_id']; ?>][name]" />
              </td>
              <td>
                <input type="checkbox" value="Y" name="columns[options][<?php echo $v['option_id']; ?>][checked]" 
                  <?php if (!empty($columns['options'][$v['option_id']]['checked'])) { ?> checked="checked" <?php } ?> 
                />
              </td>
              <td width="45%"><?php echo $v['type']; ?></td>
            </tr>
          <?php } ?>

        </table>
        </div>

        <div id="tab-discounts">

        <?php echo $this->language->get('Check discounts to include ...'); ?><br /><br />

        <table class="list">
          <thead>
            <tr>
              <td class="left" width="25%"><?php echo $this->language->get('Field'); ?></td>
              <td><?php echo $this->language->get('Column in File'); ?></td>
              <td><?php echo $this->language->get('Include'); ?> <br />(<a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[discounts]&quot;]').attr('checked','checked');"><?php echo $this->language->get('all'); ?></a>
              / <a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[discounts]&quot;]').not('[disabled=&quot;disabled&quot;]').removeAttr('checked');"><?php echo $this->language->get('none'); ?></a>)</td>
              <td width="50%"></td>
            </tr>
          </thead>

          <tbody>
          <?php foreach($discounts as $k => $v) { ?>
            <tr>
              <td width="25%"><?php echo $v['name'] ?></td>
              <td>
                <?php echo $v['name']; ?>
                <input type="hidden" value="<?php echo $v['name']; ?>" name="columns[discounts][<?php echo $v['field']; ?>][name]" />
              </td>
              <td>
                <input type="checkbox" value="Y" name="columns[discounts][<?php echo $v['field']; ?>][checked]" 
                  <?php if (!empty($columns['discounts'][$v['field']]['checked'])) { ?> checked="checked" <?php } ?> 
                />
              </td>
              <td width="50%">&nbsp;</td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>

        <div id="tab-specials">

        <?php echo $this->language->get('Check special prices to inc...'); ?><br /><br />

        <table class="list">
          <thead>
            <tr>
              <td class="left" width="25%"><?php echo $this->language->get('Field'); ?></td>
              <td><?php echo $this->language->get('Column in File'); ?></td>
              <td><?php echo $this->language->get('Include'); ?> <br />(<a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[specials]&quot;]').attr('checked','checked');"><?php echo $this->language->get('all'); ?></a>
              / <a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[specials]&quot;]').not('[disabled=&quot;disabled&quot;]').removeAttr('checked');"><?php echo $this->language->get('none'); ?></a>)</td>
              <td width="50%"></td>
            </tr>
          </thead>

          <tbody>
          <?php foreach($specials as $k => $v) { ?>
            <tr>
              <td width="25%"><?php echo $v['name'] ?></td>
              <td>
                <?php echo $v['name']; ?>
                <input type="hidden" value="<?php echo $v['name']; ?>" name="columns[specials][<?php echo $v['field']; ?>][name]" />
              </td>
              <td>
                <input type="checkbox" value="Y" name="columns[specials][<?php echo $v['field']; ?>][checked]" 
                  <?php if (!empty($columns['specials'][$v['field']]['checked'])) { ?> checked="checked" <?php } ?> 
                />
              </td>
              <td width="50%">&nbsp;</td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>


        <div id="tab-reward_points">

        <?php echo $this->language->get('Check reward points to incl...'); ?><br /><br />

        <table class="list">
          <thead>
            <tr>
              <td class="left" width="25%"><?php echo $this->language->get('Field'); ?></td>
              <td><?php echo $this->language->get('Column in File'); ?></td>
              <td><?php echo $this->language->get('Include'); ?> <br />(<a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[reward_points]&quot;]').attr('checked','checked');"><?php echo $this->language->get('all'); ?></a>
              / <a class="link" href="javascript: void(0);" onclick="javascript: $('[name^=&quot;columns[reward_points]&quot;]').not('[disabled=&quot;disabled&quot;]').removeAttr('checked');"><?php echo $this->language->get('none'); ?></a>)</td>
              <td width="50%"></td>
            </tr>
          </thead>

          <tbody>
          <?php foreach($reward_points as $k => $v) { ?>
            <tr>
              <td width="25%"><?php echo $v['name'] ?></td>
              <td>
                <?php echo $v['name']; ?>
                <input type="hidden" value="<?php echo $v['name']; ?>" name="columns[reward_points][<?php echo $v['field']; ?>][name]" />
              </td>
              <td>
                <input type="checkbox" value="Y" name="columns[reward_points][<?php echo $v['field']; ?>][checked]" 
                  <?php if (!empty($columns['reward_points'][$v['field']]['checked'])) { ?> checked="checked" <?php } ?> 
                />
              </td>
              <td width="50%">&nbsp;</td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>

    </div>

<script type="text/javascript"><!--

$(document).ready(function() {
  $('#tabs a').tabs();
});

function saveProfile() {

  $("#form input[name='mode']").attr('value', 'save_profile');
  $("#form").submit();
}

//--></script> 

    <?php } elseif ($params['step'] == 3) { ?>

    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?>: <?php echo $this->language->get('STEP 3 of 3'); ?></h1>

      <div class="buttons" id="buttons_in_progress">
        <a onclick="javascript: ka_stop_export();" class="button"><span><?php echo $this->language->get('Stop'); ?></span></a>
      </div>
      <div class="buttons" id="buttons_stopped" style="display: none">
        <a onclick="javascript: ka_continue_export();" class="button"><span><?php echo $this->language->get('Continue'); ?></span></a>
      </div>
      <div class="buttons" id="buttons_completed" style="display: none">
        <a onclick="location='<?php echo $done_action; ?>'" class="button"><span><?php echo $this->language->get('Done'); ?></span></a>
      </div>
    </div>
    <div class="content">
        <h2 id="export_status"><?php echo $this->language->get('Export is in progress'); ?></h2>
        <table class="form">
          <tr>
            <td colspan="2"><?php echo $this->language->get('The export statistics updat...'); ?></td>
          </tr>
          <tr>
            <td width="25%"><?php echo $this->language->get('Completion at'); ?></td>
            <td id="completion_at">0%</td>
          </tr>
          <tr>
            <td width="25%"><?php echo $this->language->get('File Size'); ?></td>
            <td id="file_size">0</td>
          </tr>
          <tr>
            <td width="25%"><?php echo $this->language->get('Time Passed'); ?></td>
            <td id="time_passed">0</td>
          </tr>
          <tr>
            <td width="25%"><?php echo $this->language->get('Lines Processed'); ?></td>
            <td id="lines_processed">0</td>
          </tr>
          <tr>
            <td width="25%"><?php echo $this->language->get('Products Processed'); ?></td>
            <td id="products_processed">0</td>
          </tr>

          <tr id="download_row" style="display: none">
            <td colspan="2" align="center">
              <a class="download" href="<?php echo $download_link; ?>"><?php echo $this->language->get('download'); ?></a>
            </td>
          </tr>

          <tr>
            <td colspan="2">
              <h4><?php echo $this->language->get('Export messages'); ?>:</h4>
              <div class="scroll" id="scroll">
              </div>
              <input type="checkbox" id="autoscroll" checked="checked" /> <?php echo $this->language->get('Autoscrolling'); ?>
            </td>
          </tr>
        </table>
    </div>


<script type="text/javascript"><!--

var ka_page_url = '<?php echo $page_url; ?>';
var ka_timer    = null;

/*
  possible statuses
    in_progress -
    completed   -
    stopped     -
*/
var ka_export_status = 'in_progress';

/*
  possible ajax statuses:
    not_started -
    in_progress -
*/
var ka_ajax_status   = 'not_started';

function ka_update_interface(status) {
  $("#buttons_in_progress").hide();
  $("#buttons_completed").hide();
  $("#buttons_stopped").hide();

  if (status == 'stopped') {
    $("#export_status").html("<?php echo $this->language->get('Export stopped'); ?>");
    $("#buttons_stopped").show();

  } else if (status == 'completed') {
    $("#buttons_completed").show();
    $("#export_status").html("<?php echo $this->language->get('Export is complete!'); ?>");
    $("#download_row").show();
  
  } else if (status == 'in_progress') {
    $("#export_status").html('<?php echo $this->language->get('Export is in progress'); ?>');
    $("#buttons_in_progress").show();
  }
}


function ka_stop_export() {
  ka_export_status = 'stopped';
  $("#export_status").html('<?php echo $this->language->get('Export has been stopped'); ?>');
  ka_update_interface('stopped');
}


function ka_continue_export() {
  ka_export_status = 'in_progress';
  ka_update_interface('in_progress');
}


function ka_ajax_error(jqXHR, textStatus, errorThrown) {

  if ($.inArray(textStatus, ['abort', 'parseerror', 'error'])) {
    ka_export_status = 'stopped';

    if (jqXHR.status == '200') {
      ka_add_message("<?php echo $this->language->get('Server error (status='); ?>200). Details:" + jqXHR.responseText);
    } else {
      ka_add_message("<?php echo $this->language->get('Server error (status='); ?>" + jqXHR.status + ").");
    }
    ka_update_interface('stopped');
  } else {
    ka_add_message('<?php echo $this->language->get('Temporary connection problems.'); ?>');
  }

  ka_ajax_status = 'not_started';
}


function ka_ajax_success(data, textStatus, jqXHR) {

  if (data['messages']) {
    for (i in data['messages']) {
      ka_add_message(data['messages'][i]);
    }
  }

  if (data['status'] == 'error') {

    $("#export_status").html("Error: " + data['message']);
    ka_export_status = 'stopped';
    ka_update_interface('stopped');

  } else {

    $("#completion_at").html(data['completion_at']);
    $("#lines_processed").html(data['lines_processed']);
    $("#products_processed").html(data['products_processed']);
    $("#time_passed").html(data['time_passed']);
    $("#file_size").html(data['file_size']);

    if (data['status'] == 'completed') {
        ka_export_status = 'completed';
        ka_update_interface('completed');
    }
  }

  ka_ajax_status = 'not_started';
}


function ka_add_message(msg) {
  var dt       = new Date();
  var log_time = "[" + dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds() + "] ";
  $("#scroll").append(log_time + msg + "<br />");

  if ($("#autoscroll").attr("checked")) {
    $("#scroll").scrollTop(999999);
  }
}

var ka_dots     = 0;
var status_text = '';

function ka_export_loop() {

  if ($.inArray(ka_export_status, ['stopped', 'completed']) >= 0) {
    return;
  }

  if ($.inArray(ka_export_status, ['in_progress']) >= 0) {

    // show animation

    if (ka_dots == 0) {
      status_text = "<?php echo $this->language->get('Export is in progress'); ?>";
    } else {
      status_text = status_text + '.';
    }
    if (ka_dots++ > 5)
      ka_dots = 0;
    $("#export_status").html(status_text);
  }

  if ($.inArray(ka_ajax_status, ['not_started']) >= 0) {
    ka_ajax_status = 'in_progress';
    $.ajax({
      url: ka_page_url,
      dataType: 'json',
      cache : false,
      success: ka_ajax_success,
      error: ka_ajax_error
    });
  }
}

  
$(document).ready(function() {
  ka_timer = setInterval('ka_export_loop()', 750);
});

//--></script> 

    <?php } ?>

  </div>

  <span class="help"><?php echo $this->language->get('\'CSV Product Export\' extens...'); ?></span>
</div>

<?php echo $footer; ?>