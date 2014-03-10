<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by DmitryNek
// exmail.Nek@gmail.com
//-----------------------------------------------------
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
			<h1><img src="view/image/ne/templates.png" alt="" width="22" height="22" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="location = '<?php echo $refresh; ?>';" class="button"><span><?php echo $button_check; ?></span></a></div>
		</div>
		<div class="content">
			<h2 style="text-align:center;">Deze email adressen zijn dubbel gevonden ( dus als gebruiker en in 1 of meerdere oude lijsten ):</h2>
			
			<table class="list">
				<tbody>
					<tr class="filter">
						<td class="right" style="padding:10px;">Verwijderen</td>
						<td class="left">Email</td>
						<td class="left">Oude lijst</td>
					</tr>
          			<?php
						$catName = array(1 => "Oude lijst Brian", 2 => "Oude lijst Dunamis", 3 => "Oude lijst Frohlich", 4 => "Oude lijst Gaithers", 5 => "Oude lijst Gospel7", 6 => "Oude lijst Lifeshop", 7 => "Oude lijst Meyer", 8 => "Oude lijst Opwekking", 9 => "Oude lijst Perlgim Kerken", 10 => "Oude lijst Pelgrim Klanten", 11 => "Oude lijst Pelgrim Pers", 12 => "Oude lijst Pelgrim Scholen", 13 => "Oude lijsten test");

						foreach ($doubleEmails as $key => $value) {
							?>
							<tr>
								<td class="right">
									<a href="<?php echo $deleteLink; ?>&uid=<?php echo $value['uid']; ?>" >
										<img src="http://wpmu.org/wp-content/uploads/2012/08/delete-big.jpg" width="50px" />
									</a>
								</td>
								<td class="left"><?php echo $value['email'];?></td>
								<td class="left"><?php echo $catName[$value['cat_uid']];?></td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php echo $footer; ?>