<style>
	#tableInt
	{
		background-color:#C3D9FF;
	}
	#tableInt thead, #tableInt tbody
	{
		display:block;
	}
	#tableInt tbody
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
	'id'=>'tinterestrate-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
		foreach($modelInt as $row)
			echo $form->errorSummary(array($row)); 
	?>

	<?php 
		//foreach($oldModel as $row)
		//	echo $form->errorSummary(array($row)); 
	?>
	<div class="row-fluid">
		
		<div class="span5">
		
		<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','disabled'=>'disabled')); ?>
		</div>
		<div class="span7">
			<div class="span2" style="margin-right:-3px">
				<?php echo $form->label($model,'Name',array('for'=>'clientType','class'=>'control-label')) ?>
			</div>
			<?php echo $form->textField($model,'client_name',array('class'=>'span5','disabled'=>'disabled')); ?>
		</div>


	</div>

	
	
	
	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->textFieldRow($model,'branch_code',array('class'=>'span3','disabled'=>'disabled')); ?>
		</div>
		<div class="span7">
			<div class="span1">
				<?php echo $form->label($model,'Client Type',array('for'=>'clientType','class'=>'control-label')) ?>
			</div>
			<div class="span2">
				<?php echo $form->textFieldRow($model,'client_type',array('class'=>'span','id'=>'clientType','disabled'=>'disabled','label'=>false,'value'=>$model->client_type_1.$model->client_type_2.$model->client_type_3)); ?>
			</div>
			<?php echo $form->textField($model,'Client Type',array('class'=>'span4','disabled'=>'disabled','value'=>Lsttype3::model()->find("cl_type3 = '$model->client_type_3'")->cl_desc)); ?>
		</div>
	</div>
<!--	
	<br/><br/>
	
	<?php echo $form->textFieldRow($model,'Client Type',array('class'=>'span3','disabled'=>'disabled','value'=>Lsttype3::model()->find("cl_type3 = '$model->client_type_3'")->cl_desc)); ?>
