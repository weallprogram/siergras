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
      	<a onclick="exportToExcel();" class="button"><?php echo $exportToExcel; ?></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="orderTable" class="list">
          <thead>
            <tr>
            	<td class=""><input type="checkbox" onclick="selectAll();" /></td>
              	<td class="right"><?php echo $order_num; ?></td>
              	<td class="left"><?php echo $buyer; ?></td>
              	<td class="left"><?php echo $status; ?></td>
              	<td class="right"><?php echo $total; ?></td>
              	<td class="left"><?php echo $order_date; ?></td>
              	<td class="left"><?php echo $order_change; ?></td>
              	<td class="right"><?php echo $action; ?></td>
            </tr>
          </thead>
          <tbody id="orderTableBody">
          	<tr class="filter">
            	<td>
            		
            	</td>
            	<td class="right" style="padding-left: 10px;padding-right: 10px;">
            		<div class="buttons"><a onclick='filterChangeOrderNumber();' class="button" id="button_filterOrderNum"><?php echo $button_filter; ?></a></div>
            		<div id="filter_RangeOrderNumber" style="display: none;">
            			<input type="text" id="amountOrderId" style="border: 0; color: #f6931f; font-weight: bold; background: #E7EFEF; width: 45px;" readonly="readonly" />
            			<div id="sliderRangeOrderNumber"></div>
            		</div>
            	</td>
            	<td class="left">
            		<div class="buttons"><a onclick='filterChangeCustomerName();' class="button" id="button_filterCustomerName"><?php echo $button_filter; ?></a></div>
            		<div id="filter_CustomerName" style="display: none; padding-top: 10px;">
            			<input type="text" id="CustomerName" />
            		</div>
            	</td>
            	<td class="left">
            		<div class="buttons"><a onclick='filterChangeorderStatus();' class="button" id="button_filterorderStatus"><?php echo $button_filter; ?></a></div>
            		<div id="filter_orderStatus" style="display: none; padding-top: 10px;">
	            		<select name="filter_orderStatus" id="filter_orderStatusSelect">
	            			<option value="*"></option>
	            			<?php
	            				foreach ($orderStatusen as $key => $value) {
									echo '<option value="' . $value['order_status_id'] . '"';
									if( $value['order_status_id'] == 107){
										echo ' selected="selected" ';
									}
									echo '>';
									echo $value['name'];
									echo "</option>";
								}
	            			?>
	            		</select>
	            	</div>
            	</td>
            	<td class="right" style="padding-left: 10px;padding-right: 10px;">
            		<div class="buttons"><a onclick='filterChangeamountTotal();' class="button" id="button_filteramountTotal"><?php echo $button_filter; ?></a></div>
            		<div id="filter_amountTotal" style="display: none; padding-top: 10px;">
            			<input type="text" id="amountTotal" style="border: 0; color: #f6931f; font-weight: bold;" />
            			<div id="sliderRangeOrderTotal"></div>
            		</div>
            	</td>
            	<td class="left">
            		<div class="buttons"><a onclick='filterChangeStartDate();' class="button" id="button_filterStartDate"><?php echo $button_filter; ?></a></div>
            		<div id="filter_StartDate" style="display: none; padding-top: 10px;">
            			<label for="startStartDate">Begin:</label>
            			<input type="text" id="startStartDate" />
            			<br />
            			<label for="startEndDate">Eind:</label>&nbsp;&nbsp;
            			<input type="text" id="startEndDate" />
            		</div>
            	</td>
            	<td class="left">
            		<div class="buttons"><a onclick='filterChangeEditDate();' class="button" id="button_filterEditDate"><?php echo $button_filter; ?></a></div>
            		<div id="filter_EditDate" style="display: none; padding-top: 10px;">
            			<label for="editStartDate">Begin:</label>
            			<input type="text" id="editStartDate" />
            			<br />
            			<label for="editEndDate">Eind:</label>&nbsp;&nbsp;
            			<input type="text" id="editEndDate" />
            		</div>
            	</td>
            	<td class="right">
            		<div class="buttons"><a onclick="applyFilters();" class="button"><?php echo $button_apply_filters; ?></a></div>
            	</td>
            </tr>
          	<?php          		
				foreach ($orderData as $key => $value) {
					?>
					<tr>
						<td class="">
							<input type="checkbox" name="orderSelect" value="<?php echo $value['order_id']; ?>" />
						</td>
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
	var button_filter = "<?php echo $button_filter; ?>";
	var button_apply_filter = "<?php echo $apply; ?>";
	var button_apply_filters = "<?php echo $button_apply_filters; ?>";
	var allSelected = 0;
	var showOrderNumFilter = 0;
	
	function selectAll() {
		if (allSelected == 0) {
			$("form#form INPUT[@name=orderSelect][type='checkbox']").attr('checked', true);
			allSelected = 1;
		} else {
			$("form#form INPUT[@name=orderSelect][type='checkbox']").attr('checked', false);
			allSelected = 0;
		}
	}
	
	// FILTER CHANGERS
	function filterChangeOrderNumber(){
		$("#filter_RangeOrderNumber").toggle();
		$("#button_filterOrderNum").text(function(i, text){
			return text === button_filter ? button_apply_filter : button_filter;
      	});
      	
      	if($("#button_filterOrderNum").text() === button_filter){
      		applyFilters();
      	}
	}
	
	function filterChangeCustomerName(){
		$("#filter_CustomerName").toggle();
		$("#button_filterCustomerName").text(function(i, text){
			return text === button_filter ? button_apply_filter : button_filter;
      	});
      	
      	if($("#button_filterCustomerName").text() === button_filter){
      		applyFilters();
      	}
	}
	
	function filterChangeorderStatus(){
		$("#filter_orderStatus").toggle();
		$("#button_filterorderStatus").text(function(i, text){
			return text === button_filter ? button_apply_filter : button_filter;
      	});
      	
      	if($("#button_filterorderStatus").text() === button_filter){
      		applyFilters();
      	}
	}
	
	function filterChangeamountTotal(){
		$("#filter_amountTotal").toggle();
		$("#button_filteramountTotal").text(function(i, text){
			return text === button_filter ? button_apply_filter : button_filter;
      	});
      	
      	if($("#button_filteramountTotal").text() === button_filter){
      		applyFilters();
      	}
	}
	
	function filterChangeStartDate(){
		$("#filter_StartDate").toggle();
		$("#button_filterStartDate").text(function(i, text){
			return text === button_filter ? button_apply_filter : button_filter;
      	});
      	
      	if($("#button_filterStartDate").text() === button_filter){
      		applyFilters();
      	}
	}
	
	function filterChangeEditDate(){
		$("#filter_EditDate").toggle();
		$("#button_filterEditDate").text(function(i, text){
			return text === button_filter ? button_apply_filter : button_filter;
      	});
      	
      	if($("#button_filterEditDate").text() === button_filter){
      		applyFilters();
      	}
	}
	

	// SLIDERS
	$(function() {
		$( "#sliderRangeOrderNumber" ).slider({
			range: true,
	      	min: <?php echo ((int)$minOrderId['order_id'] - 1); ?>,
	      	max: <?php echo ((int)$maxOrderId['order_id'] + 1); ?>,
	      	values: [ <?php echo ((int)$minOrderId['order_id'] - 1); ?>, <?php echo ((int)$maxOrderId['order_id'] + 1); ?> ],
	      	slide: function( event, ui ) {
				$( "#amountOrderId" ).val( "" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
	      	}
		});
	    $( "#amountOrderId" ).val( "" + $( "#sliderRangeOrderNumber" ).slider( "values", 0 ) + "-" + $( "#sliderRangeOrderNumber" ).slider( "values", 1 ) );
	    
	    $( "#sliderRangeOrderTotal" ).slider({
	    	range: true,
		  	min: <?php echo ((int)$minOrderTotal['total'] - 1); ?>,
	      	max: <?php echo ((int)$maxOrderTotal['total'] + 1); ?>,
	      	values: [ <?php echo ((int)$minOrderTotal['total'] - 1); ?>, <?php echo ((int)$maxOrderTotal['total'] + 1); ?> ],
	      	slide: function( event, ui ) {
				$( "#amountTotal" ).val( "" + ui.values[ 0 ] + "-" + ui.values[ 1 ] );
	      	}
		});
	    $( "#amountTotal" ).val( "" + $( "#sliderRangeOrderTotal" ).slider( "values", 0 ) + "-" + $( "#sliderRangeOrderTotal" ).slider( "values", 1 ) );
	});
	
	// DATETIME
	
	$(function(){
		// Order Datum
		$('#startStartDate').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'HH:mm:ss'
		});
		$('#startEndDate').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'HH:mm:ss'
		});
		
		// Edit datum
		$('#editStartDate').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'HH:mm:ss'
		});
		$('#editEndDate').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'HH:mm:ss'
		});
	});
	
	// FILTERS APPLYER
	var filterURL = "<?php echo $filterUrl; ?>";
	
	function applyFilters(){
		$('body').css('cursor', 'progress');
		orNum = $("#amountOrderId").val();
		name = $("#CustomerName").val();
		status = $('#filter_orderStatusSelect :selected').val();
		total = $("#amountTotal").val();
		startStartDate = underSpace( $("#startStartDate").val() );
		startEndDate = underSpace( $("#startEndDate").val() );
		editStartDate = underSpace( $("#editStartDate").val() );
		editEndDate = underSpace( $("#editEndDate").val() );
		
		var linkUrl = filterURL + "&orNum=" + orNum + "&name=" + name + "&status=" + status + "&total=" + total + "&startStartDate=" + startStartDate + "&startEndDate=" + startEndDate + "&editStartDate=" + editStartDate + "&editEndDate=" + editEndDate;

		var request = $.ajax({
	        url: linkUrl,
	        type: "get"
	    });
	
	    // callback handler that will be called on success
	    request.done(function (response, textStatus, jqXHR){
	        // log a message to the console
	        $("#orderTable").find("tr:gt(1)").remove();
	        $("#orderTableBody").append(response);
	        console.log(response);
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
	
	function underSpace(value){
	  return value.replace(" ", '_');
	}
	
	// Export
	var exportUrl = "<?php echo $exportUrl; ?>";
	var rootNewFile = "<?php $_SERVER['SERVER_NAME']; ?>/admin/";
	function exportToExcel(){
		$('body').css('cursor', 'progress');
		var first = 0;
		exportUrl += "&orNum=";
		var orNumList = "";
		$("input:checkbox[name=orderSelect]:checked").each(function(){
			if( first != 0){
				orNumList += "_"
			}else{
				first++;
			}
		    orNumList += $(this).val();
		});
		orNumList = orNumList.trim();
		exportUrl += orNumList;
		
		var request = $.ajax({
	        url: exportUrl,
	        type: "get"
	    });
	
	    // callback handler that will be called on success
	    request.done(function (response, textStatus, jqXHR){
	        // log a message to the console
	        // $("#excelLinkButton").text(response);
	        // $("#excelLinkButton").css("display", "inherit");
	        window.open(response,'_blank', 'width=600,height=300');
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
			applyFilters();
	    });
	}
	
	// MENU FIX
	$(function(){
		$("#im_ex_header").addClass("selected");
	});
</script>
<?php echo $footer; ?>