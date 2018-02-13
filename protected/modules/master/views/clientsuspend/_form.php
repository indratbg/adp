<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientsuspend-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>




<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','readonly'=>'readonly','maxlength'=>50)); ?>

<?php echo $form->textFieldRow($model,'client_name',array('class'=>'span5','readonly'=>'readonly','maxlength'=>50)); ?>
<?php echo $form->textFieldRow($model,'branch_code',array('class'=>'span5','readonly'=>'readonly','maxlength'=>3)); ?>
<?php //echo $form->textFieldRow($model,'susp_stat',array('class'=>'span5','readonly'=>'readonly','maxlength'=>1)); ?>
<?php //echo $form->dropDownListRow($model,'susp_stat',Constanta::$sups_stat,array('class'=>'span5','disabled'=>true));?>
<div class="row-fluid">
	
	<div class="span1" style="margin-left:40px;">
		
	</div>
	<div class="span10">
	<?php echo $form->radioButtonListInlineRow($model,'status',array('N'=>'Suspended Specified Client','Y'=>'Re-activate Client'),array('label'=>false,'disabled'=>true)) ?>	
	</div>
	
</div>




<?php  echo $form->textField($model,'susp_trx',array('class'=>'span5','maxlength'=>1,'style'=>'display:none;')); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script>
	
	
</script>

