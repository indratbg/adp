

<div class="tableContainer">
	<table class="tableDetailList detailGroup <?php if($active)echo 'active' ?> table-bordered table-condensed">
		<thead>
			<tr>
				<th width="20%">Name</th>
				<th width="9%">Trans Date</th>
				<th width="13%">Trans Amount</th>
				<th width="11%">Acc No</th>
				<th width="5%">Bank</th>
				<th width="7%">Bi Code</th>
				<th width="8%">Bank Branch</th>
				<th width="11%">Remark 1</th>
				<th width="11%">Remark 2</th>
				<th width="5%">Jenis</th>
			</tr>
		</thead>
		<tbody>
			<?php $x=1;
				$total = 0;
				foreach($modelDetailList as $row){ ?>
			<tr>
				<td class="acctName">
					<?php echo $form->textField($row,'acct_name',array('class'=>'span','name'=>'DetailList['.$x.'][acct_name]','readonly'=>'readonly')) ?>
				</td>
				<td class="transDate">
					<?php echo $form->textField($row,'trans_date',array('class'=>'span tdate','name'=>'DetailList['.$x.'][trans_date]','readonly'=>'readonly')) ?>
				</td>
				<td class="transAmount">
					<?php echo $form->textField($row,'trans_amount',array('class'=>'span tnumberdec','name'=>'DetailList['.$x.'][trans_amount]','readonly'=>'readonly')) ?>
				</td>
				<td class="bankAcctNum">
					<?php echo $form->textField($row,'bank_acct_num',array('class'=>'span','name'=>'DetailList['.$x.'][bank_acct_num]','readonly'=>'readonly')) ?>
				</td>
				<td class="bankCd">
					<?php echo $form->textField($row,'bank_cd',array('class'=>'span','name'=>'DetailList['.$x.'][bank_cd]','readonly'=>'readonly')) ?>
				</td>
				<td class="biCode">
					<?php echo $form->textField($row,'bi_code',array('class'=>'span','name'=>'DetailList['.$x.'][bi_code]','readonly'=>'readonly')) ?>
				</td>
				<td class="bankBranchName">
					<?php echo $form->textField($row,'bank_branch_name',array('class'=>'span','name'=>'DetailList['.$x.'][bank_branch_name]','readonly'=>'readonly')) ?>
				</td>
				<td class="remark1">
					<?php echo $form->textField($row,'remark_1',array('class'=>'span','name'=>'DetailList['.$x.'][remark_1]','readonly'=>'readonly')) ?>
				</td>
				<td class="remark2">
					<?php echo $form->textField($row,'remark_2',array('class'=>'span','name'=>'DetailList['.$x.'][remark_2]','readonly'=>'readonly')) ?>
				</td>
				<td class="jenis">
					<?php echo $form->textField($row,'jenis',array('class'=>'span','name'=>'DetailList['.$x.'][jenis]','readonly'=>'readonly')) ?>
				</td>
				<input class="trfId" type="hidden" name="DetailList[<?php echo $x ?>][trf_id]" value="<?php echo $row->trf_id ?>" />
				<input class="customerType" type="hidden" name="DetailList[<?php echo $x ?>][customer_type]" value="<?php echo $row->customer_type ?>" />
				<input class="customerResidence" type="hidden" name="DetailList[<?php echo $x ?>][customer_residence]" value="<?php echo $row->customer_residence ?>" />
				<input class="payrecNum" type="hidden" name="DetailList[<?php echo $x ?>][payrec_num]" value="<?php echo $row->payrec_num ?>" />
			</tr>
	
			<?php 
					$x++;
					$total+=$row->trans_amount;
				} 
			?>
		</tbody>
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
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width()+'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width()+'px');
		
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
		footerRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		footerRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
	}
</script>