<!-- <iframe src="<?php echo $url; ?>" class="span12" style="min-height:150px;max-width: 100%;"></iframe> -->
<!-- Begin Block -->

<style>
		#tableCSV
	{
		background-color:#C3D9FF;
	}
	#tableCSV thead , #tableCSV tbody
	{
		display:block;
		background-color:red;
	}
	#tableCSV tbody
	{
		max-height:150px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tableCSV thead
	{
		background-color:#FFFFFF;
	}
	
</style>
<br />
<div id="scroll_popup" style="background-color: #white; border: 0px solid 00000; overflow: auto; padding-bottom: -20px; width: 450%;margin-top: -20px;">
<table id="tableCSV" class="table-condensed">
	
	<thead>
		<tr>
			<th width="120px">Report Type</th>
			<th width="40px">Position</th>
			<th width="100px">Securities Id</th>
			<th width="150px">Transaction Type</th>
			<th width="130px">Cp Firm Id</th>
			<th width="100px">Price</th>
			<th width="100px">Yield</th>
			<th width="100px">Volume</th>
			<th width="100px">Trade Date</th>
			<th width="130px">Trade Time</th>
			<th width="40px">Vas</th>
			<th width="140px">Settlement Date</th>
			<th width="200px">Trx Parties Code Deliverer</th>
			<th width="150px">Remarks Deliverer</th>
			<th width="150px">Reference Deliverer</th>
			<th width="150px">Custodian Deliverer</th>
			<th width="200px">Trx Parties Code Receiver</th>
			<th width="150px">Remarks Receiver</th>
			<th width="150px">Reference Receiver</th>
			<th width="150px">Custodian Receiver</th>
			<th width="150px">Second Leg Price</th>
			<th width="150px">Second Leg Yield</th>
			<th width="150px">Second Leg Rate</th>
			<th width="140px">Reverse Date</th>
			<th width="130px">Late Type</th>
			<th width="140px">Late Reason</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($modelDetailCSV as $row){?>
		<tr>
			<td><?php echo $row->report_type ; ?> </td>
			<td><?php echo $row->position ; ?> </td>
			<td><?php echo $row->securities_id ; ?> </td>
			<td><?php echo $row->transaction_type ; ?> </td>
			<td><?php echo $row->cp_firm_id ; ?> </td>
			<td style="text-align: right"><?php echo $row->price ; ?> </td>
			<td style="text-align: right"><?php echo $row->yield ; ?> </td>
			<td style="text-align: right"><?php echo $row->volume ; ?> </td>
			<td><?php echo $row->trade_date ; ?> </td>
			<td><?php echo $row->trade_time ; ?> </td>
			<td><?php echo $row->vas ; ?> </td>
			<td><?php echo $row->settlement_date ; ?> </td>
			<td><?php echo $row->trx_parties_code_deliverer ; ?> </td>
			<td><?php echo $row->remarks_deliverer ; ?> </td>
			<td><?php echo $row->reference_deliverer ; ?> </td>
			<td><?php echo $row->custodian_deliverer ; ?> </td>
			<td><?php echo $row->trx_parties_code_receiver ; ?> </td>
			<td><?php echo $row->remarks_receiver ; ?> </td>
			<td><?php echo $row->reference_receiver ; ?> </td>
			<td><?php echo $row->custodian_receiver ; ?> </td>
			<td><?php echo $row->second_leg_price ; ?> </td>
			<td><?php echo $row->second_leg_yield ; ?> </td>
			<td><?php echo $row->second_leg_rate ; ?> </td>
			<td><?php echo $row->reverse_date ; ?> </td>
			<td><?php echo $row->late_type ; ?> </td>
			<td><?php echo $row->late_reason ; ?> </td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>


<script>

	
	$(window).resize(function() {
		adjustWidthCSV();
	})
	$(window).trigger('resize');
	
	function adjustWidthCSV(){
		
		var header = $("#tableCSV").find('tr:eq(0)');
		var firstRow = $("#tableCSV").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
		firstRow.find('td:eq(10)').css('width',header.find('th:eq(10)').width() + 'px');
		firstRow.find('td:eq(11)').css('width',header.find('th:eq(11)').width() + 'px');
		firstRow.find('td:eq(12)').css('width',header.find('th:eq(12)').width() + 'px');
		firstRow.find('td:eq(13)').css('width',header.find('th:eq(13)').width() + 'px');
		firstRow.find('td:eq(14)').css('width',header.find('th:eq(14)').width() + 'px');
		firstRow.find('td:eq(15)').css('width',header.find('th:eq(15)').width() + 'px');
		firstRow.find('td:eq(16)').css('width',header.find('th:eq(16)').width() + 'px');
		firstRow.find('td:eq(17)').css('width',header.find('th:eq(17)').width() + 'px');
		firstRow.find('td:eq(18)').css('width',header.find('th:eq(18)').width() + 'px');
		firstRow.find('td:eq(19)').css('width',header.find('th:eq(19)').width() + 'px');
		firstRow.find('td:eq(20)').css('width',header.find('th:eq(20)').width() + 'px');
		firstRow.find('td:eq(21)').css('width',header.find('th:eq(21)').width() + 'px');
		firstRow.find('td:eq(22)').css('width',header.find('th:eq(22)').width() + 'px');
		firstRow.find('td:eq(23)').css('width',header.find('th:eq(23)').width() + 'px');
		firstRow.find('td:eq(24)').css('width',header.find('th:eq(24)').width() + 'px');
		firstRow.find('td:eq(25)').css('width',(header.find('th:eq(25)').width())-17 + 'px');
		
		//set width popup
		var width= $(window).width();
		if(width<1000)
		{
			$('#scroll_popup').css('width','3000px');
		}
		else
		{
			$('#scroll_popup').css('width','3500px');
		}
		
	}
</script>