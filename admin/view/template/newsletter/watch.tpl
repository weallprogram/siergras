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
				<a href="<?php echo $linkBack; ?>" class="button"><span>Annuleren</span></a>
			</div>
		</div>
		<div class="content">
		<?php
			$paused = array(
				0 => '<span style="color: green;">Nee</span>',
				1 => '<span style="color: red;">Ja</span>'
			);
		?>
			<table class="form">
				<tbody>
					<tr>
						<td>Onderwerp: </td>
						<td><?php echo $letterMainInfo['subject']; ?></td>
					</tr>
					<tr>
						<td>Aantal ontvangers: </td>
						<td><?php echo $letterMainInfo['max_send']; ?></td>
					</tr>
					<tr>
						<td>Verzonden: </td>
						<td><?php echo $letterMainInfo['already_send']; ?></td>
					</tr>
					<tr>
						<td>Gepauzeerd: </td>
						<td><?php echo $paused[$letterMainInfo['paused']] ?></td>
					</tr>
					<tr>
						<td>Verzonden vanaf: </td>
						<td><?php echo $letterMainInfo['from']; ?></td>
					</tr>
				</tbody>
			</table>
			<br /><br />
			Inhoud:<br /><br />
			<?php echo html_entity_decode(html_entity_decode($letterMainInfo['content'])); ?>
		</div>
	</div>
	
</div>
<?php echo $footer; ?>