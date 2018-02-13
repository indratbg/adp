<style>
	#tableLedger
	{
		background-color:#C3D9FF;
	}
	#tableLedger thead, #tableLedger tbody
	{
		display:block;
	}
	#tableLedger tbody
	{
		max-height:200px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>	

<?php
$this->breadcrumbs=array(
	'GL Journal Entry Inbox'=>array('index'),
	$update_seq,
);

$this->menu=array(
	array('label'=>'Update GL Journal Entry Inbox #'.$model->folder_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update&id='.$update_seq.''),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','icon'=>'eye-open','url'=>array('view&id='.$update_seq.''),'itemOptions'=>array('style'=>'float:right'))
);
?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php
	$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
?>

	<br/>

	<?php echo $form->errorSummary(array($model,$modelFolder,$modelHeader)); 
		foreach($modelDetail as $row)echo $form->errorSummary(array($row));
	?>
		
	<div class="row-fluid control-group">
	
		<div class="span4">
			<?php echo $form->datePickerRow($model,'jvch_date',array('class'=>'span4','placeholder'=>'dd/mm/yyyy','required'=>'required','style'=>'margin-left:-80px;','readonly'=>false));?>
		
		</div>
		<div class="span2" style="margin-left:-140px;">
				<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span9','required'=>$cek_folder == 'Y'?'required':'','readonly'=>$cek_folder == 'Y'?'':true,'style'=>'margin-left:-90px;'));?>
				<?php echo $form->textField($model,'curr_amt',array('style'=>'display:none;'));?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'jvch_num',array('class'=>'span5','readonly'=>true,'style'=>'margin-left:-30px;'));?>
		</div>
	</div>
	<div class="row-fluid control-group">
		<div class="span">
			<?php echo $form->textFieldRow($model,'remarks',array('class'=>'span8','required'=>'required','style'=>'margin-left:-80px;width:545px;'));?>	
		</div>
	</div>


<br/>

