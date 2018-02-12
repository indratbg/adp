<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->datePickerRow($model,'status_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	<?php echo $form->dropDownListRow($model,'stk_cd',CHtml::listData(Counter::model()->findAllBySql('SELECT STK_CD FROM MST_COUNTER WHERE CTR_TYPE <>\'OB\' AND APPROVED_STAT = \'A\'ORDER BY 1'),'stk_cd','stk_cd'),array('class'=>'span3','prompt'=>'-Select Stock Code-')); ?>
	
	
	<?php echo $form->textFieldRow($model,'haircut',array('class'=>'span5','maxlength'=>50,'rows'=>3)); ?>
	
	
	<?php echo $form->datePickerRow($model,'eff_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

