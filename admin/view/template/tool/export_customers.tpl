<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
   <div class="box">
    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $export; ?>" class="button"><span><?php echo $button_export; ?></span></a></div>
    </div>
    <div class="content">
      <p>Click the "Export" button to export your customers to a CSV file.</p>
    </div>
  </div>
</div>
<?php echo $footer; ?>