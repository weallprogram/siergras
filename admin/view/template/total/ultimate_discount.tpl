<?php

/**
* Ultimate Discount extension for Opencart.
*
* @author Anthony Lawrence <freelancer@anthonylawrence.me.uk>
* @version 1.0
* @copyright © Anthony Lawrence 2011
* @license Creative Common's ShareAlike License - http://creativecommons.org/licenses/by-sa/3.0/
*/


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
            <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>
        <div class="content">
            <div id="tabs" class="htabs">
                <a href="#tab-general"><?=$tab_general?></a>
                <a href="#tab-store"><?=$tab_store?></a>
                <a href="#tab-category"><?=$tab_category?></a>
                <a href="#tab-multi"><?=$tab_multi?></a>
            </div>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <div id="tab-general">
                    <table class="form">
                        <tr>
                            <td><?php echo $entry_status; ?></td>
                            <td><select name="ultimate_discount_status">
                                    <?php if ($ultimate_discount_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_multi_override; ?><br /><span class="help"><?php echo $description_multi_override?></span></td>
                            <td><select name="ultimate_discount_multi_override">
                                    <?php if ($ultimate_discount_multi_override) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td><?php echo $entry_sort_order; ?></td>
                            <td><input type="text" name="ultimate_discount_sort_order" value="<?php echo $ultimate_discount_sort_order; ?>" size="1" /></td>
                        </tr>
                    </table>
                </div>
                <div id="tab-store">
                    <p><?=$description_store?></p>
                    <table id="store" class="list">
                        <thead>
                            <tr>
                                <td class="center"><?php echo $entry_customer; ?></td>
                                <td class="center"><?php echo $entry_date_start; ?></td>
                                <td class="center"><?php echo $entry_date_end; ?></td>
                                <td class="center"><?php echo $entry_type; ?></td>
                                <td class="center"><?php echo $entry_total; ?></td>
                                <td class="center"><?php echo $entry_amount; ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php if(is_array($ultimate_discount_store)): ?>
                        <?php foreach($ultimate_discount_store as $key => $value): ?>
                        <tbody id="store-row<?=$key?>">
                            <tr>
                                <td class="center">
                                    <select name="ultimate_discount_store[<?=$key?>][customer_group_id]">
                                        <?php foreach($customer_groups as $cg): ?>
                                        <option value="<?=$cg['customer_group_id']?>" <?=(($cg['customer_group_id'] == $value['customer_group_id']) ? 'selected="selected"' : '')?>><?=$cg["name"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="center"><input type="text" name="ultimate_discount_store[<?=$key?>][date_start]" class="date_start" value="<?=$value['date_start']?>" /></td>
                                <td class="center"><input type="text" name="ultimate_discount_store[<?=$key?>][date_end]" class="date_end" value="<?=$value['date_end']?>" /></td>
                                <td class="center">
                                    <select name="ultimate_discount_store[<?=$key?>][type]">
                                        <option value="F" <?= (($value['type'] == "F" ? "selected='selected'" : "")) ?>>Fixed Value</option>
                                        <option value="P" <?= (($value['type'] == "P" ? "selected='selected'" : "")) ?>>Percentage</option>
                                    </select>
                                </td>
                                <td class="center"><input type="text" name="ultimate_discount_store[<?=$key?>][total]" value="<?=$value['total']?>" /></td>
                                <td class="center"><input type="text" name="ultimate_discount_store[<?=$key?>][amount]" value="<?=$value['amount']?>" /></td>
                                <td class="center"><a onclick="$('#store-row<?=$key?>').remove();" class="button"><span>Remove</span></a></td>
                            </tr>
                        </tbody>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td colspan="2" class="center"><a onclick="addStoreDiscount();" class="button"><span>Add Extra Row</span></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div id="tab-category">
                    <p><?=$description_category?></p>
                    <table id="category" class="list">
                        <thead>
                            <tr>
                                <td class="center"><?php echo $entry_customer; ?></td>
                                <td class="center"><?php echo $entry_category; ?></td>
                                <td class="center"><?php echo $entry_date_start; ?></td>
                                <td class="center"><?php echo $entry_date_end; ?></td>
                                <td class="center"><?php echo $entry_type; ?></td>
                                <td class="center"><?php echo $entry_total; ?></td>
                                <td class="center"><?php echo $entry_amount; ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php if(is_array($ultimate_discount_category)): ?>
                        <?php foreach($ultimate_discount_category as $key => $value): ?>
                        <tbody id="category-row<?=$key?>">
                            <tr>
                                <td class="center">
                                    <select name="ultimate_discount_category[<?=$key?>][customer_group_id]">
                                        <?php foreach($customer_groups as $cg): ?>
                                        <option value="<?=$cg['customer_group_id']?>" <?=(($cg['customer_group_id'] == $value['customer_group_id']) ? 'selected="selected"' : '')?>><?=$cg["name"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="center">
                                    <select name="ultimate_discount_category[<?=$key?>][category_id]">
                                        <?php foreach($categories as $category): ?>
                                        <option value="<?=$category['category_id']?>" <?=(($category['category_id'] == $value['category_id']) ? 'selected="selected"' : '')?>><?=$category["name"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="center"><input type="text" name="ultimate_discount_category[<?=$key?>][date_start]" class="date_start" value="<?=$value['date_start']?>" /></td>
                                <td class="center"><input type="text" name="ultimate_discount_category[<?=$key?>][date_end]" class="date_end" value="<?=$value['date_end']?>" /></td>
                                <td class="center">
                                    <select name="ultimate_discount_category[<?=$key?>][type]">
                                        <option value="F" <?= (($value['type'] == "F" ? "selected='selected'" : "")) ?>>Fixed Value</option>
                                        <option value="P" <?= (($value['type'] == "P" ? "selected='selected'" : "")) ?>>Percentage</option>
                                    </select>
                                </td>
                                <td class="center"><input type="text" name="ultimate_discount_category[<?=$key?>][total]" value="<?=$value['total']?>" /></td>
                                <td class="center"><input type="text" name="ultimate_discount_category[<?=$key?>][amount]" value="<?=$value['amount']?>" /></td>
                                <td class="center"><a onclick="$('#category-row<?=$key?>').remove();" class="button"><span>Remove</span></a></td>
                            </tr>
                        </tbody>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td colspan="2" class="center"><a onclick="addCategoryDiscount();" class="button"><span>Add Extra Row</span></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div id="tab-multi">
                    <p><?=$description_multi?></p>
                    <table id="multi" class="list">
                        <thead>
                            <tr>
                                <td class="center"><?php echo $entry_customer; ?></td>
                                <td class="center"><?php echo $entry_category; ?></td>
                                <td class="center"><?php echo $entry_date_start; ?></td>
                                <td class="center"><?php echo $entry_date_end; ?></td>
                                <td class="center"><?php echo $entry_rule; ?></td>
                                <td class="center"><?php echo $entry_rule_amount; ?></td>
                                <td class="center"><?php echo $entry_amount; ?></td>
                                <td></td>
                            </tr>
                        </thead>
                        <?php if(is_array($ultimate_discount_multi)): ?>
                        <?php foreach($ultimate_discount_multi as $key => $value): ?>
                        <tbody id="multi-row<?=$key?>">
                            <tr>
                                <td class="center">
                                    <select name="ultimate_discount_multi[<?=$key?>][customer_group_id]">
                                        <?php foreach($customer_groups as $cg): ?>
                                        <option value="<?=$cg['customer_group_id']?>" <?=(($cg['customer_group_id'] == $value['customer_group_id']) ? 'selected="selected"' : '')?>><?=$cg["name"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="center">
                                    <select name="ultimate_discount_multi[<?=$key?>][category_id]">
                                        <?php foreach($categories as $cat): ?>
                                        <option value="<?=$cat['category_id']?>" <?=(($cat['category_id'] == $value['category_id']) ? 'selected="selected"' : '')?>><?=$cat["name"]?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="center"><input type="text" name="ultimate_discount_multi[<?=$key?>][date_start]" class="date_start" value="<?=$value['date_start']?>" /></td>
                                <td class="center"><input type="text" name="ultimate_discount_multi[<?=$key?>][date_end]" class="date_end" value="<?=$value['date_end']?>" /></td>
                                <td class="center">
                                    <select name="ultimate_discount_multi[<?=$key?>][rule]">
                                        <option value="O" <?= (($value['rule'] == "O" ? "selected='selected'" : "")) ?>><?=$entry_rules_once?></option>
                                        <option value="E" <?= (($value['rule'] == "E" ? "selected='selected'" : "")) ?>><?=$entry_rules_every?></option>
                                    </select>
                                </td>
                                <td class="center"><input type="text" name="ultimate_discount_multi[<?=$key?>][rule_amount]" value="<?=$value['rule_amount']?>" /></td>
                                <td class="center"><input type="text" name="ultimate_discount_multi[<?=$key?>][amount]" value="<?=$value['amount']?>" /></td>
                                <td class="center"><a onclick="$('#multi-row<?=$key?>').remove();" class="button"><span>Remove</span></a></td>
                            </tr>
                        </tbody>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <tfoot>
                            <tr>
                                <td colspan="6"></td>
                                <td colspan="2" class="center"><a onclick="addMultiDiscount();" class="button"><span>Add Extra Row</span></a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript"><!--
        $('.date_start').datepicker({dateFormat: 'yy-mm-dd'});
        $('.date_end').datepicker({dateFormat: 'yy-mm-dd'});
        //--></script>
    <script type="text/javascript"><!--
        $('#tabs a').tabs(); 
        $('#languages a').tabs(); 
        $('#vtab-option a').tabs();
        //--></script> 
    <script type="text/javascript"><!--
        var store_row = <?=(is_array($ultimate_discount_store) ? count($ultimate_discount_store) : 0)?>;

        function addStoreDiscount() {
        html  = '<tbody id="store-row' + store_row + '">';
        html += '  <tr>'; 
        html += '    <td class="center"><select name="ultimate_discount_store[' + store_row + '][customer_group_id]">';
                <?php foreach($customer_groups as $cg): ?>
                    html += '<option value="<?=$cg['customer_group_id']?>"><?=addslashes($cg['name'])?></option>';
                <?php endforeach; ?>
        html += '    </td>';
        html += '    <td class="center"><input type="text" name="ultimate_discount_store[' + store_row + '][date_start]" class="date_start" /></td>';
        html += '    <td class="center"><input type="text" name="ultimate_discount_store[' + store_row + '][date_end]" class="date_end" /></td>';
        html += '    <td class="center">';
        html += '      <select name="ultimate_discount_store[' + store_row + '][type]">';		
        html += '        <option value="F">Fixed Value</option>';
        html += '        <option value="P">Percentage</option>';
        html += '      </select>';
        html += '    </td>';
        html += '    <td class="center"><input type="text" name="ultimate_discount_store[' + store_row + '][total]" /></td>';
        html += '    <td class="center"><input type="text" name="ultimate_discount_store[' + store_row + '][amount]" /></td>';
        html += '    <td class="center"><a onclick="$(\'#store-row' + store_row + '\').remove();" class="button"><span>Remove</span></a></td>';
        html += '  </tr>';	
        html += '</tbody>';
	
        $('#store tfoot').before(html);
		
        $('#store-row' + store_row + ' .date_start').datepicker({dateFormat: 'yy-mm-dd'});
        $('#store-row' + store_row + ' .date_end').datepicker({dateFormat: 'yy-mm-dd'});
	
        store_row++;
    }
    //--></script> 
    <script type="text/javascript"><!--
    var category_row = <?=(is_array($ultimate_discount_category) ? count($ultimate_discount_category) : 0)?>;

    function addCategoryDiscount() {
    html  = '<tbody id="category-row' + category_row + '">';
    html += '  <tr>'; 
    html += '    <td class="center"><select name="ultimate_discount_category[' + category_row + '][customer_group_id]">';
            <?php foreach($customer_groups as $cg): ?>
                html += '<option value="<?=$cg['customer_group_id']?>"><?=addslashes($cg['name'])?></option>';
            <?php endforeach; ?>
    html += '    </td>';
    html += '    <td class="center"><select name="ultimate_discount_category[' + category_row + '][category_id]">';
            <?php foreach($categories as $category): ?>
                html += '<option value="<?=$category['category_id']?>"><?=addslashes($category['name'])?></option>';
            <?php endforeach; ?>
    html += '    </td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_category[' + category_row + '][date_start]" class="date_start" /></td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_category[' + category_row + '][date_end]" class="date_end" /></td>';
    html += '    <td class="center">';
    html += '      <select name="ultimate_discount_category[' + category_row + '][type]">';		
    html += '        <option value="F">Fixed Value</option>';
    html += '        <option value="P">Percentage</option>';
    html += '      </select>';
    html += '    </td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_category[' + category_row + '][total]" /></td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_category[' + category_row + '][amount]" /></td>';
    html += '    <td class="center"><a onclick="$(\'#category-row' + category_row + '\').remove();" class="button"><span>Remove</span></a></td>';
    html += '  </tr>';	
    html += '</tbody>';
	
    $('#category tfoot').before(html);
		
    $('#category-row' + category_row + ' .date_start').datepicker({dateFormat: 'yy-mm-dd'});
    $('#category-row' + category_row + ' .date_end').datepicker({dateFormat: 'yy-mm-dd'});
	
    category_row++;
}
//--></script>
    <script type="text/javascript"><!--
    var multi_row = <?=(is_array($ultimate_discount_multi) ? count($ultimate_discount_multi) : 0)?>;

    function addMultiDiscount() {
    html  = '<tbody id="multi-row' + multi_row + '">';
    html += '  <tr>'; 
    html += '    <td class="center"><select name="ultimate_discount_multi[' + multi_row + '][customer_group_id]">';
            <?php foreach($customer_groups as $cg): ?>
                html += '<option value="<?=$cg['customer_group_id']?>"><?=addslashes($cg['name'])?></option>';
            <?php endforeach; ?>
    html += '    </td>';
    html += '    <td class="center"><select name="ultimate_discount_multi[' + multi_row + '][category_id]">';
            <?php foreach($categories as $category): ?>
                html += '<option value="<?=$category['category_id']?>"><?=addslashes($category['name'])?></option>';
            <?php endforeach; ?>
    html += '    </td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_multi[' + multi_row + '][date_start]" class="date_start" /></td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_multi[' + multi_row + '][date_end]" class="date_end" /></td>';
    html += '    <td class="center">';
    html += '      <select name="ultimate_discount_multi[' + multi_row + '][rule]">';		
    html += '        <option value="O"><?=$entry_rules_once?></option>';
    html += '        <option value="E"><?=$entry_rules_every?></option>';
    html += '      </select>';
    html += '    </td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_multi[' + multi_row + '][rule_amount]" /></td>';
    html += '    <td class="center"><input type="text" name="ultimate_discount_multi[' + multi_row + '][amount]" /></td>';
    html += '    <td class="center"><a onclick="$(\'#multi-row' + multi_row + '\').remove();" class="button"><span>Remove</span></a></td>';
    html += '  </tr>';	
    html += '</tbody>';
	
    $('#multi tfoot').before(html);
		
    $('#multi-row' + multi_row + ' .date_start').datepicker({dateFormat: 'yy-mm-dd'});
    $('#multi-row' + multi_row + ' .date_end').datepicker({dateFormat: 'yy-mm-dd'});
	
    category_row++;
}
//--></script>
    <?php echo $footer; ?>
