<?php
	$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
?>

<div class="detailLedger" id="detailLedger">
	<table id='tableDetailLedger' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="10%">GL Account</th>
				<th width="13%">SL Account</th>
				<th width="18%">Amount</th>
				<th width="9%">Db/Cr</th>
				<th width="30%">Ledger Description</th>
				<th width="3%">
					<a title="add" onclick="addRowDetailLedger()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetailLedger as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->bank_flg == 'Y')echo 'bankRow' ?>">
				<td class="glAcct">
					<?php if($row->system_generated == 'Y'): ?>
						<?php echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($gl_a, 'gl_a', 'GlDescrip'),array('class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','prompt'=>'-Choose-','onChange'=>'filterSlAcct(this)')); ?>
					<?php endif; ?>
				</td>
				<td class="slAcct">
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][sl_acct_cd]','readonly'=>$row->system_generated == 'Y'?'readonly':'')); ?>
				</td>
				<td class="amt">
					<?php echo $form->textField($row,'curr_val',array('class'=>'span tnumberdec','name'=>'Taccountledger['.$x.'][curr_val]','readonly'=>$row->system_generated == 'Y'?'readonly':'','onChange'=>$row->system_generated == 'Y'?'':'adjustBankAmt(this)')); ?>
				</td>
				<td class="dbcr">
					<?php if($row->system_generated == 'Y'): ?>
						<?php echo $form->textField($row,'db_cr_flg',array('class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),array('class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','prompt'=>'-Choose-','required'=>'required','onChange'=>'adjustBankAmt(this)')); ?>
					<?php endif; ?>
				</td>
				<td class="remarks">
					<?php echo $form->textField($row,'ledger_nar',array('class'=>'span','name'=>'Taccountledger['.$x.'][ledger_nar]')); ?>
				</td>
				<td>
					<?php if($row->system_generated != 'Y'): ?>
					<a title="delete" onclick="deleteRowDetailLedger(this)">
						<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
					</a>
					<?php endif; ?>
				</td>
				<input type="hidden" name="Taccountledger[<?php echo $x ?>][system_generated]" value="<?php echo $row->system_generated ?>" />
				<input type="hidden" name="Taccountledger[<?php echo $x ?>][bank_flg]" value="<?php echo $row->bank_flg ?>" />
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	<input type="hidden" id="detailLedgerCount" name="detailLedgerCount"/>
</div>

<script>
	var detailLedgerCount = <?php echo count($modelDetailLedger) ?>;


	function addRowDetailLedger()
	{
		$("#tableDetailLedger").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(detailLedgerCount+1))
    			.append($('<td>')
    				 .attr('class','glAcct')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(detailLedgerCount+1)+'][gl_acct_cd]')
               		 	.change(function()
               		 	{
               		 		filterSlAcct(this)
               		 	})
               		 	.append($('<option>')
               		 		.val('')
               		 		.html('-Choose-')
               		 	)
               		 	<?php 
               		 		foreach($gl_a as $row){ 
               		 	?>
               		 	.append($('<option>')
               		 		.val('<?php echo $row->gl_a ?>')
               		 		.html('<?php echo $row->gl_a. ' - ' .$row->acct_name ?>')
               		 	)		
               		 	<?php 
							} 
						?>
               		)
               	).append($('<td>')
               		 .attr('class','slAcct')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(detailLedgerCount+1)+'][sl_acct_cd]')
               		 	.attr('type','text')
               		 	.change(function()
               		 	{
               		 		$(this).val($(this).val().toUpperCase());
               		 	})
               		 	.autocomplete(
	         			{
	         				source: function (request, response) 
	         				{
						        $.ajax({
						        	'type'		: 'POST',
						        	'url'		: '<?php echo $this->createUrl('getSlAcct'); ?>',
						        	'dataType' 	: 'json',
						        	'data'		:	{
						        						'term': request.term,
						        						'gl_acct_cd' : ''
						        					},
						        	'success'	: 	function (data) 
						        					{
								           				 response(data);
								    				}
								});
						    },
						    /*change: function(event,ui)
					        {
					        	if (ui.item==null)
					            {
						            $(this).val('');
						            //$(this).focus();
					            }
					        },*/
						    minLength: 1,
						    open: function() { 
						        $(this).autocomplete("widget").width(400); 
						    } 
	         			})
               		)
               	).append($('<td>')
               		 .attr('class','amt')
               		 .append($('<input>')
               		 	.attr('class','span tnumberdec')
               		 	.attr('name','Taccountledger['+(detailLedgerCount+1)+'][curr_val]')
               		 	.attr('type','text')
               		 	.val(0)
               		 	.focus(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
               		 		}
               		 	)
               		 	.blur(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.addCommasDec($(this).val()));
               		 		}
               		 	)
               		 	.change(
               		 		function()
               		 		{
               		 			adjustBankAmt(this);
               		 		}
               		 	)
               		 	.blur()
               		)
               	).append($('<td>')
               		 .attr('class','dbcr')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(detailLedgerCount+1)+'][db_cr_flg]')
               		 	.attr('required','required')
               		 	.append($('<option>')
               		 		.val('')
               		 		.html('-Choose-')
               		 	)
               		 	.append($('<option>')
               		 		.val('D')
               		 		.html('DEBIT')
               		 	).append($('<option>')
               		 		.val('C')
               		 		.html('CREDIT')
               		 	)
               		 	.change(
               		 		function()
               		 		{
               		 			adjustBankAmt(this);
               		 		}
               		 	)			
               		)
               	).append($('<td>')
               		 .attr('class','remarks')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(detailLedgerCount+1)+'][ledger_nar]')
               		 	.attr('type','text')
               		 	.attr('maxlength',50)
               		 	.change(function()
               		 	{
               		 		$(this).val($(this).val().toUpperCase());
               		 	})
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRowDetailLedger(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)
               	.append($('<input>')
               		.attr('name','Taccountledger['+(detailLedgerCount+1)+'][system_generated]')
               		.attr('type','hidden')
               		.val('N')
               	)
               	.append($('<input>')
               		.attr('name','Taccountledger['+(detailLedgerCount+1)+'][bank_flg]')
               		.attr('type','hidden')
               		.val('N')
               	)   	
    		);
    	
    	detailLedgerCount++;
    	//reassignId();
    	//$(window).trigger('resize');
	}
	
	
	function deleteRowDetailLedger(obj)
	{
		$(obj).closest('tr').remove();
		detailLedgerCount--;
		reassignIdDetailLedger();
		
		adjustBankAmt();
		//$(window).trigger('resize');
	}
	
	/*
	function adjustBankAmt(obj)
	{
		var row = $(obj).closest('tr');
		var amt = setting.func.number.removeCommas(row.children('td.amt').children('[type=text]').val()) * 100;
		var dbcr = row.children('td.dbcr').children('select').val();
		
		if(amt > 0 && dbcr)
		{
			var bankRow = row.siblings('.bankRow');
			var bankAmt = setting.func.number.removeCommas(bankRow.children('td.amt').children('[type=text]').val()) * 100;
			var bankDbcr = bankRow.children('td.dbcr').children('[type=text]').val().substr(1,0);

			if(dbcr != bankDbcr)
			{
				bankRow.children('td.amt').children('[type=text]').val((amt + bankAmt)/100).blur();
			}
			else
			{
				if(bankAmt > amt)
				{
					bankRow.children('td.amt').children('[type=text]').val((bankAmt - amt)/100).blur();
				}
				else if(bankAmt == amt)
				{
					bankRow.children('td.amt').children('[type=text]').val(0).blur();
					bankRow.children('td.dbcr').children('[type=text]').val('DEBIT');
				}
				else
				{
					bankRow.children('td.amt').children('[type=text]').val((amt - bankAmt)/100).blur();
					bankRow.children('td.dbcr').children('[type=text]').val(bankDbcr=='D'?'CREDIT':'DEBIT');
				}
			}
		}
	}*/
	
	function adjustBankAmt()
	{
		var bankRow = $("#tableDetailLedger").children('tbody').children('tr.bankRow');
		var bankRowIndex = bankRow.index();
		var debitAmt = parseInt( setting.func.number.removeCommas( setting.func.number.addCommasDec($("#balDebit_hid").val()) ).replace('.','') );
		var creditAmt = parseInt( setting.func.number.removeCommas( setting.func.number.addCommasDec($("#balCredit_hid").val()) ).replace('.','') );
		
		var bankAmt = debitAmt + creditAmt;
		var bankDbcr = parseInt( setting.func.number.removeCommas($("#balCredit_hid").val()).replace('.','') ) > 0?'C':'D';
		
		var insertedBalance = 0;
		var finalAmt;
		var length;
		
		$("#tableDetailLedger").children('tbody').children('tr:gt('+bankRowIndex+')').each(function()
		{
			var amt = parseInt( setting.func.number.removeCommas( setting.func.number.addCommasDec($(this).children('td.amt').children('[type=text]').val()) ).replace('.','') );
			var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			
			if(dbcrFlg == 'D')
			{
				insertedBalance += amt;
			}
			else if(dbcrFlg == 'C')
			{
				insertedBalance -= amt;
			}
		});
		
		if(insertedBalance > 0)
		{
			if(bankDbcr == 'C')
			{
				finalAmt = String(insertedBalance + bankAmt);
				length = finalAmt.length;
				
				bankRow.children('td.amt').children('[type=text]').val(finalAmt.substr(0,length-2)+'.'+finalAmt.substr(length-2)).blur();
				bankRow.children('td.dbcr').children('[type=text]').val('CREDIT');
			}
			else
			{
				if(bankAmt > insertedBalance)
				{
					finalAmt = String(bankAmt - insertedBalance);
					length = finalAmt.length;
					
					bankRow.children('td.amt').children('[type=text]').val(finalAmt.substr(0,length-2)+'.'+finalAmt.substr(length-2)).blur();
					bankRow.children('td.dbcr').children('[type=text]').val('DEBIT');
				}
				else if(bankAmt == insertedBalance)
				{
					bankRow.children('td.amt').children('[type=text]').val(0).blur();
					bankRow.children('td.dbcr').children('[type=text]').val('DEBIT');
				}
				else
				{
					finalAmt = String(insertedBalance - bankAmt);
					length = finalAmt.length;
					
					bankRow.children('td.amt').children('[type=text]').val(finalAmt.substr(0,length-2)+'.'+finalAmt.substr(length-2)).blur();
					bankRow.children('td.dbcr').children('[type=text]').val('CREDIT');
				}
			}
		}
		else if(insertedBalance < 0)
		{
			if(bankDbcr == 'D')
			{
				finalAmt = String(Math.abs(insertedBalance) + bankAmt);
				length = finalAmt.length;
				
				bankRow.children('td.amt').children('[type=text]').val(finalAmt.substr(0,length-2)+'.'+finalAmt.substr(length-2)).blur();
				bankRow.children('td.dbcr').children('[type=text]').val('DEBIT');
			}
			else
			{
				if(bankAmt > Math.abs(insertedBalance))
				{
					finalAmt = String(bankAmt - Math.abs(insertedBalance));
					length = finalAmt.length;
					
					bankRow.children('td.amt').children('[type=text]').val(finalAmt.substr(0,length-2)+'.'+finalAmt.substr(length-2)).blur();
					bankRow.children('td.dbcr').children('[type=text]').val('CREDIT');
				}
				else if(bankAmt == insertedBalance)
				{
					bankRow.children('td.amt').children('[type=text]').val(0).blur();
					bankRow.children('td.dbcr').children('[type=text]').val('DEBIT');
				}
				else
				{
					finalAmt = String(Math.abs(insertedBalance) - bankAmt);
					length = finalAmt.length;
					
					bankRow.children('td.amt').children('[type=text]').val(finalAmt.substr(0,length-2)+'.'+finalAmt.substr(length-2)).blur();
					bankRow.children('td.dbcr').children('[type=text]').val('DEBIT');
				}
			}
		}
		else
		{
			finalAmt = String(bankAmt);
			length = finalAmt.length;
			
			bankRow.children('td.amt').children('[type=text]').val(finalAmt.substr(0,length-2)+'.'+finalAmt.substr(length-2)).blur();
			bankRow.children('td.dbcr').children('[type=text]').val(bankDbcr=='D'?'DEBIT':'CREDIT');
		}
		
		if(cheqLedgerCount == 1)
		{
			$("#tableCheqLedger").children('tbody').children('tr:first').children('td.chqAmt').children('[type=text]').val(bankRow.children('td.amt').children('[type=text]').val()).change().blur();
			$("#tableCheqLedger").children('tbody').children('tr:first').children('td.edit').children('[type=checkbox]').prop('checked',true).change();
		}
	}
	
		
	function reassignIdDetailLedger()
	{
		var x = 1;
		$("#tableDetailLedger").children("tbody").children("tr").each(function()
		{
			$(this).children("td.glAcct").children("select").attr("name","Taccountledger["+x+"][gl_acct_cd]");
			$(this).children("td.slAcct").children("[type=text]").attr("name","Taccountledger["+x+"][sl_acct_cd]");
			$(this).children("td.amt").children("[type=text]").attr("name","Taccountledger["+x+"][curr_val]");
			$(this).children("td.dbcr").children("select").attr("name","Taccountledger["+x+"][db_cr_flg]");
			$(this).children("td.remarks").children("[type=text]").attr("name","Taccountledger["+x+"][ledger_nar]");
			$(this).children("[type=hidden]:eq(0)").attr("name","Taccountledger["+x+"][system_generated]");
			$(this).children("[type=hidden]:eq(1)").attr("name","Taccountledger["+x+"][bank_flg]");
			x++;
		});
	}
	
	function filterSlAcct(obj)
	{
		var glAcctCd = $(obj).val();
		var result = [];
				
		$(obj).parent().next().children("[type=text]").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getSlAcct'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'gl_acct_cd' : glAcctCd
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				           				 result = data;
				    				}
				});
		    },
		    /*change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	
		            if(!match)
		            {
		            	alert("SL Account not found in chart of accounts");
		            	$(this).val('');
		            }
		            
		            //$(this).focus();
	            }
	        },*/
		    minLength: 1
		});
	}
</script>
