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
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_width; ?></td>
          <td><input name="youtube_embed_width" size="10" value="<?php echo $youtube_embed_width; ?>">px
            <?php if ($error_youtube_embed_width) { ?>
          <td><span class="required">*</span> <?php echo $entry_height; ?></td>
          <td><input name="youtube_embed_height" size="10" value="<?php echo $youtube_embed_height; ?>">px
            <?php if ($error_youtube_embed_height) { ?>
            <span class="error"><?php echo $error_youtube_embed_height; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_category_width; ?></td>
          <td><input name="youtube_embed_category_width" size="10" value="<?php echo $youtube_embed_category_width; ?>">px</td>
          <td><?php echo $entry_category_height; ?></td>
          <td><input name="youtube_embed_category_height" size="10" value="<?php echo $youtube_embed_category_height; ?>">px</td>
        </tr>
        <tr>
          <td><?php echo $entry_information_width; ?></td>
          <td><input name="youtube_embed_information_width" size="10" value="<?php echo $youtube_embed_information_width; ?>">px</td>
          <td><?php echo $entry_information_height; ?></td>
          <td><input name="youtube_embed_information_height" size="10" value="<?php echo $youtube_embed_information_height; ?>">px</td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>