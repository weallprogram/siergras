<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if (isset($error_warning) && $error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/order.png" alt="" width="22" height="22" /> <?php echo $heading_title; ?></h1>
        </div>
        <div class="content">
			<?php if (isset($succes_message) && $succes_message) { ?>
				<div class="success"><?php echo $succes_message; ?></div>
			<?php } ?>
		</div>
    </div>
</div>
<?php echo $footer; ?>
