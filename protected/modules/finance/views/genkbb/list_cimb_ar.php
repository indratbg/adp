

<div class="tableContainer">
	<table class="tableDetailList detailGroup <?php if($active)echo 'active' ?> table-bordered table-condensed">
		<thead>
			<tr>
				<th width="11%">Bank Account Code</th>
				<th width="11%">Bank Account Number</th>
				<th width="17%">Account Name</th>
				<th width="13%">Amount</th>
				<th width="22%">Description</th>
				<th width="5%">Type</th>
				<th width="11%">E-Mail</th>
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
				<td class="bankAcctFmt">
					<?php echo $form->textField($row,'bank_acct_fmt',array('class'=>'span','name'=>'DetailList['.$x.'][bank_acct_fmt]','readonly'=>'readonly')) ?>
				</td>
				<td class="acctName">
					<?php echo $form->textField($row,'acct_name',array('class'=>'span','name'=>'DetailList['.$x.'][acct_name]','readonly'=>'readonly')) ?>
				</td>
				<td class="amount">
					<?php echo $form->textField($row,'curr_amt',array('class'=>'span tnumberdec','name'=>'DetailList['.$x.'][curr_amt]','readonly'=>'readonly')) ?>
				</td>
				<td class="description">
					<?php echo $form->textField($row,'descrip',array('class'=>'span','name'=>'DetailList['.$x.'][descrip]','readonly'=>'readonly')) ?>
				</td>
				<td class="trxType">
					<?php echo $form->textField($row,'trx_type',array('class'=>'span','name'=>'DetailList['.$x.'][trx_type]','readonly'=>'readonly')) ?>
				</td>
				<td class="email">
					<?php echo $form->textField($row,'e_mail',array('class'=>'span','name'=>'DetailList['.$x.'][e_mail]','readonly'=>'readonly')) ?>
				</td>
				<input class="bankAcctFmtCsv" type="hidden" name="DetailList[<?php echo $x ?>][bank_acct_fmt_csv]" value="<?php echo $row->bank_acct_fmt_csv ?>" />
				<input class="bankAcctCdCsv" type="hidden" name="DetailList[<?php echo $x ?>][bank_acct_cd_csv]" value="<?php echo $row->bank_acct_cd_csv ?>" />
				<input class="acctNameCsv" type="hidden" name="DetailList[<?php echo $x ?>][acct_name_csv]" value="<?php echo $row->acct_name_csv ?>" />
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
		
		var footer = table.children('tfoot');
		var footerRow = table.children('tfoot').children('tr:eq(1)');
		
		footerRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		footerRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		footerRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		footerRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		footerRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		footerRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		footerRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
	}
</script>