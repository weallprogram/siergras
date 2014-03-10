<?php
/*
  Project: CSV Product Export
  Author : Karapuz <support@ka-station.com>

  Version: 3.2 ($Revision: 6 $)

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
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    
      <div id="service_line">
      <table>
        <tr>
          <td><b>Full Version</b>: <?php echo $extension_version; ?>&nbsp;&nbsp;&nbsp;</td>
          <td><b>Author</b>: karapuz&nbsp;&nbsp;&nbsp;</td>
          <td><b>Contact Us</b>: <a href="mailto:support@ka-station.com">via email</a>&nbsp;&nbsp;&nbsp;</td>
          <td><a href="https://www.ka-station.com/index.php?route=information/contact" target="_blank">via secure form at www.ka-station.com</a>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
      </div>
      
      <br />
      There is a direct link to access the export page <a href="<?php echo $export_page; ?>">CSV Product Export</a>.
      <br /><br />
    
      <table class="list">
        <thead> 
          <tr>
            <td class="left">Setting</td>
            <td>Value</td>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td class="left">Script update interval in seconds (5-25)<span class="help">Reduce this value if you experience server connection issues during the export. Default value is 10.</span></td>
            <td class="left">
              <input type="text" name="ka_pe_update_interval" value="<?php echo $ka_pe_update_interval; ?>" />
            </td>
          </tr>

          <tr>
            <td class="left">Provide a direct download link to the generated file</span></td>
            <td class="left">
              <input type="checkbox" name="ka_pe_direct_download" value="Y" <?php if ($ka_pe_direct_download == 'Y') { ?> checked="checked" <?php }; ?> />
            </td>
          </tr>

          <tr>
            <td class="left">Add space before values to prevent automatic conversion in MS Excel on opening</td>
            <td class="left">
              <input type="checkbox" name="ka_pe_prefix_with_space" value="Y" <?php if ($ka_pe_prefix_with_space == 'Y') { ?> checked="checked" <?php }; ?> />
            </td>
          </tr>

          <tr>
            <td class="left">Enable 'product ID' column in the export</td>
            <td class="left">
              <input type="checkbox" name="ka_pe_enable_product_id" value="Y" <?php if ($ka_pe_enable_product_id == 'Y') { ?> checked="checked" <?php }; ?> />
            </td>
          </tr>

          <tr>
            <td class="left">General separator for multiple values in one cell</span></td>
            <td class="left">
              <input type="text" name="ka_pe_general_sep" value="<?php echo $ka_pe_general_sep; ?>" />              
            </td>
          </tr>

          <tr>
            <td class="left">Export all categories in one cell</td>
            <td class="left">
              <input type="checkbox" name="ka_pe_cats_in_one_cell" value="Y" <?php if ($ka_pe_cats_in_one_cell == 'Y') { ?> checked="checked" <?php }; ?> />
            </td>
          </tr>
          
          <tr>
            <td class="left">Export all related products in one cell</td>
            <td class="left">
              <input type="checkbox" name="ka_pe_related_in_one_cell" value="Y" <?php if ($ka_pe_related_in_one_cell == 'Y') { ?> checked="checked" <?php }; ?> />
            </td>
          </tr>

          <tr>
            <td class="left">Export additional images in one cell</td>
            <td class="left">
              <input type="checkbox" name="ka_pe_images_in_one_cell" value="Y" <?php if ($ka_pe_images_in_one_cell == 'Y') { ?> checked="checked" <?php }; ?> />
            </td>
          </tr>
          
          <?php if (empty($is_vqmod_available)) { ?>
            <tr>
              <td class="left" colspan="2">
                <div class="warning">
                VQMod is not found in your store.
                <br /><br />
                You can download VQMod for Opencart at the page:
                <a target="_blank" href="http://code.google.com/p/vqmod/downloads/">
                  http://code.google.com/p/vqmod/downloads/
                </a>
                <br />
                Instructions how to install the mod can be found at:
                <a target="_blank" href="http://code.google.com/p/vqmod/wiki/Install_OpenCart">
                  http://code.google.com/p/vqmod/wiki/Install_OpenCart
                </a>
                </div>
              </td>
            </tr>
          <?php } ?>

        </tbody>
      </table>
    </form>
  </div>
</div>

<script type="text/javascript"><!--

//--></script>

<?php echo $footer; ?>