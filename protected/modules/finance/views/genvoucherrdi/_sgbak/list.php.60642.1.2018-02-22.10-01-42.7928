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
</style>

<table id="tableVchList" class="table-bordered table-condensed">
	<thead>
		<tr>
			<th width="5%">Brch</th>
			<th width="10%">Client</th>
			<th width="22%">Client Name</th>
			<th width="14%">Balance AR/AP</th>
			<th width="14%">Balance RDI</th>
			<th width="14%">dari RDI ke Bank PE</th>
			<th width="14%">dari Bank PE ke RDI</th>
			<th width="5%">Client Type</th>
			<th width="2%">Rek Dana</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1;
			$totalArap = $totalFromRdi = $totalToRdi = 0;
			foreach($modelVoucherList as $row){ ?>
		<tr>
			<td class="branch">
				<?php echo $form->textField($row,'brch_cd',array('class'=>'span','name'=>'VoucherList['.$x.'][brch_cd]','readonly'=>true)) ?>
			</td>
			<td class="client">
				<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'VoucherList['.$x.'][client_cd]','readonly'=>true)) ?>
			</td>
			<td class="clientName">
				<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'VoucherList['.$x.'][client_name]','readonly'=>true)) ?>
			</td>
			<td class="arapBal">
				<?php echo $form->textField($row,'arap_bal',array('class'=>'span','name'=>'VoucherList['.$x.'][arap_bal]','value'=>$row->debit - $row->credit,'readonly'=>true)) ?>
				<input type="hidden" name="VoucherList[<?php echo $x ?>][debit]" value="<?php echo $row->debit ?>" />
				<input type="hidden" name="VoucherList[<?php echo $x ?>][credit]" value="<?php echo $row->credit ?>" />
			</td>
			<td class="rdiBal">
				<?php echo $form->textField($row,'rdi_bal',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][rdi_bal]','readonly'=>true)) ?>
			</td>
			<td class="fromRdiAmt">
				<?php echo $form->textField($row,'from_rdi_amt',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][from_rdi_amt]','readonly'=>true)) ?>
			</td>
			<td class="toRdiAmt">
				<?php echo $form->textField($row,'to_rdi_amt',array('class'=>'span tnumberdec','name'=>'VoucherList['.$x.'][to_rdi_amt]','readonly'=>true)) ?>
			</td>
			<td class="clientType">
				<?php echo $form->textField($row,'client_type',array('class'=>'span','name'=>'VoucherList['.$x.'][client_type]','readonly'=>true)) ?>
			</td>
			<td class="rdiNum">
				<?php echo $form->textField($row,'rdi_stat',array('class'=>'span','name'=>'VoucherList['.$x.'][rdi_stat]','readonly'=>true)) ?>
			</td>
		</tr>
		<?php 
				$x++;
				$totalArap += $row->debit - $row->credit;
				$totalFromRdi += $row->from_rdi_amt;
				$totalToRdi += $row->to_rdi_amt;
			} 
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" ></td>
			<td>
				<input class="span" type="text" id="totalArap" name="totalArap" readonly value="<?php echo $totalArap ?>" />
			</td>
			<td></td>
			<td>
				<input class="span tnumberdec" type="text" id="totalFromRdi" name="totalFromRdi" readonly value="<?php  echo $totalFromRdi ?>" />
			</td>
			<td>
				<input class="span tnumberdec" type="text" id="totalToRdi" name="totalToRdi" readonly value="<?php  echo $totalToRdi ?>" />
			</td>
			<td colspan="2"></td>
		</tr>
		<tr>
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
	$(document).ready(function()
	{
		$("#tableVchList").children('tbody').children('tr').each(function()
		{
			var container = $(this).children('td.arapBal').children('[type=text]');		
			var arap_bal = container.val();
			
			container.css('text-align','right');
			container.val(setting.func.number.addCommasDec(arap_bal.replace('-','')));
			
			if(arap_bal < 0)container.val( '(' + container.val() + ')' );
			else
				container.val(container.val() + ' ');
		});
		
		arap_bal = $("#totalArap").val();
		
		$("#totalArap").css('text-align','right');
		$("#totalArap").val(setting.func.number.addCommasDec(arap_bal.replace('-','')));
		
		if(arap_bal < 0)$("#totalArap").val( '(' + $("#totalArap").val() + ')' );
		else
			$("#totalArap").val($("#totalArap").val() + ' ');
	});

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
	}
</script>