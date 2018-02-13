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



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php
$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' and acct_stat = 'A' AND approved_stat = 'A' ","order"=>"gl_a"));
	$sql="select dflg1 from mst_sys_param where param_id='SYSTEM' and param_cd1='VCH_REF'";
	$dflg1=DAO::queryRowSql($sql);
	$folder_cd=$dflg1['dflg1'];
	
?>

<br/>

	<?php echo $form->errorSummary($model); ?>
	
		<?php 
		foreach($modeldetail as $row)
			echo $form->errorSummary(array($row)); 
	?>

	<div class="row-fluid control-group">
	
		<div class="span4">
			<?php echo $form->datePickerRow($model,'jvch_date',array('class'=>'span4','placeholder'=>'dd/mm/yyyy','required'=>'required','style'=>'margin-left:-100px;'));?>	
	
		</div>
		<div class="span2" style="margin-left:-155px;">
			<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span9','required'=>$folder_cd == 'Y'?'required':'','readonly'=>$folder_cd == 'Y'?'':true,'style'=>'margin-left:-90px;'));?>
			<?php echo $form->textField($model,'curr_amt',array('style'=>'display:none;'));?>
			<?php //echo $form->textFieldRow($model,'jvch_num',array('class'=>'span5','readonly'=>true));?>
		</div>
		<div class="span6" style="margin-left:-5px;">
			<?php echo $form->textFieldRow($model,'remarks',array('class'=>'span11','required'=>'required','style'=>'margin-left:-80px;'));?>	
		</div>
		<div class="span2" style="text-align:right">
			Interest Adjustment
			&nbsp;
			<?php echo $form->checkBox($model,'int_adjust',array('value'=>'Y','uncheckValue'=>'N','id'=>'intAdjust','onClick'=>'$(this).is(":checked")?$("#intHint").show():$("#intHint").hide()')); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span4">
			&nbsp;
		</div>
		<div id="intHint" class="span8" style="margin-left:-155px;display:<?php echo $model->int_adjust=='Y'?'inline':'none' ?>">
			<i style="font-size:11px;color:blue">AJ-xxxx - koreksi interest masuk ke perhitungan interest</i>
			</br>
			<i style="font-size:11px;color:blue">IJ-0001 s/d IJ-0999 koreksi interest TIDAK masuk ke perhitungan interest</i>
		</div>
	</div>

