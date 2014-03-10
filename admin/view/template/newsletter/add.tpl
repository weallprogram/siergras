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
	<?php if (isset($success) && $success) { ?>
		<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/ne/stats.png" alt="" width="22" height="22" /> <?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a href="<?php echo $cancelLink; ?>" class="button">Annuleren</a>
			</div>
		</div>
		<div class="content">
			
		</div>
	</div>
</div>
<?php echo $footer; ?>