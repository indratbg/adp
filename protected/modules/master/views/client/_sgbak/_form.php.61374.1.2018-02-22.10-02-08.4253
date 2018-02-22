<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
	.tnumber{text-align:right;}
</style>

<?php 	
	$base = Yii::app()->baseUrl;
	$urlMasked = $base.'/js/jquery.maskedinput.js';
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<script type="text/javascript" src='<?php echo $urlMasked;?>'></script>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model,$modelCif,$modelClientindi,$modelClientEmergency)); ?>
	
	<?php foreach($modelClientBank as $row)echo $form->errorSummary($row) ?>

	<?php if($model->isNewRecord && !$render): ?>
	<div class="row-fluid">
		<div class="span12">
			<div class="span6">
				<?php //echo $form->dropDownListRow($model,'searched_cif',Chtml::listData(Cif::model()->findAll(),'cifs', 'CifAndCifname'),array('prompt'=>'New')); ?>
				<div class="control-group">
					<?php echo $form->label($model,'searched_cif',array('class'=>'control-label')); ?>
					<div class = "controls">
						<?php echo $form->dropDownlist($model,'cif_opt',Client::$cif_option,array('class'=>'span3','id'=>'dd_cif')); ?>
		        		<?php $this->widget('application.extensions.widget.JuiAutoCompleteStd', array(
												'model'=>$model,
												'attribute'=>'searched_cif',
												'ajaxlink'=>array('getcif'),
												'options'=>array('minLength'=>1),
												'htmlOptions'=>array(
																'id'=>'auto_comp_cif',
																'name'=>'auto_comp_cif',
																'class'=>'span6',
																),
										)); ?>
		        		
					</div> <!-- Controls -->
				</div> <!-- Control-group -->
				
			</div>
		<!-- <div class="span6"><?php echo $form->dropDownListRow($model,'client_type_1',Chtml::listData(Lsttype1::model()->findAll(),'cl_type1', 'cl_desc')); ?></div> -->
			<div class="span6" id="copyClient_div">
				<?php echo $form->textFieldRow($model,'copy_client',array('id'=>'copyClient','class'=>'span3')); ?>
			</div>
		</div>
		
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=> array('name'=>'submit','value'=>'render'),
			'label'=>'Retrieve',
		)); ?>
	</div>
	<br />
	<?php endif; ?>
	<?php if($render):?>
	<?php echo $this->renderPartial('_form_after_validate', array('model'=>$model,'modelClientindi'=>$modelClientindi,
												'modelCif'=>$modelCif,'modelClientBank'=>$modelClientBank,'modelClientEmergency'=>$modelClientEmergency,'modelClientMember'=>$modelClientMember,
												'minimumFeeFlg'=>$minimumFeeFlg,
												'withholdingTaxFlg'=>$withholdingTaxFlg,
												'acopenFeeFlg'=>$acopenFeeFlg,
												'taxOnInterestFlg'=>$taxOnInterestFlg,
												'pphFlg'=>$pphFlg,
												'init_deposit_cd'=>$init_deposit_cd,'cancel_reason'=>$cancel_reason)); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=> array('id'=>'btnSubmit','name'=>'submit','value'=>'submit'),
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	
	<?php endif;?>
<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	var modifyReason = false;
	
	$("#auto_comp_cif").on("autocompleteopen",function()
	{
		$(this).autocomplete("widget").width(500); 
	});
	
	$("#copyClient_div").hide();

	$('#dd_cif').change(function(){
		var cif = $('#dd_cif').val();
		if(cif == '<?php echo Client::CIF_OPTION_EXISTING?>')
		{
			$('#auto_comp_cif').show();
			$('#auto_comp_cif');
			
			//$("#copyClient_div").hide();
		}
		else
		{
			$('#auto_comp_cif').hide();
			$('#auto_comp_cif');
			
			//$("#copyClient_div").show();
		}
		$('#auto_comp_cif').val();
	});
	$('#dd_cif').trigger('change');
	
	function getModifyReason(reason)
	{
		modifyReason = true;
		
		$('#cancel_reason').prop('disabled',false);
		$('#cancel_reason').val(reason);
		$('#modal-popup').modal('hide');
		
		$('#btnSubmit').trigger('click');
	}
	
	$('#btnSubmit').click(function()
	{
		if(<?php if($model->isNewRecord)echo '0';else echo '1'; ?> && !modifyReason)
		{
			showPopupModal("Modify Reason","<?php echo Yii::app()->createUrl("/master/client/ajxPopModify",array('modifyReason'=>$cancel_reason)) ?>");
			//$("#modify_reason").val($('#cancel_reason').val());
			return false;
		}
		
		if($("#Client_commission_per").val() === '0')
		{
			if(!confirm("Commission % is 0. Do you want to continue?"))
			{
				modifyReason = false;
				return false;
			}
		}
		
		if((<?php if(!$model->isNewRecord)echo '1';else echo '0'; ?> || $("#Cif_cifs").val() != 'NEW'))
		{
			var branch_code = $("#Client_branch_code").val();
			var old_branch_code = $("#branch_hid").val();
			
			if(branch_code && branch_code != old_branch_code)
			{
				if(confirm("Do you want to apply the change you made to the Branch Code to the rest of the client members?"))
				{
					$("#branch_change_flg").val(1);
				}
				else
				{
					$("#branch_change_flg").val(0);
				}
			}
			/*else
			{
				$("#branch_change_flg").val(0);
			}*/
			
			var rem_code = $("#Client_rem_cd").val();
			var old_rem_code = $("#rem_hid").val();
			
			if(rem_code && rem_code != old_rem_code)
			{
				if(confirm("Do you want to apply the change you made to the Sales/Remisier to the rest of the client members?"))
				{
					$("#rem_change_flg").val(1);
				}
				else
				{
					$("#rem_change_flg").val(0);
				}
			}
		}
		
		$("#rowCount").val(rowCount);
	});
	
	$("input[type=text]:not(.email)").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
</script>