<input type="hidden" id="rowCount" name="rowCount"/>
<input type="hidden" id="authorizedBackDated" name="authorizedBackDated" />
	<legend style="font-size: 2em;">Ledger Detail</legend>
	<table id='tableLedger' class='table-bordered table-condensed' >
		<thead>
			<tr>
			<th id="header1"></th>
			<th id="header2">GL Account</th>
			<th id="header3">SL Account</th>
			<th id="header4">Amount</th>
			<th id="header5">Db/Cr</th>
			<th id="header6">Ledger Description</th>
				<th id="header7">
					<a style="cursor:pointer;" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modeldetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
				<td>
					<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Taccountledger['.$x.'][save_flg]','checked'=>true,'onChange'=>'rowControl(this)')); ?>
				<?php if($row->old_xn_doc_num): ?>
					<input type="hidden" name="Taccountledger[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php  endif; ?>
				</td>
				
				<td width="100px" class="glAcct">
					<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($gl_a, 'gl_a', 'glDescrip'),array('onchange'=>'filterSlAcct(this)','class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','id'=>"gl_acct_cd_$x",'prompt'=>'-Choose-','readonly'=>$x==1?'':$row->save_flg !='Y'?'readonly':'')) ;?>
					<?php // echo $form->textField($row,'gl_acct_cd',array('class'=>'span tdate','name'=>'Taccountledger['.$x.'][gl_acct_cd]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][old_xn_doc_num]" value="<?php echo $row->old_xn_doc_num ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][old_tal_id]" value="<?php echo $row->old_tal_id ;?>" />
					<input type="hidden" name="Taccountledger[<?php echo $x;?>][tal_id]" value="<?php echo $row->old_tal_id ;?>" />
				</td>
				
				<td width="60px" class="slAcct">
					<?php /* $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
							'model'=>$row,
						  //  'name'=>'Taccountledger['.$x.'][sl_acct_cd]',
						    'attribute'=>'sl_acct_cd',
						    // additional javascript options for the autocomplete plugin
						    'options'=>array(
						        'minLength'=>'1',
						        //'width'=>'200',
						    ),
						    
						
						    'source'=>'js: function(request, response) {
									    $.ajax({
									        url: "'.$this->createUrl('/glaccounting/Gljournalledger/getSlAcct').'",
									        dataType: "json",
									        data: {
									            term: request.term,
									            gl_acct_cd: $("#Taccountledger_'.$x.'_gl_acct_Cd").val(),
									           
									        },
									        success: function (data) {
									                response(data);
								
													
									        },
							
									    })
									 }',
							
						  'htmlOptions'=>array('style'=>'height:18px;width:100px;','readonly'=>$x==1?'':$row->save_flg !='Y'?'readonly':'','name'=>'Taccountledger['.$x.'][sl_acct_cd]')
						));*/
	
	?>
	
					
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][sl_acct_cd]','readonly'=>$x==1?'':$row->save_flg !='Y'?'readonly':'','style'=>'height:18px;width:100px;')); ?>
				</td>
				<td width="150px" class="amt">
					<?php echo $form->textField($row,'curr_val',array('class'=>'span tnumberdec amt','name'=>'Taccountledger['.$x.'][curr_val]','style'=>'text-align:right','readonly'=>$x==1?'':$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="80px" class="dbcr">
					
					<?php echo $form->dropDownList($row,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),array('class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','readonly'=>$x==1?'':$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="420px" class="remarks">
					<?php echo $form->textField($row,'ledger_nar',array('class'=>'span','name'=>'Taccountledger['.$x.'][ledger_nar]','onchange'=>'ledger_nar('.$x.')','readonly'=>$x==1?'':$row->save_flg !='Y'?'readonly':'')); ?>
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
			'label'=> 'Save',
		)); ?>
	</div>



<?php $this->endWidget(); ?>



<?php 
	if($model->isNewRecord)$new=1;
	else
		$new=0;
?>

<script>


var rowCount = <?php echo count($modeldetail) ?>;
var authorizedCancel = true;
var authorizedBackDated= true;
	init();
	function init(){
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCancel'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedCancel = false;
				}
			}
		});
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateBackDated'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedBackDated = false;
				}
			}
		});
		
		
		
		
			$("#Tjvchh_jvch_date").datepicker({format : "dd/mm/yyyy"});
			cancel_reason();
			adjustWidthNull();
			
			
		//	$('#Tjvchh_folder_cd').val('RJ-');
				//$('#Tjvchh_folder_cd').val('RJ-');
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
               		 	.attr('name','Taccountledger['+(rowCount+1)+'][ledger_nar]')
               		 	.attr('id','Taccountledger_'+(rowCount+1)+'_ledger_nar')
               		 	.attr('type','text')
               		 	.attr('onchange','ledger_nar('+(rowCount+1)+')')	
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
	
	
	function reassignAttribute()
	{
		for(x = 0; x<rowCount; x++)
		{
			//Re-assign id untuk row agar urut sesuai dengan baris
			$("#tableLedger tbody tr:eq("+x+")").attr("id","row"+(x+1));
			$("#tableLedger tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Taccountledger["+(x+1)+"][save_flg]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Taccountledger["+(x+1)+"][cancel_flg]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Taccountledger["+(x+1)+"][save_flg]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(1) select").attr("name","Taccountledger["+(x+1)+"][gl_acct_cd]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(1) select").attr("id","gl_acct_cd_"+(x+1));
			$("#tableLedger tbody tr:eq("+x+") td:eq(1) [type=hidden]:eq(0)").attr("name","Taccountledger["+(x+1)+"][old_xn_doc_num]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(1) [type=hidden]:eq(01)").attr("name","Taccountledger["+(x+1)+"][old_tal_id]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(2) [type=text]").attr("name","Taccountledger["+(x+1)+"][sl_acct_cd]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(3) [type=text]").attr("name","Taccountledger["+(x+1)+"][curr_val]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(4) select").attr("name","Taccountledger["+(x+1)+"][db_cr_flg]");
			$("#tableLedger tbody tr:eq("+x+") td:eq(5) [type=text]").attr("name","Taccountledger["+(x+1)+"][ledger_nar]");
		}
			//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Taccountledger["+(x+1)+"][cancel_flg]']").val())
				$("#tableLedger tbody tr:eq("+x+") td:eq(6) a:eq(0)").attr('onClick',"cancel(this,'"+$("[name='Taccountledger["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableLedger tbody tr:eq("+x+") td:eq(6) a:eq(0)").attr('onClick',"deleteRow(this)");
   			}
   		}
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
		if(authorizedBackDated)$("#authorizedBackDated").val(1);
		else
			$("#authorizedBackDated").val(0);
		
		if(!checkBalance())
		{
			//alert("Amount is not balanced");
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
		if(authorizedCancel)
		{
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Taccountledger['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableLedger tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
		}
		else
			alert('You are not authorized to perform this action');	
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
			//var amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;
			// var curr_amt = setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()) * 100;

			var amt = parseInt(setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()).replace('.',''));
			var curr_amt =parseInt(setting.func.number.removeCommas($(this).children('td.amt').children('[type=text]').val()).replace('.',''));
			
			
			var dbcrFlg = $(this).children('td.dbcr').children('select').val();
			
			if(dbcrFlg == 'D')
			{
				balance += amt;
				curr_balance += curr_amt;
				curr_bal = curr_balance /100;
			}
			else if(dbcrFlg == 'C' )
			{
				balance -= amt;
				credit +=amt;
				t_credit =credit/100;
			}
			else
			{
				return false;
			}
			//alert(balance);			
		
		});
			//alert(curr_bal);
			$('#Tjvchh_curr_amt').val(curr_bal);
		if(balance != 0){
			alert("             Amount not balance \nTotal Debit "+curr_bal +" dan Total Credit "+ t_credit);
			return false;
		}
		else 
			//alert(curr_bal);
			
		// $('#Tjvchh_curr_amt').val(curr_bal);
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
		    minLength: 0
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
	}
	
	function reassignId()
	{ //alert('test');
		var x = 1;
		$("#tableLedger").children("tbody").children("tr").each(function()
		{
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
		
	 $('#Taccountledger_1_sl_acct_cd').autocomplete(
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
			         $(this).autocomplete("widget").css('overflow-y','scroll');
			         $(this).autocomplete("widget").css('max-height','250px');
			    } 
	         			})
	         			
	         			
	 $('#Tjvchh_jvch_date').change(function(){
	 	cek_holiday();
	 })        			
	function cek_holiday()
	{
		
		var tanggal =  $('#Tjvchh_jvch_date').val();
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('CekHoliday'); ?>',
				'dataType' : 'json',
				'data'     : {
 							'tanggal': tanggal
							},
				'success'  : function(data){
					var holiday=data.holiday;
					
				
				if (holiday == 1){
					alert('Hari Libur Bursa');	
					$('#Tjvchh_jvch_date').val(' ');
				}			
					
				}
			});	
	}	
	
</script>
