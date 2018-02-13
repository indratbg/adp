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

<table id="tableVchList" class="table-bordered table-condensed">
	<thead>
		<tr>
			<th width="11%">Due Date</th>
			<th width="4%">Branch</th>
			<th width="12%">Client Cd</th>
			<th width="7%">Bank Cd</th>
			<th width="16%">Bank Acct Num</th>
			<th width="16%">Net Buy</th>
			<th width="16%">Net Sell</th>
			<th width="4%">Pembulatan</th>
			<th width="12%">Vch Ref</th>
			<th width="2%" style="text-align:center">
				<input type="checkbox"  id="checkAll"/>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1;
			$total = 0;
			foreach($modelVoucherList as $row){ ?>
		<tr class="first">
			<td class="date">
				<?php echo $form->textField($row,'due_date',array('class'=>'span tdate','name'=>'VoucherList['.$x.'][due_date]','readonly'=>'readonly')) ?>
			</td>
			<td class="branch">
				<?php echo $form->textField($row,'brch_cd',array('class'=>'span','name'=>'VoucherList['.$x.'][brch_cd]','readonly'=>'readonly')) ?>
			</td>
			<td class="client">
				<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'VoucherList['.$x.'][client_cd]','readonly'=>'readonly')) ?>
			</td>
			<td class="bankCd">
				<?php echo $form->textField($row,'bank_cd',array('class'=>'span','name'=>'VoucherList['.$x.'][bank_cd]','readonly'=>'readonly')) ?>
			</td>
			<td class="bankAcct">
				<?php echo $form->textField($row,'bank_acct_num',array('class'=>'span','name'=>'VoucherList['.$x.'][bank_acct_num]','readonly'=>'readonly')) ?>
			</td>
			<td class="netBuy">
				<?php echo $form->textField($row,'net_buy',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][net_buy]','readonly'=>'readonly')) ?>
			</td>
			<td class="netSell">
				<?php echo $form->textField($row,'net_sell',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][net_sell]','readonly'=>'readonly')) ?>
			</td>
			<td class="pembulatan">
				<?php echo $form->textField($row,'pembulatan',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][pembulatan]')) ?>
			</td>
			<td class="vchRef">
				<?php echo $form->textField($row,'vch_ref',array('class'=>'span','name'=>'VoucherList['.$x.'][vch_ref]','disabled'=>$model->client_type=='C'||$model->client_type=='R'&& $row->piutang !=0?true:false)) ?>
			</td>
			<td class="generate">
				<?php echo $form->checkBox($row,'generate',array('value'=>'Y','uncheckValue'=>'N','name'=>'VoucherList['.$x.'][generate]', 'class'=>'generateCheck', 'onChange'=>'countTotal()')) ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="4" class="name">
				<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'VoucherList['.$x.'][client_name]','readonly'=>'readonly')) ?>
			</td>
			<td></td>
			<td style="text-align: right" colspan="2">
			    Piutang sebelum <?php echo date('d M Y'); ?>
			</td>
			
			<td>
			    <?php echo $form->textField($row,'piutang',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][piutang]','readonly'=>'readonly')) ?>
			</td>
			<td></td>
		</tr>
		<?php 
				//$total = $total + $row->net_buy - $row->net_sell;
				$x++;
			} 
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align:right"><b>Total Voucher:</b></td>
			<td id="totalVoucher"><?php //echo count($modelVoucherList) ?></td>
			<td>
				<input class="span tnumberdec" type="text" id="totalBuy" name="totalBuy" readonly value="<?php //if($total > 0)echo $total;else echo 0 ?>" />
			</td>
			<td>
				<input class="span tnumberdec" type="text" id="totalSell" name="totalSell" readonly value="<?php //if($total < 0)echo abs($total);else echo 0 ?>" />
			</td>
			<td colspan="3"></td>
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

<script>
	$(window).resize(function()
	{
		var body = $("#tableVchList").find('tbody');
		
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