<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bankacct-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'bank_cd',array('class'=>'span5','maxlength'=>3)); ?>

	<?php echo $form->textFieldRow($model,'sl_acct_cd',array('class'=>'span5','maxlength'=>12)); ?>

	<?php echo $form->textFieldRow($model,'bank_acct_cd',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'chq_num_mask',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'bank_acct_type',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'brch_cd',array('class'=>'span5','maxlength'=>3)); ?>

	<?php echo $form->textFieldRow($model,'folder_prefix',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'gl_acct_cd',array('class'=>'span5','maxlength'=>12)); ?>

	<?php echo $form->textFieldRow($model,'curr_cd',array('class'=>'span5','maxlength'=>3)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
