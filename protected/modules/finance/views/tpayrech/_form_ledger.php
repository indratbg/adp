<style>
	#tableLedger
	{
		background-color:#C3D9FF;
	}
	#tableLedger thead, #tableLedger tbody, #tableLedger tfoot
	{
		display:block;
	}
	#tableLedger tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tableLedger tfoot
	{
		background-color:#FFFFFF;
		font-style:normal;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
	
	#leftScroll
	{
		width:18px;
		float:left;
		max-height:300px;
		overflow:auto;
	}
</style>

<div id="leftScroll">
	<div id="dummyContent"></div>
</div>
<div style="overflow-x: auto;">
	<div style="width:1400px"> 
		<div id="mainScroll">
			<table id='tableLedger' class='table-bordered table-condensed'>
				<thead>
					<tr>
						<th width="16%">Journal Description</th>
						<th width="10%" colspan="2">Transaction Date</th>
						<th width="10%">Outstanding Amount</th>
						<th width="10%">Debit Settled Amount</th>
						<th width="10%">Credit Settled Amount</th>
						<th width="3%" style="text-align:center">
							<input type="checkbox"  id="checkAll"/>
						</th>
						<th width="8%">Due Date</th>
						<th width="10%">Original Amount</th>
						<th width="6%">GL Account</th>
						<th width="6%">Source</th>
						<th width="10%">Doc Num</th>
					</tr>
				</thead>
				<tbody>
				<?php $x = 1;
					foreach($modelLedger as $row){ 
				?>
					<tr id="row<?php echo $x ?>">
						<td class="remarks">
							<?php echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Tpayrecdledger['.$x.'][remarks]','readonly'=>'readonly')); ?>
						</td>
						<td class="contrDt">
							<?php echo $form->textField($row,'contr_dt',array('class'=>'span tdate','name'=>'Tpayrecdledger['.$x.'][contr_dt]','readonly'=>'readonly')); ?>
						</td>
						<td class="buySellInd">
							<?php echo $form->textField($row,'buy_sell_ind',array('class'=>'span','name'=>'Tpayrecdledger['.$x.'][buy_sell_ind]','readonly'=>'readonly')); ?>
						</td>
						<td class="outsAmt">
							<?php echo $form->textField($row,'outs_amt',array('class'=>'span tnumberdec','name'=>'Tpayrecdledger['.$x.'][outs_amt]','readonly'=>'readonly')); ?>
							<input type="hidden" id="outsAmt_hid" name="Tpayrecdledger[<?php echo $x ?>][old_outs_amt]" value="<?php echo $row->old_outs_amt ?>" />
						</td>
						<td class="buySettAmt">
							<?php echo $form->textField($row,'buy_sett_amt',array('class'=>'span tnumberdec','name'=>'Tpayrecdledger['.$x.'][buy_sett_amt]','readonly'=>($row->buy_sell_ind=='J'||$row->buy_sell_ind=='C')&&$row->check=='Y'?'':'readonly','onChange'=>'checkAmt(this)')); ?>
							<input type="hidden" id="buySettAmt_hid" name="buySettAmt_hid" value="<?php echo $row->buy_sett_amt ?>" />
						</td>
						<td class="sellSettAmt">
							<?php echo $form->textField($row,'sell_sett_amt',array('class'=>'span tnumberdec','name'=>'Tpayrecdledger['.$x.'][sell_sett_amt]','readonly'=>($row->buy_sell_ind=='B'||$row->buy_sell_ind=='D')&&$row->check=='Y'?'':'readonly','onChange'=>'checkAmt(this)')); ?>
							<input type="hidden" id="sellSettAmt_hid" name="sellSettAmt_hid" value="<?php echo $row->sell_sett_amt ?>" />
						</td>
						<td class="check">
							<?php echo $form->checkBox($row,'check',array('value'=>'Y','uncheckValue'=>'N','class'=>'span test','name'=>'Tpayrecdledger['.$x.'][check]','onChange'=>'setAmt(this)')); ?>
							<input type="hidden" id="check_hid" name="check_hid" value="<?php echo $row->check ?>" />
						</td>
						<td class="dueDate">
							<?php echo $form->textField($row,'due_date',array('class'=>'span tdate','name'=>'Tpayrecdledger['.$x.'][due_date]','readonly'=>'readonly')); ?>
						</td>
						<td class="originalAmt">
							<input type="text" value="<?php echo $row->amt_for_curr ?>" class="span tnumberdec" name="Tpayrecdledger[<?php echo $x ?>][amt_for_curr]" readonly />
						</td>
						<td class="glAcct">
							<input type="text" value="<?php echo $row->gl_acct_cd ?>" class="span" readonly />
						</td>
						<td class="recordSource">
							<input type="text" value="<?php echo $row->record_source ?>" class="span" readonly />
						</td>
						<td class="docNum">
							<input type="text" value="<?php echo $row->contr_num ?>" class="span" readonly />
						</td>
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][gl_acct_cd]" value="<?php echo $row->gl_acct_cd ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][sl_acct_cd]" value="<?php echo $row->sl_acct_cd ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][record_source]" value="<?php echo $row->record_source ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][gl_ref_num]" value="<?php echo $row->gl_ref_num ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][contr_num]" value="<?php echo $row->contr_num ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][tal_id]" value="<?php echo $row->tal_id ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][doc_tal_id]" value="<?php echo $row->doc_tal_id ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][ref_folder_cd]" value="<?php echo $row->ref_folder_cd ?>" />
						<input type="hidden" name="Tpayrecdledger[<?php echo $x ?>][brch_cd]" value="<?php echo $row->brch_cd ?>" />
					</tr>
				<?php $x++;} ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" style="text-align:right"><b>Total</b></td>
						<td><input class="span tnumberdec" type="text" id="totalDebit" name="totalDebit" readonly /></td>
						<td><input class="span tnumberdec" type="text" id="totalCredit" name="totalCredit" readonly /></td>
						<td colspan="5"></td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:right"><b>Balance</b></td>
						<td>
							<input class="span tnumberdec" type="text" id="balDebit" name="balDebit" readonly />
							<input type="hidden" id="balDebit_hid" name="balDebit_hid" />
						</td>
						<td>
							<input class="span tnumberdec" type="text" id="balCredit" name="balCredit" readonly />
							<input type="hidden" id="balCredit_hid" name="balCredit_hid" />
						</td>
						<td colspan="5"></td>
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
						<td style="visibility:hidden"></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<input type="hidden" id="ledgerCount" name="ledgerCount"/>

