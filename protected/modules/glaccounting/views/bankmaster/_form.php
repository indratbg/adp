<style>
	#tableAcct
	{
		background-color:#C3D9FF;
	}
	#tableAcct thead, #tableAcct tbody
	{
		display:block;
	}
	#tableAcct tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>	

<?php 
	$prefixList = Bankacct::model()->findAll("folder_prefix IS NOT NULL AND approved_stat = 'A'");
	$glList = Glaccount::model()->findAll(array('select'=>'DISTINCT TRIM(gl_a) gl_a','condition'=>"acct_type = 'BANK' AND acct_stat = 'A' AND approved_stat = 'A'"));
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bankmaster-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model)); ?>
	
	<?php 
		foreach($modelAcct as $row)
			echo $form->errorSummary(array($row)); 
	?>

	<?php echo $form->textFieldRow($model,'bank_cd',array('class'=>'span1','maxlength'=>3,'id'=>'bankCd','readonly'=>!$model->isNewRecord?'readonly':'')); ?>

	<?php echo $form->textFieldRow($model,'bank_name',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'short_bank_name',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->dropDownListRow($model,'rtgs_cd',Chtml::listData(Parameter::model()->findAll(array("condition"=>"prm_cd_1 = 'BAKPEI'",'order'=>'prm_cd_2')),'prm_cd_2','ParameterDesc'),array('class'=>'span5')); ?>
	
	<input type='hidden' id="rowCount" name="rowCount" value=""/>
	
	<br/><br/>
	
	<table id='tableAcct' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="4%"></th>
				<th width="6%">Bank Code</th>
				<th width="13%">Main Acct</th>
				<th width="15%">Sub Acct Code</th>
				<th width="21%">Bank Acct Code</th>
				<th width="6%">Account Type</th>
				<th width="6%">Branch Code</th>
				<th width="6%">Vch Prefix</th>
				<th width="6%">Currency</th>
				<th width="13%">Close Date</th>
				<th width="4%"><a title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a></th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelAcct as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
				<td>
					<?php if($model->isNewRecord && $init): ?>
						<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Bankacct['.$x.'][save_flg]','onChange'=>'rowControl(this,true)','checked'=>'checked')); ?>
					<?php else: ?>
						<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Bankacct['.$x.'][save_flg]','onChange'=>$row->old_bank_acct_cd&&!$check[$x-1]->check?'rowControl(this,false)':'rowControl(this,true)')); ?>
					<?php endif; ?>
					<?php if($row->old_bank_acct_cd): ?>
						<input type="hidden" name="Bankacct[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
					<?php endif; ?>
				</td>
				<td>
					<?php echo $form->textField($row,'bank_cd',array('class'=>'span','readonly'=>!$model->isNewRecord&&$check[$x-1]&&!$check[$x-1]->check&&$row->old_bank_acct_cd&&$row->save_flg=='Y'?'':'readonly','name'=>'Bankacct['.$x.'][bank_cd]')); ?>
				</td>
				<td>
					<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($glList, 'gl_a', 'gl_a'),array('class'=>'span','name'=>'Bankacct['.$x.'][gl_acct_cd]','disabled'=>$row->save_flg!='Y'?'disabled':'')); ?>
					<input type="hidden" name="Bankacct[<?php echo $x ?>][old_gl_acct_cd]" value="<?php echo $row->old_gl_acct_cd ?>" />
				</td>
				<td>
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','maxlength'=>12,'name'=>'Bankacct['.$x.'][sl_acct_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
					<input type="hidden" name="Bankacct[<?php echo $x ?>][old_sl_acct_cd]" value="<?php echo $row->old_sl_acct_cd ?>" />
				</td>
				<td>
					<?php echo $form->textField($row,'bank_acct_cd',array('class'=>'span','maxlength'=>20,'name'=>'Bankacct['.$x.'][bank_acct_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
					<input type="hidden" name="Bankacct[<?php echo $x ?>][old_bank_acct_cd]" value="<?php echo $row->old_bank_acct_cd ?>" />
				</td>
				<td>
					<?php echo $form->textField($row,'bank_acct_type',array('class'=>'span','maxlength'=>2,'name'=>'Bankacct['.$x.'][bank_acct_type]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
					<input type="hidden" value="<?php echo $row->old_bank_acct_type ?>" />
				</td>
				<td>
					<?php echo $form->textField($row,'brch_cd',array('class'=>'span','maxlength'=>3,'name'=>'Bankacct['.$x.'][brch_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
					<input type="hidden" value="<?php echo $row->old_brch_cd ?>" />
				</td>
				<td>
					<?php echo $form->textField($row,'folder_prefix',array('class'=>'span','maxlength'=>2,'name'=>'Bankacct['.$x.'][folder_prefix]','readonly'=>$row->save_flg!='Y'?'readonly':'','onChange'=>'searchPrefix(this)')); ?>
					<input type="hidden" value="<?php echo $row->old_folder_prefix ?>" />
				</td>
				<td>
					<?php echo $form->textField($row,'curr_cd',array('class'=>'span','maxlength'=>3,'name'=>'Bankacct['.$x.'][curr_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'','value'=>$model->isNewRecord?'IDR':$row->curr_cd)); ?>
					<input type="hidden" value="<?php echo $row->old_curr_cd ?>" />
				</td>
				<td>
					<?php echo $form->textField($row,'closed_date',array('class'=>'span tdate closedDate','name'=>'Bankacct['.$x.'][closed_date]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
					<input type="hidden" value="<?php echo $row->old_closed_date ?>" />
				</td>
				<td>
					<a 
						title="<?php if($row->old_bank_acct_cd) echo 'cancel';else echo 'delete'?>" 
						onclick="<?php if($row->old_bank_acct_cd) echo 'checkCancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
						<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
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
	
	<div style="display:none">
		<?php echo $form->datePickerRow($model,'approved_dt'); ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnSubmit'),
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php 
	if($model->isNewRecord)$new=1;
	else
		$new=0;
?>

<script>
	
	var rowCount = <?php echo count($modelAcct) ?>;
	var prefixList = [];
	
	if(<?php echo $new ?>)
	{
		assignBankCd();
		$('[name="Bankacct[1][save_flg]"]').trigger('change');
	}
	
	$(window).resize(function() {
		var body = $("#tableAcct").find('tbody');
		if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
		{
			$('thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('thead').css('width', '100%');	
		}
		
		alignColumn();
	})
	$(window).trigger('resize');
	
	$("#bankCd").change(function()
	{
		assignBankCd();	
	});
	
	$("#btnSubmit").click(function()
	{
		assignRowCount();
	});
	
	init();
	
	function init()
	{
		cancel_reason();
		
		var x = 0;
		<?php foreach($prefixList as$row){ ?>
			prefixList[x] = [];
			prefixList[x]['folder_prefix'] = '<?php echo $row->folder_prefix ?>';
			prefixList[x]['gl_acct_cd'] = '<?php echo $row->gl_acct_cd ?>';
			prefixList[x]['sl_acct_cd'] = '<?php echo $row->sl_acct_cd ?>';
			prefixList[x]['bank_acct_cd'] = '<?php echo $row->bank_acct_cd ?>';
			x++;
		<?php } ?>
		
		$(".closedDate").datepicker({format : "dd/mm/yyyy"});
	}
	
	function searchPrefix(obj)
	{
		var stop = false;
		prefixList.forEach(function(entry){
			if(entry['folder_prefix'] === $(obj).val() && stop == false)
			{
				alert('Folder prefix: ' + entry['folder_prefix']+ ' is already used by Bank Account: ' + entry['bank_acct_cd'] + '\n and GL Account: ' + entry['gl_acct_cd'].trim() + ' ' + entry['sl_acct_cd']);
				stop = true;
			}
		});
	}
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableAcct").find('thead');
		var firstRow = $("#tableAcct").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
		firstRow.find('td:eq(10)').css('width',header.find('th:eq(10)').width() + 'px');
	}
	
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		if(!$(obj).is(':checked') && $("#tableAcct tbody tr:eq("+x+") td:eq(4) [type=hidden]").val())resetValue(obj,x); // Reset Value when the checkbox is unchecked and the row contains an existing record
		
		$("#tableAcct tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableAcct tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')||readonly?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(2) select").attr("disabled",!$(obj).is(':checked')?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(8) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableAcct tbody tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(10) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function resetValue(obj, x)
	{
		$("#tableAcct tbody tr:eq("+x+") td:eq(1) [type=text]").val($("#bankCd").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(2) select").val($("#tableAcct tbody tr:eq("+x+") td:eq(2) [type=hidden]").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(3) [type=text]").val($("#tableAcct tbody tr:eq("+x+") td:eq(3) [type=hidden]").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(4) [type=text]").val($("#tableAcct tbody tr:eq("+x+") td:eq(4) [type=hidden]").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(5) [type=text]").val($("#tableAcct tbody tr:eq("+x+") td:eq(5) [type=hidden]").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(6) [type=text]").val($("#tableAcct tbody tr:eq("+x+") td:eq(6) [type=hidden]").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(7) [type=text]").val($("#tableAcct tbody tr:eq("+x+") td:eq(7) [type=hidden]").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(8) [type=text]").val($("#tableAcct tbody tr:eq("+x+") td:eq(8) [type=hidden]").val());
		$("#tableAcct tbody tr:eq("+x+") td:eq(9) [type=text]").val($("#tableAcct tbody tr:eq("+x+") td:eq(9) [type=hidden]").val());
	}
	
	function assignBankCd()
	{
		var x;
		for(x = 1;x <= rowCount;x++)
		{
			$('[name = "Bankacct['+x+'][bank_cd]"]').val($("#bankCd").val());
		}
	}
	
	function addRow()
	{
		$("#tableAcct").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row1')
    			.append($('<td>')
					.append($('<input>')
						.attr('name','Bankacct[1][save_flg]')
						.attr('type','checkbox')
						.attr('onChange','rowControl(this,true)')
						.prop('checked',true)
						.val('Y')
					)
				)
        		.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][bank_cd]')
               		 	.attr('type','text')
               		 	.attr('value',$("#bankCd").val())
               		 	.attr('readonly','readonly')
               		)
				).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][gl_acct_cd]')
               			<?php foreach($glList as $row){ ?>
               			.append($('<option>')
               				.attr('value','<?php echo $row->gl_a ?>')
               				.html('<?php echo $row->gl_a ?>')
               			)
               			<?php } ?>
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][sl_acct_cd]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][bank_acct_cd]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][bank_acct_type]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][brch_cd]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][folder_prefix]')
               		 	.attr('type','text')
               		 	.attr('onChange','searchPrefix(this)')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Bankacct[1][curr_cd]')
               		 	.attr('type','text')
               		 	.attr('value','IDR')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tdate')
               		 	.attr('name','Bankacct[1][closed_date]')
               		 	.attr('type','text')
               		 	.val('01/01/2050')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	)	
               	.append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)  	
    		);
    	rowCount++;
    	reassignId();
    	$(window).trigger('resize');
	}
	
	function reassignId()
   	{
   		for(x=0;x<rowCount;x++)
   		{
			$("#tableAcct tbody tr:eq("+x+")").attr("id","row"+(x+1));	
			$("#tableAcct tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Bankacct["+(x+1)+"][save_flg]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Bankacct["+(x+1)+"][save_flg]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Bankacct["+(x+1)+"][cancel_flg]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(1) [type=text]").attr("name","Bankacct["+(x+1)+"][bank_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(2) select").attr("name","Bankacct["+(x+1)+"][gl_acct_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_gl_acct_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(3) [type=text]").attr("name","Bankacct["+(x+1)+"][sl_acct_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_sl_acct_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(4) [type=text]").attr("name","Bankacct["+(x+1)+"][bank_acct_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_bank_acct_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(5) [type=text]").attr("name","Bankacct["+(x+1)+"][bank_acct_type]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_bank_acct_type]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(6) [type=text]").attr("name","Bankacct["+(x+1)+"][brch_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(6) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_brch_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(7) [type=text]").attr("name","Bankacct["+(x+1)+"][folder_prefix]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(7) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_folder_prefix]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(8) [type=text]").attr("name","Bankacct["+(x+1)+"][curr_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(8) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_curr_cd]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(9) [type=text]").attr("name","Bankacct["+(x+1)+"][closed_date]");
			$("#tableAcct tbody tr:eq("+x+") td:eq(9) [type=hidden]").attr("name","Bankacct["+(x+1)+"][old_closed_date]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Bankacct["+(x+1)+"][cancel_flg]']").val())
				$("#tableAcct tbody tr:eq("+x+") td:eq(10) a:eq(0)").attr('onClick',"checkCancel(this,'"+$("[name='Bankacct["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableAcct tbody tr:eq("+x+") td:eq(10) a:eq(0)").attr('onClick',"deleteRow(this)");
   			}
   		}
   	}
   	
   	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignId();
		$(window).trigger('resize');
	}
	
	function checkCancel(obj, cancel_flg, rowSeq)
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCancel'); ?>',
			'dataType' : 'json',
			'data'     : {
							'gl_acct_cd' : $('[name = "Bankacct['+rowSeq+'][gl_acct_cd]"]').val(),
							'sl_acct_cd' : $('[name = "Bankacct['+rowSeq+'][sl_acct_cd]"]').val(),
						}, 
			'success'  : function(data){
				if(data.content.found)
				{
					alert('Data ini tidak boleh dihapus');
				}
				else
				{
					cancel(obj, cancel_flg, rowSeq);
				}
			},
			'statusCode':
			{
				403		: function(data){
					alert('You are not authorized to perform this action');
				}
			}
		});
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
		$('[name="Bankacct['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
		$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
		
		$("#tableAcct tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
		
		cancel_reason();
	}
	
	function cancel_reason()
	{
		var cancel_reason = false;
		
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
	
	function assignRowCount()
	{
		$("#rowCount").val(rowCount);
	}
</script>
