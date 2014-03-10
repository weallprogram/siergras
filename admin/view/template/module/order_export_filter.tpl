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