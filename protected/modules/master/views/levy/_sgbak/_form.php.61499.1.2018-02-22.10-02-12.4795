<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'levy-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->datePickerRow($model,'eff_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php echo $form->dropDownListRow($model, 'stk_type', Constanta::$stock_type); ?>

	<?php echo $form->dropDownListRow($model, 'mrkt_type', Constanta::$market_type); ?>

	<?php echo $form->textFieldRow($model,'value_from',array('class'=>'span5','value'=>$model->value_from == ''?'0':$model->value_from)); ?>

	<?php echo $form->textFieldRow($model,'value_to',array('class'=>'span5 tnumber','value'=>$model->value_to == ''?'500000000':$model->value_to)); ?>

	<?php echo $form->textFieldRow($model,'levy_pct',array('class'=>'span5')); ?>

	<?php //echo $form->datePickerRow($model,'cre_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php //echo $form->datePickerRow($model,'upd_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php //echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>8)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
