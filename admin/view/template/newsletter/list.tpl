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
				<a href="<?php echo $addLik; ?>" class="button">Voeg email adres toe</a>
			</div>
		</div>
		<div class="content">
			<table class="list">
				<thead>
					<tr>
						<td class="left">ID</td>
						<td class="left">Email</td>
						<td class="left">Categorie</td>
						<td class="right">Actie</td>
					</tr>
				</thead>
				<tbody>
					<tr class="filter">
						<td><input type="number" id="filter_id" /> </td>
						<td><input type="email" id="filter_email" /> </td>
						<td>
							<select id="filter_cat">
								<option value=""></option>
								<option value="1">Brain</option>
								<option value="2">Dunamis</option>
								<option value="3">Frohlich</option>
								<option value="4">Gaithers</option>
								<option value="5">Gospel7</option>
								<option value="6">Lifeshop</option>
								<option value="8">Meyer</option>
								<option value="7">Opwekking</option>
								<option value="9">Pelgrim kerken</option>
								<option value="10">Pelgrim klanten</option>
								<option value="11">Pelgrim pers</option>
								<option value="12">Pelgrim scholen</option>
								<option value="13">Oude test lijst</option>
								<option value="14">shop.bright.fm</option>
							</select>
						</td>
						<td class="right">
							<a onClick="doFilter();" class="button" >Filter</a>
						</td>
					</tr>
					<?php
						foreach ($subscribers as $key => $email){
							echo "<tr>";
							echo '<td class="left">' . $email['uid'] . '</td>';
							echo '<td class="left">' . $email['email'] . '</td>';
							echo '<td class="left">' . $email['name'] . '</td>';
							echo '<td class="right"><a onClick="deleteUser(' . $email['uid'] . ');">[ Verwijderen ]</a></td>';
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="pagination">
			<div class="links">
				<?php
					$totalPages = ((int)$totalUsers['COUNT(*)'] / 1000);
					$page_min = 0;
					$page_max = 1000;
					$page_counter = 1;
					for ($i=0; $i < $totalPages; $i++) {
						 if($lim_start >= $page_min && $lim_start < $page_max){
							echo "<b>" . $page_counter . "</b>";
						 }else{
							echo '<a href="' . $imex_page_url . '&lim_start=' . $page_min . '" >' . $page_counter . '</a>';
						 }
						 $page_counter++;
						 $page_min += 1000;
						 $page_max += 1000;
					}
				?>
			</div>
		</div>
	</div>
</div>
<script>

var rederictUrl = "<?php echo html_entity_decode(trim($redirFilterUrl)); ?>";

function doFilter(){
	var newUrl = rederictUrl + "&filter=1";
	if($('#filter_id').val().trim() != ""){
		newUrl += "&filter_id=" + $('#filter_id').val().trim();
	}
	
	if($('#filter_email').val().trim() != ""){
		newUrl += "&filter_email=" + $('#filter_email').val().trim();
	}
	
	if($('#filter_cat').val().trim() != ""){
		newUrl += "&filter_cat=" + $('#filter_cat').val().trim();
	}
	
	window.location.href = newUrl;
}

function deleteUser(uid){
	var url = "index.php?route=newsletter/list&token=<?php echo $this -> session -> data['token']; ?>&del=1&uid=" + uid;
	url = url.replace(/&amp;/g, '&');
	console.log(url);
	var jqxhr = $.ajax(url).done(function(data) {
			 location.reload();
			 // console.log(data);
		})
}

</script>

<?php echo $footer; ?>