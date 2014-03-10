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
				
			</div>
		</div>
		<div class="content">
			<table class="list">
				<thead>
					<tr>
						<td class="left">Emails in de wachtrij</td>
						<td class="left">Aantal nieuwsbrieven de wachtrij</td>
						<td class="left">Gepauzeerd</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="left"><?php echo $totalQueued - $pausedQueued; ?></td>
						<td class="left"><?php echo $totalLetterQueued; ?></td>
						<td class="left"><?php echo $pausedQueued; ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table class="list">
				<thead>
					<tr>
						<td class="left">ID</td>
						<td class="left">Van</td>
						<td class="left">Onderwerp</td>
						<td class="left">Verzonden / Maximaal</td>
						<td class="left">Aangemaakt</td>
						<td class="left">Laatst verstuurd</td>
						<td class="left">Gepauzeerd</td>
						<td class="right">Actie</td>
					</tr>
				</thead>
				<tbody>
						<?php
							$paused = array(
								0 => '<span style="color: green;">Nee</span>',
								1 => '<span style="color: red;">Ja</span>'
							);
						
							foreach ($letters as $key => $letter){
								echo '<tr>';
								echo '<td class="left">' . $letter['uid'] . '</td>';
								echo '<td class="left">' . $letter['from'] . '</td>';
								echo '<td class="left">' . $letter['subject'] . '</td>';
								echo '<td class="left">' . $letter['already_send'] . ' / ' . $letter['max_send'] . '</td>';
								echo '<td class="left">' . $letter['created'] . '</td>';
								echo '<td class="left">' . $letter['last_send'] . '</td>';
								echo '<td class="left">' . $paused[$letter['paused']] . '</td>';
								echo '<td class="right">[ <a href="' . $watchLink . '&uid=' . $letter['uid'] . '">' . $watchText . '</a> ] &nbsp;&nbsp; [ <a href="' . $pauseLink . '&uid=' . $letter['uid'] . '">' . $pauseText . '</a> ]</td>';
								echo '</tr>';
							}
						?>
				</tbody>
			</table>
		</div>
	</div>
	
</div>
<?php echo $footer; ?>