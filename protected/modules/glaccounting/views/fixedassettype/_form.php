<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model,'prm_cd_2',array('class'=>'span2','maxlength'=>6)); ?>

	<?php echo $form->textAreaRow($model,'prm_desc',array('class'=>'span5','maxlength'=>255,'rows'=>3)); ?>
	
	<div class="row-fluid">
		<?php echo $form->label($model,'GL Account Debit'.CHtml::$afterRequiredLabel,array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'gl_acct_db',array('class'=>'span2','maxlength'=>4)); ?>
		<?php echo $form->textField($model,'sl_acct_db',array('class'=>'span2','maxlength'=>6)); ?>
	</div>
	
	<div class="row-fluid">
		<?php echo $form->label($model,'GL Account Credit'.CHtml::$afterRequiredLabel,array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'gl_acct_cr',array('class'=>'span2','maxlength'=>4)); ?>
		<?php echo $form->textField($model,'sl_acct_cr',array('class'=>'span2','maxlength'=>6)); ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
