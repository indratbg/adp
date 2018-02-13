<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'securities-ledger-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'sl_code',array('class'=>'span2','maxlength'=>2)); ?>
		
			<?php echo $form->textFieldRow($model,'sl_desc',array('class'=>'span5','maxlength'=>60)); ?>
		
			<?php echo $form->textFieldRow($model,'gl_acct_cd',array('class'=>'span2','maxlength'=>2)); ?>
		
			<?php echo $form->radioButtonListInLineRow($model, 'fl_dbcr', array('D'=>'Debit', 'C'=>'Credit')); ?>
		</div>
	</div>	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->datePickerRow($model,'ver_bgn_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span6">
			<?php echo $form->datePickerRow($model,'ver_end_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>