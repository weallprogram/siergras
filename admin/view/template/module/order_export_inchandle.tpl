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
      <div class="buttons">
      	<!-- <a href="#" id="excelLinkButton" style="display:none;" class="button"></a> -->
      	<a onclick="afhandelen();" class="button"><?php echo $handleInc; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="orderTable" class="list">
          <thead>
            <tr>
              	<td class="right"><?php echo $order_num; ?></td>
              	<td class="left"><?php echo $buyer; ?></td>
              	<td class="left"><?php echo $status; ?></td>
              	<td class="right"><?php echo $total; ?></td>
              	<td class="left"><?php echo $order_date; ?></td>
              	<td class="left"><?php echo $order_change; ?></td>
              	<td class="right"><?php echo $succeed; ?></td>
            </tr>
          </thead>
          <tbody id="orderTableBody">
          	<?php          		
				foreach ($orderData as $key => $value) {
					?>
					<tr>
						<td class="right">
							<?php
								echo $value['order_id'];
							?>	
						</td>
						<td class="left">
							<?php
								echo $value['customer'];
							?>	
						</td>
						<td class="left">
							<?php
							echo $value['status'];
							?>	
						</td>
						<td class="right">&euro;
							<?php
								echo number_format((float)$value['total'], 2, '.', '');
							?>	
						</td>
						<td class="left">
							<?php
								echo $value['date_added'];
							?>	
						</td>
						<td class="left">
							<?php
								echo $value['date_modified'];
							?>	
						</td>
						<td class="right">
							<?php
								echo $sucYes;
							?><input type="radio" name="<?php echo $value['order_id']; ?>" class="handleRadio" value="1" checked="checked" />
							
							<?php
								echo $sucNo;
							?><input type="radio" name="<?php echo $value['order_id']; ?>" class="handleRadio" value="0" />
						</td>
					</tr>
					<?php
				}
			?>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<script>
	var handleUrl = "<?php echo $handleUrl; ?>";
	
	function afhandelen(){
		var first = 0;
		var orNumList = "&orNum=";
		var orSucces = "&orSucces=";
		$("input:radio:checked").each(function(){
			if( first != 0){
				orNumList += "_";
				orSucces += "_";
			}else{
				first++;
			}
			orNumList += $(this).attr("name");
		    orSucces += $(this).val();
		});
		orNumList = orNumList.trim();
		handleUrl += orNumList + orSucces;
		console.log("URL: " + handleUrl );
		
		var request = $.ajax({
	        url: handleUrl,
	        type: "get"
	    });
	
	    // callback handler that will be called on success
	    request.done(function (response, textStatus, jqXHR){
	        // log a message to the console
	        // $("#excelLinkButton").text(response);
	        // $("#excelLinkButton").css("display", "inherit");
	        console.log(response);
			if(response == true){
				window.setTimeout('location.reload()', 1000);
			}else{
				alert("Er is iets misgegaan. Neem contact op met de beheerder.");
			}
	    });
	
	    // callback handler that will be called on failure
	    request.fail(function (jqXHR, textStatus, errorThrown){
	        // log the error to the console
	        console.error(
	            "The following error occured: "+
	            textStatus, errorThrown
	        );
	    });
	
	    // callback handler that will be called regardless
	    // if the request failed or succeeded
	    request.always(function () {
			$('body').css('cursor', 'auto');
	    });
	}
</script>
<?php echo $footer; ?>