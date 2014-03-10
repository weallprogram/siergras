<?php
// --------------------------------
// Side Shopping Cart for OpenCart
// By Best-Byte
// www.best-byte.com
// --------------------------------
?>
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
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
        <tr>
					<td><?php echo $entry_display; ?></td> 
					<td colspan="3">  
						<?php if($display) { 
						$checked1 = ' checked="checked"'; 
						$checked0 = ''; 
						} else { 
						$checked1 = ''; 
						$checked0 = ' checked="checked"'; 
						} ?> 
					<label for="display_1"><?php echo $entry_true; ?></label> 
					<input type="radio"<?php echo $checked1; ?> id="display_1" name="display" value="1" /> 
					<label for="display_0"><?php echo $entry_false; ?></label> 
					<input type="radio"<?php echo $checked0; ?> id="display_0" name="display" value="0" /> 
					</td> 
				</tr>        
        <tr>
					<td><?php echo $entry_itemtext; ?></td> 
					<td colspan="3">  
						<?php if($itemtext) { 
						$checked1 = ' checked="checked"'; 
						$checked0 = ''; 
						} else { 
						$checked1 = ''; 
						$checked0 = ' checked="checked"'; 
						} ?> 
					<label for="itemtext_1"><?php echo $entry_true; ?></label> 
					<input type="radio"<?php echo $checked1; ?> id="itemtext_1" name="itemtext" value="1" /> 
					<label for="itemtext_0"><?php echo $entry_false; ?></label> 
					<input type="radio"<?php echo $checked0; ?> id="itemtext_0" name="itemtext" value="0" /> 
					</td> 
				</tr> 
        <tr>
					<td><?php echo $entry_emptytext; ?></td> 
					<td colspan="3">  
						<?php if($emptytext) { 
						$checked1 = ' checked="checked"'; 
						$checked0 = ''; 
						} else { 
						$checked1 = ''; 
						$checked0 = ' checked="checked"'; 
						} ?> 
					<label for="emptytext_1"><?php echo $entry_true; ?></label> 
					<input type="radio"<?php echo $checked1; ?> id="emptytext_1" name="emptytext" value="1" /> 
					<label for="emptytext_0"><?php echo $entry_false; ?></label> 
					<input type="radio"<?php echo $checked0; ?> id="emptytext_0" name="emptytext" value="0" /> 
					</td> 
				</tr>                                 
      	<tr>
          <td><?php echo $entry_template; ?></td>
					<td colspan="3"> 
						<?php foreach ($templates as $template) { ?>
							<?php if ($template == $config_template) { ?>
								<span style='color: #990000; padding: 0 5px;'><b><?php echo $template; ?></b></span> 
							<?php } ?>
						<?php } ?>	
					</td>
				</tr>    
     </table>
      <table id="module" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
          <?php $module_row = 0; ?>
          <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
            <td class="left"><select name="sidecart_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="sidecart_module[<?php echo $module_row; ?>][position]">  
                <?php if ($module['position'] == 'column_left') { ?>
                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                <?php } else { ?>
                <option value="column_left"><?php echo $text_column_left; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_right') { ?>
                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                <?php } else { ?>
                <option value="column_right"><?php echo $text_column_right; ?></option>
                <?php } ?>
               </select></td>
            <td class="left"><select name="sidecart_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="sidecart_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
          </tr>
        </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
      <center><?php echo $entry_moduleinfo ?></center>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="sidecart_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="sidecart_module[' + module_row + '][position]">';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="sidecart_module[' + module_row + '][status]">';
  html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
  html += '      <option value="0"><?php echo $text_disabled; ?></option>';
  html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="sidecart_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>
<?php echo $footer; ?>