<input type="hidden" id="rowCount" name="rowCount"/>
	<legend style="font-size: 2em;">Ledger Detail</legend>
	<table id='tableLedger' class='table-bordered table-condensed' >
		<thead>
			<tr>
			<th id="header1"></th>
			<th id="header2">GL Account</th>
			<th id="header3">SL Account</th>
			<th id="header4">Amout</th>
			<th id="header5">Db/Cr</th>
			<th id="header6">Ledger Description</th>
				<th id="header7">
					<a style="cursor:pointer;" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
				<td>
					<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Taccountledger['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
				<?php if($row->old_xn_doc_num): ?>
					<input type="hidden" name="Taccountledger[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php  endif; ?>
				</td>
				
				<td width="100px" class="glAcct">
					<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($gl_a, 'gl_a', 'glDescrip'),array('class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','onChange'=>'filterSlAcct(this)','readonly'=>$row->save_flg !='Y'?'readonly':'','prompt'=>'-Choose-','id'=>"gl_acct_cd_$x")) ;?>
					
					
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][manual]" value="<?php echo $row->manual ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][reversal_jur]" value="<?php echo $row->reversal_jur ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][record_source]" value="<?php echo $row->record_source ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][budget_cd]" value="<?php echo $row->budget_cd ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][sett_val]" value="<?php echo $row->sett_val ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][sett_for_curr]" value="<?php echo $row->sett_for_curr ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][sett_curr_min]" value="<?php echo $row->sett_curr_min ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][exch_rate]" value="<?php echo $row->exch_rate ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][arap_due_date]" value="<?php echo $row->arap_due_date ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][sett_status]" value="<?php echo $row->sett_status ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][rvpv_number]" value="<?php echo $row->rvpv_number ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][netting_date]" value="<?php echo $row->netting_date ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][netting_flg]" value="<?php echo $row->netting_flg ;?>" />
					
				</td>
				
				<td width="100px" class="slAcct">
					
	
					
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][sl_acct_cd]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="150px" class="amt">
					<?php echo $form->textField($row,'curr_val',array('class'=>'span tnumberdec amt','name'=>'Taccountledger['.$x.'][curr_val]','style'=>'text-align:right','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="80px" class="dbcr">
					
					<?php echo $form->dropDownList($row,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),array('class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="420px" class="remarks">
					<?php echo $form->textField($row,'ledger_nar',array('class'=>'span','name'=>'Taccountledger['.$x.'][ledger_nar]','onchange'=>'ledger_nar('.$x.')','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td style="cursor:pointer;" width="30px">
					<a 
						title="<?php   if($row->old_xn_doc_num) echo 'cancel';else echo 'delete'?>" 
						onclick="<?php if($row->old_xn_doc_num) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
						<img style="width:13px;height:13px;" src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
					</a>
					</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>

<br class="temp"/>
	
	<?php if(!$model->isNewRecord): ?>
		<?php echo $form->label($model, 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
		<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
	<?php endif; ?>
	
	<br class="temp"/><br class="temp"/>



	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnSubmit'),
			'label'=>'Save',
		)); ?>
	</div>



<?php $this->endWidget(); ?>



<?php 
	if($model->isNewRecord)$new=1;
	else
		$new=0;
?>

<script>


var rowCount = <?php echo count($modelDetail) ?>;
	init();
	function init(){
	
			$("#Tjvchh_jvch_date").datepicker({format : "dd/mm/yyyy"});
			cancel_reason();
			adjustWidthNull();
	}
	
	function addRow()
	{
		$("#tableLedger").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(rowCount+1))
    			.append($('<td>')
				.append($('<input>')
					.attr('name','Taccountledger['+(rowCount+1)+'][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
					
				)
				.css('width','15px')
			)
			
        	.append($('<td>')
        				.attr('class','glAcct')
               		 .append($('<select>')
               		 	.attr('class','span ')
               		 	.attr('id','gl_acct_cd_'+(rowCount+1))
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
               		 		.html('<?php echo $row->glDescrip ?>')
               		 	)		
               		 	<?php 
							} 
						?>
               		)
               		 	.css('width','98px')
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
               		.css('width','100px')
               		
               	).append($('<td>')
               		 .attr('class','amt')
               		 .append($('<input>')
               		 	.attr('class','span tnumberdec')
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][curr_val]')
               		 	.attr('type','text')
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
               		.css('width','150px')
               	).append($('<td>')
               	 	.attr('class','dbcr')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][db_cr_flg]')
               		 	.attr('required','required')
               		 	.append($('<option>')
               		 	.attr('value','D')
               		 	.html('DEBIT'))
               		 		.append($('<option>')
               		 	.attr('value','C')
               		 	.html('CREDIT'))
               		)
               		.css('width','78px')
               	).append($('<td>')
               		.attr('class','remarks')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('id','Taccountledger_'+(rowCount+1)+'_ledger_nar')
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][ledger_nar]')
               		 	.attr('onchange','ledger_nar('+(rowCount+1)+')')	
               		 	.attr('type','text')	
               		)
               		.css('width','200px')
               	)
               	
               	
               	.append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	.css('width','13px')
               		 	.css('height','13px')
               		 	)
               		)
               		.css('cursor','pointer')
               	)  	
    		);
    	$('#gl_acct_cd_'+(rowCount+1)).focus();
    	rowCount++;
    	
    	//reassignAttribute();
	}
	
