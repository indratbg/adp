<?php
	$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
?>

<div class="detail" id="detail">
	<table id='tableDetail' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="10%">GL Account</th>
				<th width="13%">SL Account</th>
				<th width="18%">Amount</th>
				<th width="9%">Db/Cr</th>
				<th width="30%">Journal Description</th>
				<th width="3%">
					<a title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td class="glAcct">
					<?php if($x == 1): ?>
						<?php echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Tpayrecd['.$x.'][gl_acct_cd]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($gl_a, 'gl_a', 'glDescrip'),array('class'=>'span','name'=>'Tpayrecd['.$x.'][gl_acct_cd]','prompt'=>'-Choose-','onChange'=>'filterSlAcct(this)')); ?>
					<?php endif; ?>
				</td>
				<td class="slAcct">
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Tpayrecd['.$x.'][sl_acct_cd]','readonly'=>$x==1?'readonly':'')); ?>
				</td>
				<td class="amt">
					<?php echo $form->textField($row,'payrec_amt',array('class'=>'span tnumberdec','name'=>'Tpayrecd['.$x.'][payrec_amt]','readonly'=>$x==1?'readonly':'')); ?>
				</td>
				<td class="dbcr">
					<?php if($x == 1): ?>
						<?php echo $form->textField($row,'db_cr_flg',array('class'=>'span','name'=>'Tpayrecd['.$x.'][db_cr_flg]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),array('class'=>'span','name'=>'Tpayrecd['.$x.'][db_cr_flg]','prompt'=>'-Choose-','required'=>'required')); ?>
					<?php endif; ?>
				</td>
				<td class="remarks">
					<?php echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Tpayrecd['.$x.'][remarks]')); ?>
				</td>
				<td>
					<?php if($x > 2): ?>
					<a title="delete" onclick="deleteRow(this)">
						<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
					</a>
					<?php endif; ?>
				</td>
				<input type="hidden" class="amount" name="Tpayrecd[<?php echo $x ?>][cash_withdraw_amt]" />
				<input type="hidden" class="reason" name="Tpayrecd[<?php echo $x ?>][cash_withdraw_reason]" />
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	<input type="hidden" id="detailCount" name="detailCount"/>
</div>

<script>
	var detailCount = <?php echo count($modelDetail) ?>;


	function addRow()
	{
		$("#tableDetail").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(detailCount+1))
    			.append($('<td>')
    				 .attr('class','glAcct')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][gl_acct_cd]')
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
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][sl_acct_cd]')
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
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][payrec_amt]')
               		 	.attr('type','text')
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
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][db_cr_flg]')
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
               		)
               	).append($('<td>')
               		 .attr('class','remarks')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tpayrecd['+(detailCount+1)+'][remarks]')
               		 	.attr('type','text')
               		 	.attr('maxlength',50)
               		 	.change(function()
               		 	{
               		 		$(this).val($(this).val().toUpperCase());
               		 	})
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)
               	.append($('<input>')
               		.attr('class','amount')
               		.attr('name','Tpayrecd['+(detailCount+1)+'][cash_withdraw_amt]')
               		.attr('type','hidden')
               	)
               	.append($('<input>')
               		.attr('class','reason')
               		.attr('name','Tpayrecd['+(detailCount+1)+'][cash_withdraw_reason]')
               		.attr('type','hidden')
               	)
    		);
    	
    	detailCount++;
    	//reassignId();
    	//$(window).trigger('resize');
	}
	
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		detailCount--;
		reassignId();
		//$(window).trigger('resize');
	}
	
	function filterSlAcct(obj)
	{
		var glAcctCd = $(obj).val();
		var result = [];
		var clientcdval = $("#clientCd").val();
		
		if(glAcctCd == '1422'){
			$(obj).parent().next().children("[type=text]").val(clientcdval);
		}
		
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
	
	function reassignId()
	{
		var x = 1;
		$("#tableDetail").children("tbody").children("tr").each(function()
		{
			$(this).children("td.glAcct").children("select").attr("name","Tpayrecd["+x+"][gl_acct_cd]");
			$(this).children("td.slAcct").children("[type=text]").attr("name","Tpayrecd["+x+"][sl_acct_cd]");
			$(this).children("td.amt").children("[type=text]").attr("name","Tpayrecd["+x+"][payrec_amt]");
			$(this).children("td.dbcr").children("select").attr("name","Tpayrecd["+x+"][db_cr_flg]");
			$(this).children("td.remarks").children("[type=text]").attr("name","Tpayrecd["+x+"][remarks]");
			x++;
		});
	}
</script>
