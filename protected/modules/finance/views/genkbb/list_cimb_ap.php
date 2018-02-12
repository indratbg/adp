

<div class="tableContainer">
	<table class="tableDetailList detailGroup <?php if($active)echo 'active' ?> table-bordered table-condensed">
		<thead>
			<tr>
				<th width="11%">Bank Account Code</th>
				<th width="20%">Bank Name</th>
				<th width="4%">Currency</th>
				<th width="13%">Amount</th>
				<th width="22%">Description</th>
				<th width="3%">Count</th>
				<th width="7%">Tanggal</th>
				<th width="13%">E-Mail</th>
			</tr>
		</thead>
		<tbody>
			<?php $x=1;
				$total = 0;
				foreach($modelDetailList as $row){ ?>
			<tr>
				<td class="bankAcctCd">
					<?php echo $form->textField($row,'bank_acct_cd',array('class'=>'span','name'=>'DetailList['.$x.'][bank_acct_cd]','readonly'=>'readonly')) ?>
				</td>
				<td class="bankName">
					<?php echo $form->textField($row,'bank_name',array('class'=>'span','name'=>'DetailList['.$x.'][bank_name]','readonly'=>'readonly')) ?>
				</td>
				<td class="currency">
					<?php echo $form->textField($row,'currency',array('class'=>'span','name'=>'DetailList['.$x.'][currency]','readonly'=>'readonly')) ?>
				</td>
				<td class="amount">
					<?php echo $form->textField($row,'curr_amt',array('class'=>'span tnumberdec','name'=>'DetailList['.$x.'][curr_amt]','readonly'=>'readonly')) ?>
				</td>
				<td class="description">
					<?php echo $form->textField($row,'descrip',array('class'=>'span','name'=>'DetailList['.$x.'][descrip]','readonly'=>'readonly')) ?>
				</td>
				<td class="count">
					<?php echo $form->textField($row,'cnt',array('class'=>'span','name'=>'DetailList['.$x.'][cnt]','readonly'=>'readonly')) ?>
				</td>
				<td class="tanggal">
					<?php echo $form->textField($row,'tanggal',array('class'=>'span tdate','name'=>'DetailList['.$x.'][tanggal]','readonly'=>'readonly')) ?>
				</td>
				<td class="email">
					<?php echo $form->textField($row,'e_mail',array('class'=>'span','name'=>'DetailList['.$x.'][e_mail]','readonly'=>'readonly')) ?>
				</td>
				<input class="bankAcctCdCsv" type="hidden" name="DetailList[<?php echo $x ?>][bank_acct_cd_csv]" value="<?php echo $row->bank_acct_cd_csv ?>" />
				<input class="bankNameCsv" type="hidden" name="DetailList[<?php echo $x ?>][bank_name_csv]" value="<?php echo $row->bank_name_csv ?>" />
			</tr>
	
			<?php 
					$x++;
					$total+=$row->trans_amount;
				} 
			?>
		</tbody>
		<!--
		<tfoot>
			<tr>
				<td colspan="2" style="text-align:right"><b>Total</b></td>
				<td id="totalTransAmount">
					<input class="span tnumberdec" type="text" value="<?php echo $total ?>" readonly/> 
				</td>
				<td colspan="7"></td>
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
		-->
	</table>
</div>

<script>
	function alignColumn()//align columns in thead and tbody
	{		
		var table = $("#detail_div").children("div.tabMenu.active").children("div.tab-content").children("div.active").children("div.tableContainer").children("table.active");
		var header = table.children('thead');
		var firstRow = table.children('tbody').children('tr:first');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width()+'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width()+'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width()+'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width()+'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width()+'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width()+'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width()+'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width()+'px');
		
		var footer = table.children('tfoot');
		var footerRow = table.children('tfoot').children('tr:eq(1)');
		
		footerRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		footerRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		footerRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		footerRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		footerRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		footerRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		footerRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		footerRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
	}
</script>