<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'prm_cd_2',array('class'=>'span2','maxlength'=>6,'readonly'=>true)); ?>

	<?php echo $form->dropDownListRow($model,'prm_desc',array('Y'=>'BLOCKED','N'=>'UNBLOCKED'),array('class'=>'span3')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