var x;
	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	
	
	function adjustWidth(){
		
		$("#header1").width($("#tableLedger tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableLedger tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableLedger tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableLedger tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableLedger tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableLedger tbody tr:eq(0) td:eq(5)").width());
		$("#header7").width($("#tableLedger tbody tr:eq(0) td:eq(6)").width());
	}
	
	function adjustWidthNull(){
		
		$("#header1").width('15px');
		$("#header2").width('98px');
		$("#header3").width('98px');
		$("#header4").width('150px');
		$("#header5").width('100px');
		$("#header6").width('200px');
		$("#header7").width('30px');
	}
	

	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		//reassignAttribute();
			 reassignId();
	}
	$("#btnSubmit").click(function()
	{
		if(!checkBalance())
		{		
			return false;
		}
		else{
				assignRowCount();
		}
		
	
	});
	
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		if(!$(obj).is(':checked') && $("#tableLedger tbody tr:eq("+x+") td:eq(4) [type=hidden]").val())resetValue(obj,x); // Reset Value when the checkbox is unchecked and the row contains an existing record
		
		$("#tableLedger tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableLedger tbody tr:eq("+x+") td:eq(1) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableLedger tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableLedger tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableLedger tbody tr:eq("+x+") td:eq(4) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableLedger tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(9) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function cancel_reason()
	{
		var cancel_reason = false;
		//alert(rowCount);
		for(x=0;x<rowCount;x++)
		{
			if($("#row"+(x+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason)$(".cancel_reason, .temp").show().attr('disabled',false)
		else
			$(".cancel_reason, .temp").hide().attr('disabled',true);
	}
	
	function cancel(obj, cancel_flg, seq)
	{ 
		
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Taccountledger['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableLedger tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
	
	}	
		
	function assignRowCount()
	{
		$("#rowCount").val(rowCount);
	}
	
	function checkBalance()
	{
		
		var balance = 0;
		var x = 0;
		var curr_bal= 0;
		var curr_balance=0;
		var credit=0;
		var t_credit=0;
		$("#tableLedger").children('tbody').children('tr').each(function()
		{	 
			var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			var curr_amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;

			var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			
			if(dbcrFlg == 'D' && (!$(this).hasClass('markCancel')))
			{ 
				balance += amt;
				curr_balance += curr_amt;
				curr_bal = curr_balance /100;
			}
			else if(dbcrFlg == 'C' && (!$(this).hasClass('markCancel')))
			{
				balance -= amt;
				credit +=amt;
				t_credit =credit/100;
			}
			
		});
		//alert(curr_bal);
		$('#Tjvchh_curr_amt').val(curr_bal);
		if(balance != 0){
			alert("             Amount not balanace \nTotal Debit "+curr_bal +" dan Total Credit "+ t_credit);
			return false;
		}
		else 
			return true; 
	}
	
	
	$('#Tjvchh_folder_cd').change(function(){
		var folder_cd=$('#Tjvchh_folder_cd').val();
		
		
		$('#Tjvchh_folder_cd').val(folder_cd.toUpperCase());
	});
	
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
		    minLength: 0,
		     open: function() { 
			        $(this).autocomplete("widget").width(400); 
			    } 
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
	}
	
	function reassignId()
	{ 
		var x = 1;
		$("#tableLedger").children("tbody").children("tr").each(function()
		{	$(this).children("td.glAcct").children("select").attr("id","gl_acct_cd_"+x);
			$(this).children("td.glAcct").children("select").attr("name","Taccountledger["+x+"][gl_acct_cd]");
			$(this).children("td.slAcct").children("[type=text]").attr("name","Taccountledger["+x+"][sl_acct_cd]");
			$(this).children("td.amt").children("[type=text]").attr("name","Taccountledger["+x+"][curr_amt]");
			$(this).children("td.dbcr").children("select").attr("name","Taccountledger["+x+"][db_cr_flg]");
			$(this).children("td.remarks").children("[type=text]").attr("name","Taccountledger["+x+"][ledger_nar]");
			x++;
		});
	}
		$('#Tjvchh_remarks').change(function(){
			var remarks=$('#Tjvchh_remarks').val();
		$('#Tjvchh_remarks').val(remarks.toUpperCase());
		});
	function ledger_nar(num){
		//	alert(num);
			var ledger_nar=$('#Taccountledger_'+num+'_ledger_nar').val();
			$('#Taccountledger_'+num+'_ledger_nar').val(ledger_nar.toUpperCase());
		}
		
/*

function sl_acct(num){

	 $('#Taccountledger_'+num+'_sl_acct_cd').autocomplete(
	         			{
	         				source: function (request, response) 
	         				{
						        $.ajax({
						        	'type'		: 'POST',
						        	'url'		: '<?php //echo $this->createUrl('getSlAcct'); ?>',
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
						    minLength: 0,
						    
						      open: function() { 
			        $(this).autocomplete("widget").width(400);
			    } 
	         			}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
}
*/
initAutoComplete();
	function initAutoComplete()
	{
		
		$("#tableLedger").children('tbody').children('tr').each(function()
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
			    minLength: 0,
			    open: function() { 
			        $(this).autocomplete("widget").width(400); 
			    } 
			}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        })
		});
		
		
	}
	
</script>