-->	
	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->label($model,'Calculation Mode',array('class'=>'control-label')) ?>
			<?php echo $form->radioButtonListInlineRow($model,'amt_int_flg',array('Y'=>'System','N'=>'Manual'),array('label'=>false)) ?>
		</div>
		<div class="span2">
			<div class="span2">
				<label>PPH23</label>
			</div>
			<div style="margin-left: 80px;">
				<?php //echo $form->checkBoxListRow($model,'tax_on_interest',array('Y'=>''),array('id'=>'taxOnInterest','label'=>false)) ?>
				<?php echo $form->checkBox($model,'tax_on_interest',array('value'=>'Y','uncheckValue'=>'N','id'=>'taxOnInterest','disabled'=>!DAO::queryRowSql("SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'CLIENT MASTER' AND param_cd1 = 'INTTAX' AND param_cd2 = 'DEFAULT' AND dflg1 = 'Y'")));?>
			</div>
		
		</div>
	</div>
	<div class="row-fluid">
		<label class="control-label">Days in one year</label>
	</div>
	<div class="row-fluid">
		<div class="span5">
		<label class="control-label">AR</label>
			<?php echo $form->textFieldRow($model,'int_rec_days',array('class'=>'span3','disabled'=>'disabled','label'=>false,'style'=>'text-align:right')); ?>
		</div>
		<div class="span4">
			<div class="span4">
				<label class="control-label">AP</label>
			</div>
		<?php echo $form->textFieldRow($model,'int_pay_days',array('class'=>'span3','disabled'=>'disabled','label'=>false,'style'=>'text-align:right')); ?>
		</div>
	</div>
	<!--
	<div class="row-fluid">
		<div class="span2">
			<div class="span1">
				<label class="control-label">PPH23</label>
			</div>
			<?php // echo $form->checkBoxListInlineRow($model,'tax_on_interest',array('Y'=>''),array('id'=>'taxOnInterest','label'=>false)) ?>
		</div>
	</div>
	-->
	<br/>
	
	<input type="hidden" id="rowCount" name="rowCount"/>
	
	<table id='tableInt' class='table-bordered table-condensed' style="width:70%;">
		<thead>
			<tr>
				<th width="3%"></th>
				<th width="10%">Effective Date</th>
				<th width="15%">AR</th>
				<th width="15%">AP</th>
				<th width="5%">
					<a style="cursor:pointer;" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelInt as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
				<td>
					<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tinterestrate['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
				<?php if($row->old_eff_dt): ?>
					<input type="hidden" name="Tinterestrate[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
				</td>
				
				<td><?php echo $form->textField($row,'eff_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Tinterestrate['.$x.'][eff_dt]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
					<input type="hidden" name="Tinterestrate[<?php echo $x ?>][old_eff_dt]" value="<?php echo $row->old_eff_dt ?>"/>
					
				</td>
				
				<td><?php echo $form->textField($row,'int_on_receivable',array('class'=>'span tnumber','name'=>'Tinterestrate['.$x.'][int_on_receivable]','style'=>'text-align:right','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?></td>
				<td><?php echo $form->textField($row,'int_on_payable',array('class'=>'span tnumber','name'=>'Tinterestrate['.$x.'][int_on_payable]','style'=>'text-align:right','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?></td>
				
				<td style="cursor:pointer;">
					<a 
						title="<?php if($row->old_eff_dt) echo 'cancel';else echo 'delete'?>" 
						onclick="<?php if($row->old_eff_dt) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
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
			'id'=>'btnSubmit',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
<?php echo $form->datePickerRow($model,'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php $this->endWidget(); ?>

<script>
	var rowCount = <?php echo count($modelInt) ?>;
	var authorizedCancel = true;
	
	init();

	$("#btnSubmit").click(function()
	{
		assignHiddenValue();
	});
	
	function init()
	{
		var x;
		
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
		
		for(x=0;x<rowCount;x++)
		{
			$("#tableInt tbody tr:eq("+x+") td:eq(1) input").datepicker({format : "dd/mm/yyyy"});
		}
		cancel_reason();
	}

	function addRow()
	{
		$("#tableInt").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
				.append($('<input>')
					.attr('name','Tinterestrate[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			)
			
        	.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tdate')
               		 	.attr('name','Tinterestrate[1][eff_dt]')
               		 	.attr('type','text')
               		 	.attr('placeholder','dd/mm/yyyy')
               		 	//.datepicker({format : "dd/mm/yyyy"})
               		)
               		
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tinterestrate[1][int_on_receivable]')
               		 	.attr('type','text')
               		 	.attr('onChange','addCommas(this)')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tinterestrate[1][int_on_payable]')
               		 	.attr('type','text')
               		 	.attr('onChange','addCommas(this)')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow()')
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
    	
    	rowCount++;
    	formatDate();
    	reassignAttribute();
	}
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignAttribute();
	}
	
	function addCommas(obj)
	{
		$(obj).val(setting.func.number.addCommas(setting.func.number.removeCommas($(obj).val())));
	}
	
	function assignHiddenValue()
	{
		$("#rowCount").val(rowCount);
	}
	function rowControl(obj)
	{ 
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableInt tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		
		$("#tableInt tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableInt tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableInt tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableInt tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableInt tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(6) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function reassignAttribute()
	{
		for(x = 0; x<rowCount; x++)
		{
			//Re-assign id untuk row agar urut sesuai dengan baris
			$("#tableInt tbody tr:eq("+x+")").attr("id","row"+(x+1));
			$("#tableInt tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Tinterestrate["+(x+1)+"][save_flg]");
			$("#tableInt tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Tinterestrate["+(x+1)+"][cancel_flg]");
			$("#tableInt tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Tinterestrate["+(x+1)+"][save_flg]");
			$("#tableInt tbody tr:eq("+x+") td:eq(1) [type=text]").attr("name","Tinterestrate["+(x+1)+"][eff_dt]");
			$("#tableInt tbody tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Tinterestrate["+(x+1)+"][old_eff_dt]");
			
			$("#tableInt tbody tr:eq("+x+") td:eq(2) [type=text]").attr("name","Tinterestrate["+(x+1)+"][int_on_receivable]");
			$("#tableInt tbody tr:eq("+x+") td:eq(3) [type=text]").attr("name","Tinterestrate["+(x+1)+"][int_on_payable]");
		}
			//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Tinterestrate["+(x+1)+"][cancel_flg]']").val())
				$("#tableInt tbody tr:eq("+x+") td:eq(4) a:eq(0)").attr('onClick',"cancel(this,'"+$("[name='Tinterestrate["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableInt tbody tr:eq("+x+") td:eq(4) a:eq(0)").attr('onClick',"deleteRow(this)");
   			}
   		}
	}
	$(window).resize(function() {
		var body = $("#tableInt").find('tbody');
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
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableInt").find('thead');
		var firstRow = $("#tableInt").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		
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
			$('[name="Tinterestrate['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableInt tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
		}
		else
			alert('You are not authorized to perform this action');	
		}
		
	function formatDate(){
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	}	
	
</script>