<?php
	$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
?>

<div class="detail" id="detail">
	<table id='tableDetail' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="3%"></th>
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
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
				<td class="edit">
					<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tpayrecd['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
					<?php if($row->rowid): ?>
						<input type="hidden" name="Tpayrecd[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
					<?php endif; ?>
				</td>
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
					<input type="hidden" name="Tpayrecd[<?php echo $x ?>][old_payrec_amt]" value="<?php echo $row->old_payrec_amt ?>"/>
				</td>
				<td class="dbcr">
					<?php if($x == 1): ?>
						<?php echo $form->textField($row,'db_cr_flg',array('class'=>'span','name'=>'Tpayrecd['.$x.'][db_cr_flg]','readonly'=>'readonly')); ?>
					<?php else: ?>
						<?php echo $form->dropDownList($row,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),array('class'=>'span','name'=>'Tpayrecd['.$x.'][db_cr_flg]','prompt'=>'-Choose-','required'=>'required')); ?>
					<?php endif; ?>
					<input type="hidden" name="Tpayrecd[<?php echo $x ?>][old_db_cr_flg]" value="<?php echo $row->old_db_cr_flg ?>"/>
				</td>
				<td class="remarks">
					<?php echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Tpayrecd['.$x.'][remarks]')); ?>
				</td>
				<td class="delete">
					<?php if($x > 2): ?>
						<?php if(!$row->rowid): ?>
						<a 
							title="delete" 
							onclick="deleteRow(this)">
							<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
						</a>
						<?php else: ?>
						<a title="cancel" onclick="cancel(this,'<?php echo $row->cancel_flg ?>',<?php echo $x ?>)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png"></a>
						<?php endif; ?>	
					<?php endif; ?>
				</td>
				<input type="hidden" class="rowid" name="Tpayrecd[<?php echo $x ?>][rowid]" value="<?php echo $row->rowid ?>" />
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	<input type="hidden" id="detailCount" name="detailCount"/>
	
	<br class="temp"/>
	
	<?php echo $form->label($model, 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
	<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
	
	<br class="temp"/><br class="temp"/>
</div>

<script>
	var detailCount = <?php echo count($modelDetail) ?>;

	function rowControl(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		var rowid_flg =  $(obj).closest('tr').children('.rowid').length;
		
		$("#tableDetail tbody tr:eq("+x+") td.glAcct select").attr("disabled",!$(obj).is(':checked')?true:false);
		$("#tableDetail tbody tr:eq("+x+") td.slAcct [type=text]").attr("readonly",!$(obj).is(':checked')||x==0?true:false);
		$("#tableDetail tbody tr:eq("+x+") td.amt [type=text]").attr("readonly",!$(obj).is(':checked')||x==0?true:false);
		$("#tableDetail tbody tr:eq("+x+") td.dbcr select").attr("disabled",!$(obj).is(':checked')?true:false);
		$("#tableDetail tbody tr:eq("+x+") td.remarks [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td.delete a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	
		if(!$(obj).is(':checked') && rowid_flg && x > 0)
		{
			$("#tableDetail tbody tr:eq("+x+") td.amt [type=text]").val($("#tableDetail tbody tr:eq("+x+") td.amt [type=hidden]").val()).blur();
			$("#tableDetail tbody tr:eq("+x+") td.dbcr select").val($("#tableDetail tbody tr:eq("+x+") td.dbcr [type=hidden]").val());
		}
	}

	function addRow()
	{
		$("#tableDetail").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(detailCount+1))
    			.append($('<td>')
    				.attr('class','edit')
					.append($('<input>')
						.attr('name','Tpayrecd['+(detailCount+1)+'][save_flg]')
						.attr('type','checkbox')
						.attr('onChange','rowControl(this)')
						.prop('checked',true)
						.val('Y')
					)
				)
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
			$(this).attr("id","row"+x);	
			$(this).children('td.edit').children('[type=checkbox]').attr("name","Tpayrecd["+x+"][save_flg]");
			$(this).children('td.edit').children('[type=hidden]:eq(0)').attr("name","Tpayrecd["+x+"][save_flg]");
			$(this).children('td.edit').children('[type=hidden]:eq(1)').attr("name","Tpayrecd["+x+"][cancel_flg]");
			$(this).children("td.glAcct").children("select").attr("name","Tpayrecd["+x+"][gl_acct_cd]");
			$(this).children("td.slAcct").children("[type=text]").attr("name","Tpayrecd["+x+"][sl_acct_cd]");
			$(this).children("td.amt").children("[type=text]").attr("name","Tpayrecd["+x+"][payrec_amt]");
			$(this).children("td.amt").children("[type=hidden]").attr("name","Tpayrecd["+x+"][old_payrec_amt]");
			$(this).children("td.dbcr").children("select").attr("name","Tpayrecd["+x+"][db_cr_flg]");
			$(this).children("td.dbcr").children("[type=hidden]").attr("name","Tpayrecd["+x+"][old_db_cr_flg]");
			$(this).children("td.remarks").children("[type=text]").attr("name","Tpayrecd["+x+"][remarks]");
			
			$(this).children("[type=hidden]").attr("name","Tpayrecd["+x+"][rowid]");
			x++;
		});
		
		for(x=0;x<detailCount;x++)
   		{
   			if($("[name='Tpayrecd["+(x+1)+"][cancel_flg]']").val())
				$("#tableDetail tbody tr:eq("+x+") td.delete a:eq(0)").attr('onClick',"cancel(this,'"+$("[name='Tpayrecd["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableDetail tbody tr:eq("+x+") td.delete a:eq(0)").attr('onClick',"deleteRow(this)");
   			}
   		}
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
		$('[name="Tpayrecd['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
		$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
		
		$("#tableDetail tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
		
		cancel_reason();
	}
	
	function cancel_reason()
	{
		var cancel_reason = false;
		
		for(x=0;x<detailCount;x++)
		{
			if($("#tableDetail").find("#row"+(x+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason)$(".cancel_reason, .temp").show().attr('disabled',false)
		else
			$(".cancel_reason, .temp").hide().attr('disabled',true);
	}
</script>