<script>
	var ledgerCount = <?php echo count($modelLedger) ?>;
	var scrollTimeout;
	
	$(document).ready(function()
	{
		$("#leftScroll").css({'margin-top':$("#tableLedger>thead").height()/*, 'height':$("#tableLedger>tbody").css('height')*/});
		$("#dummyContent").height($("#tableLedger>tbody").get(0).scrollHeight);
		
		bindLeftScroll();
		bindMainScroll();
		checkInterest();
	});
		
	function bindLeftScroll()
	{
		$("#leftScroll").scroll(function()
		{
			clearTimeout(scrollTimeout);
			$("#tableLedger>tbody").off('scroll');
			$("#tableLedger>tbody").scrollTop($(this).scrollTop());
			
			scrollTimeout = setTimeout(function()
			{
				bindMainScroll();
			},250);
		});
	}
	
	function bindMainScroll()
	{
		$("#tableLedger>tbody").scroll(function()
		{
			clearTimeout(scrollTimeout);
			$("#leftScroll").off('scroll');
			$("#leftScroll").scrollTop($(this).scrollTop());
			
			scrollTimeout = setTimeout(function()
			{
				bindLeftScroll();
			},250);
		});
	}
	
	function alignColumnLedger()//align columns in thead and tbody
	{
		var header = $("#tableLedger").find('thead');
		var firstRow = $("#tableLedger").find('tbody tr:first');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width()*0.7 + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(1)').width()*0.22 + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(10)').css('width',header.find('th:eq(9)').width() + 'px');
		firstRow.find('td:eq(11)').css('width',header.find('th:eq(10)').width() + 'px');
		
		var footer = $("#tableLedger").find('tfoot');
		var footerRow = $("#tableLedger").find('tfoot tr:eq(2)');
		
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
		footerRow.find('td:eq(10)').css('width',header.find('th:eq(10)').width() + 'px');

			
		/*var footerCol1 = footerRow.find('td:eq(0)').width();
		var footerCol2 = footerRow.find('td:eq(1)').width();
		var footerCol3 = footerRow.find('td:eq(2)').width();
		
		footer.find('tr:not(:first) td:eq(0)').css('width',footerCol1 + 'px');
		footer.find('tr:not(:first) td:eq(1)').css('width',footerCol2 + 'px');
		footer.find('tr:not(:first) td:eq(2)').css('width',footerCol3 + 'px');*/
	}
	
	$("#checkAll").click(function()
	{
		if($(this).is(':checked'))
		{
			$("#tableLedger").children("tbody").children('tr').children('td.check').children("[type=checkbox]").prop('checked',true).change();
		}
		else
		{
			$("#tableLedger").children("tbody").children('tr').children('td.check').children("[type=checkbox]").prop('checked',false).change();
		}
	});
	
	
	function setAmt(obj)
	{
		var vchDate = $("#payrecDate").val();
		var dueDate = $(obj).parent().siblings('td.dueDate').children('[type=text]').val();
		
		var vchDateNum = vchDate.substr(6,4)+vchDate.substr(3,2)+vchDate.substr(0,2);
		var dueDateNum = dueDate.substr(6,4)+dueDate.substr(3,2)+dueDate.substr(0,2);
		
		if(vchDateNum < dueDateNum)
		{
			$(obj).prop('checked',false);
			alert("Voucher date must be after or on the same date as the due date");
			return false;	
		}
		
		var buySellInd = $(obj).parent().siblings('td.buySellInd').children('[type=text]').val();
		var outsAmt = $(obj).parent().siblings('td.outsAmt').children('[type=text]').val();
		
		//04jan2016, settle penuh untuk record source INT
		var record_source = $(obj).parent().siblings('td.recordSource').children('[type=text]').val();
		
		if(buySellInd == 'D' || buySellInd == 'B')
		{
			if($(obj).is(':checked'))$(obj).parent().siblings('td.sellSettAmt').children('[type=text]').val(outsAmt).prop('readonly',false);
			else
			{
					$(obj).parent().siblings('td.sellSettAmt').children('[type=text]').val(0).prop('readonly',true).blur();
			}
			//04jan2016, settle penuh untuk record source INT
			if(record_source =='INT')
			{
					$(obj).parent().siblings('td.sellSettAmt').children('[type=text]').prop('readonly',true).blur();
			}
		}
		else
		{
			if($(obj).is(':checked'))$(obj).parent().siblings('td.buySettAmt').children('[type=text]').val(outsAmt).prop('readonly',false);
			else
			{	
				$(obj).parent().siblings('td.buySettAmt').children('[type=text]').val(0).prop('readonly',true).blur();
			}
			//04jan2016, settle penuh untuk record source INT
			if(record_source =='INT')
			{
					$(obj).parent().siblings('td.buySettAmt').children('[type=text]').prop('readonly',true).blur();
			}
		}
		
		
		
		setTotal();
	}
	
	function checkAmt(obj)
	{
		var amt = setting.func.number.removeCommas($(obj).val());
		var outsAmt = setting.func.number.removeCommas($(obj).parent().siblings('td.outsAmt').children('[type=text]').val());
		
		if(!( (amt * 100) > 0) )
		{
			$(obj).val(0).prop('readonly',true).blur();
			$(obj).parent().siblings('td.check').children('[type=checkbox]').prop('checked',false);
		}
		else if(amt*100 > outsAmt*100)
		{
			//alert(1);
			$(obj).val(outsAmt).blur();
		}
		
		setTotal();
	}
	
	function setTotal()
	{
		var totalDebit = totalCredit = 0;
		$("#tableLedger").children("tbody").children("tr").each(function()
		{
			var debitAmt = Math.round(setting.func.number.removeCommas($(this).children('td.buySettAmt').children('[type=text]').val()) * 100);
			var creditAmt = Math.round(setting.func.number.removeCommas($(this).children('td.sellSettAmt').children('[type=text]').val()) * 100);
			
			totalDebit += parseInt(debitAmt);
			totalCredit += parseInt(creditAmt);
		});
		
		$("#totalDebit").val(totalDebit/100).blur();
		$("#totalCredit").val(totalCredit/100).blur();
		
		var balance;
		
		if(totalDebit > totalCredit)
		{
			balance = totalDebit - totalCredit;	
			$("#balDebit").val(balance/100).blur();	
			$("#balCredit").val(0).blur();
		}
		else
		{
			balance = totalCredit - totalDebit;	
			$("#balCredit").val(balance/100).blur();
			$("#balDebit").val(0).blur();	
		}
	}
	
	//04jan2016 settle semua untuk record source INT
	function checkInterest()
	{
		$("#tableLedger").children("tbody").children("tr").each(function()
		{
			var record_source = $(this).children('td.recordSource').children('[type=text]').val()
			var flg = $(this).children('td.check').children('[type=checkbox]').is(':checked');
			if(flg && record_source == 'INT')
			{
				$(this).children('td.sellSettAmt').children('[type=text]').prop('readonly',true);
				$(this).children('td.buySettAmt').children('[type=text]').prop('readonly',true);
			}
		});
	}
	
</script>