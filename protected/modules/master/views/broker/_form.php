<style>
	form table tr td{padding: 0px;}
	.help-inline.error{display: none;}
	
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'broker-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model,'broker_cd',array('class'=>'span3','maxlength'=>7)); ?>
	
	<?php echo $form->textFieldRow($model,'broker_name',array('class'=>'span3','maxlength'=>8)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
<?php $this->endWidget(); ?>