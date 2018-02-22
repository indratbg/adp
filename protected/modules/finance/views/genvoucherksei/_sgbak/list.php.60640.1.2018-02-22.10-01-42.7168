<style>
	#tableVchList
	{
		background-color:#C3D9FF;
	}
	#tableVchList thead, #tableVchList tbody, #tableVchList tfoot
	{
		display:block;
	}
	#tableVchList tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tableVchList th, #tableVchList td
	{
		padding:3px;
	}
	#tableVchList tfoot
	{
		background-color:#FFFFFF;
		font-style:normal;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<div id="tableContainer">
	<table id="tableVchList" class="table-bordered table-condensed">
		<thead>
			<tr>
				<th width="4%">Brch</th>
				<th width="9%">Client Cd</th>
				<th width="21%">Client Name</th>
				<th width="2%" style="text-align:center">
					<input type="checkbox"  id="checkAll" <?php if($scenario == 'view')echo 'disabled' ?>/>
				</th>
				<th width="2%">Type</th>
				<th width="12%">KSEI Balance</th>
				<th width="12%">AR/AP</th>
				<th width="12%">Keluar dari KSEI</th>
				<th width="12%">Masuk ke KSEI</th>
				<th width="14%">Sub Rek</th>
			</tr>
		</thead>
		<tbody>
			<?php $x=1;
				$total = 0;
				foreach($modelVoucherList as $row){ ?>
			<tr class="first">
				<td class="branch">
					<?php echo $form->textField($row,'branch_code',array('class'=>'span','name'=>'VoucherList['.$x.'][branch_code]','readonly'=>'readonly')) ?>
				</td>
				<td class="client">
					<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'VoucherList['.$x.'][client_cd]','readonly'=>'readonly')) ?>
				</td>
				<td class="clientName">
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'VoucherList['.$x.'][client_name]','readonly'=>'readonly')) ?>
				</td>
				<td class="generate" style="text-align:center">
					<?php echo $form->checkBox($row,'generate',array('value'=>'Y','uncheckValue'=>'N','name'=>'VoucherList['.$x.'][generate]', 'class'=>'generateCheck', 'onChange'=>'countTotal()','disabled'=>$scenario=='view')) ?>
				</td>
				<td class="clientType">
					<?php echo $form->textField($row,'client_type',array('class'=>'span','name'=>'VoucherList['.$x.'][client_type]','readonly'=>'readonly')) ?>
				</td>
				<td class="kseiBal">
					<?php echo $form->textField($row,'ksei_bal',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][ksei_bal]','readonly'=>'readonly')) ?>
				</td>
				<td class="arapBal">
					<?php echo $form->textField($row,'arap_bal',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][arap_bal]','readonly'=>'readonly')) ?>
				</td>
				<td class="fromKseiAmt">
					<?php echo $form->textField($row,'from_ksei_amt',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][from_ksei_amt]','readonly'=>'readonly')) ?>
				</td>
				<td class="toKseiAmt">
					<?php echo $form->textField($row,'to_ksei_amt',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][to_ksei_amt]','readonly'=>'readonly')) ?>
				</td>
				<td class="subrek">
					<?php echo $form->textField($row,'subrek',array('class'=>'span','name'=>'VoucherList['.$x.'][subrek]','readonly'=>'readonly')) ?>
				</td>
			</tr>
	
			<?php 
					$x++;
				} 
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" style="text-align:right"><b>Total Voucher:</b></td>
				<td id="totalVoucher"></td>
				<td>
					<input class="span tnumberdec" type="text" id="totalKseiBal" name="totalKseiBal" readonly />
				</td>
				<td>
					<input class="span tnumberdec" type="text" id="totalArapBal" name="totalArapBal" readonly />
				</td>
				<td>
					<input class="span tnumberdec" type="text" id="totalFromKsei" name="totalFromKsei" readonly />
				</td>
				<td>
					<input class="span tnumberdec" type="text" id="totalToKsei" name="totalToKsei" readonly />
				</td>
				<td></td>
			</tr>
			<tr>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
				<td style="visibility:hidden"></td>
			</tr>
		</tfoot>
	</table>
</div>

<script>
	$(window).resize(function()
	{
		var body = $("#tableVchList").find('tbody');
		
		$("#tableContainer").offset({left:3});
		$("#tableContainer").css('width',($(window).width()-3));
		
		if(body.length)
		{
			if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
			{
				$('thead').css('width', '100%').css('width', '-=17px');	
			}
			else
			{
				$('thead').css('width', '100%');	
			}
			
			alignColumn();
		}
	});
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableVchList").find('thead');
		var firstRow = $("#tableVchList").find('tbody tr:first');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width()+'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width()+'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width()+'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width()+'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width()+'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width()+'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width()+'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width()+'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width()+'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width()+'px');
		
		var footer = $("#tableVchList").find('tfoot');
		var footerRow = $("#tableVchList").find('tfoot tr:eq(1)');
		
		footerRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		footerRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		footerRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		footerRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		footerRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		footerRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		footerRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		footerRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		footerRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		footerRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
	}
	
	$("#checkAll").click(function()
	{
		if($(this).is(':checked'))
		{
			$("#tableVchList").children("tbody").children('tr').children('td.generate').children("[type=checkbox]").prop('checked',true).change();
		}
		else
		{
			$("#tableVchList").children("tbody").children('tr').children('td.generate').children("[type=checkbox]").prop('checked',false).change();
		}
	});
	
	$(".generateCheck").click(function()
	{
		checkAll();
	});
</script>