
	
	<?php
	$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
?>		
<!----Ledger Detail--->
<table id='tableDetailLedger' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="10%">GL Account</th>
				<th width="13%">SL Account</th>
				<th width="18%">Amount</th>
				<th width="9%">Db/Cr</th>
				<th width="33%">Journal Description</th>
				
				<th width="3%">
					<a title="add" style="cursor: pointer" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
			
		<?php $x = 1;
			foreach($modeldetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
					<td class="glAcct">
					<?php if($x == 1): ?>
						<?php echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($gl_a, 'gl_a', 'glDescrip'),array('class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','prompt'=>'-Choose-','onChange'=>'filterSlAcct(this)')); ?>
					<?php endif; ?>
				</td>
				<td class="slAcct">
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][sl_acct_cd]','readonly'=>$x==1?'readonly':'')); ?>
				</td>
				<td class="amt">
					<?php echo $form->textField($row,'curr_val',array('onchange'=>'checkBalance()','style'=>'text-align:right;','class'=>'span tnumberdec','name'=>'Taccountledger['.$x.'][curr_val]','readonly'=>$x==1?'readonly':'')); ?>
				</td>
				<td class="dbcr">
					<?php if($x == 1): ?>
						<?php echo $form->textField($row,'db_cr_flg',array('class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','readonly'=>'readonly')); ?>
					<?php else: ?>
					<?php echo $form->dropDownList($row,'db_cr_flg',array('C'=>'CREDIT','D'=>'DEBIT'),array('onchange'=>'checkBalance()','class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','prompt'=>'-Choose-','required'=>true)) ;?>
					<?php endif; ?>
				</td>
				<td class="remarks">
					<?php echo $form->textField($row,'ledger_nar',array('onchange'=>'checkBalance()','class'=>'span','name'=>'Taccountledger['.$x.'][ledger_nar]')); ?>
				</td>
				<td>
					<?php if($x > 2): ?>
					<a title="delete" onclick="deleteRow(this)" style="cursor: pointer">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
					</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	
	<script>
	checkBalance();
		function checkBalance()
	{
		var balance = 0;
		var debit =0;
		var credit =0;
		var x=0;
		$("#tableDetailLedger").children('tbody').children('tr').each(function()
		{
			//var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			// var curr_amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			 
			var amt = parseInt(setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val().replace('.','')));
			 var curr_amt = parseInt(setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val().replace('.','')));
			
			
			$(this).children('td.remarks').children('[type=text]').val($(this).children('td.remarks').children('[type=text]').val().toUpperCase());
			
			
			if(x==0)
			{
				var dbcrFlg = $(this).children('td.dbcr').children('[type=text]').val()=='DEBIT'?'D':'C';
			}
			else
			{
				var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			}
			
			/*
			if(dbcrFlg){
				
				$(this).children('td.dbcr').children('select').children('option:not(:selected)').prop('disabled',true);
			}
			*/
			
			if(dbcrFlg == 'D' )
			{
				balance += amt;
				debit += curr_amt;
			}
			else if(dbcrFlg == 'C' )
			{
				balance -= amt;
				credit -=curr_amt;
			}
			else
			{
				return false;
			}
			x++;
			//alert(balance);			
		
		});
		balance=balance/100;
		credit=credit/100;
		debit=debit/100;
		$('#balance').val(balance);
		$('#credit').val(setting.func.number.addCommasDec(credit));
		$('#debit').val(setting.func.number.addCommasDec(debit));
		
	}
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignId();
		//$(window).trigger('resize');
	}
	function addRow()
	{
		$("#tableDetailLedger").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(rowCount+1))
    			.append($('<td>')
    				 .attr('class','glAcct')
               		 .append($('<select>')
               		 	.attr('id','gl_acct_cd_'+(rowCount+1))
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][gl_acct_cd]')
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
               		 		.html('<?php echo $row->gl_a. ' - ' .$row->acct_name?>')
               		 	)		
               		 	<?php 
							} 
						?>
               		)
               	).append($('<td>')
               		 .attr('class','slAcct')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][sl_acct_cd]')
               		 	.attr('type','text')
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
						    change: function(event,ui)
					        {
					        	if (ui.item==null)
					            {
						            $(this).val('');
						            //$(this).focus();
					            }
					        },
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
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][curr_val]')
               		 	.attr('type','text')
               		 	.attr('onchange','checkBalance()')
               		 	 .css('text-align','right')
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
               		)
               	).append($('<td>')
               		 .attr('class','dbcr')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][db_cr_flg]')
               		 	.attr('required','required')
               		 	.attr('onchange','checkBalance()')
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
               		)
               	).append($('<td>')
               		 .attr('class','remarks')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][ledger_nar]')
               		 	.attr('type','text')
               		 	.attr('onchange','checkBalance()')
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	.css('max-width','350%')	
               		 	.css('cursor','pointer')
               		 	)
               		)
               	)  	
    		);
    	
    	rowCount++;
    	//reassignId();
    	//$(window).trigger('resize');
    	$('#gl_acct_cd_'+(rowCount)).focus();
	}
	
	function filterSlAcct(obj)
	{
		var glAcctCd = $(obj).val();
		var result = [];
				
		$(obj).parent().next().children("[type=text]").val('').autocomplete(
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
		    change: function(event,ui)
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
	        },
		    minLength: 1
		});
	}
	
	function reassignId()
	{ 
		var x = 1;
		$("#tableDetailLedger").children("tbody").children("tr").each(function()
		{
			$(this).children("td.glAcct").children("select").attr("name","Taccountledger["+x+"][gl_acct_cd]");
			$(this).children("td.slAcct").children("[type=text]").attr("name","Taccountledger["+x+"][sl_acct_cd]");
			$(this).children("td.amt").children("[type=text]").attr("name","Taccountledger["+x+"][curr_val]");
			$(this).children("td.dbcr").children("select").attr("name","Taccountledger["+x+"][db_cr_flg]");
			$(this).children("td.remarks").children("[type=text]").attr("name","Taccountledger["+x+"][ledger_nar]");
			x++;
		});
	}
	$(window).resize(function() {
		
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableDetailLedger").find('thead');
		var firstRow = $("#tableDetailLedger").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		//firstRow.find('td:eq(5)').css('width',('100px')-17 + 'px');
		
	}
	initAutoComplete();
	function initAutoComplete()
	{
		$("#clientBankAcct").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getBankAcctNum'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'client_cd' : $("#clientCd").val()
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				    				}
				});
		   },
		   change: function(event,ui)
	       {
	           findBankCd();
	       },
		   minLength: 0
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });;
		
		$("#tableDetailLedger").children('tbody').children('tr:not(:first)').each(function()
		{
			var glAcctCd = $(this).children('td.glAcct').children('select').val();
			var result = [];
			
			$(this).children('td.slAcct').children('[type=text]').autocomplete(
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
			    change: function(event,ui)
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
		        },
			    minLength: 1,
			    open: function() { 
			        $(this).autocomplete("widget").width(400); 
			    } 
			});
		});
		
		$("#tableDetailLedger").children('tbody').children('tr:not(:first)').each(function()
		{
			var glAcctCd = $(this).children('td.glAcct').children('select').val();
			var result = [];
			
			$(this).children('td.slAcct').children('[type=text]').autocomplete(
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
			    change: function(event,ui)
		        {
		        	if (ui.item==null)
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
		            }
		        },
			    minLength: 1,
			    open: function() { 
			        $(this).autocomplete("widget").width(400); 
			    } 
			});
		});
	}
	
	
	</script>		