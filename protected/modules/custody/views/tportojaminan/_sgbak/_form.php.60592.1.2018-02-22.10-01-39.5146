<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tportojaminan-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->datePickerRow($model,'from_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span3','value'=>!$model->client_cd?Company::model()->find()->other_1:$model->client_cd)); ?>
	
	<?php echo $form->dropDownListRow($model,'stk_cd',CHtml::listData(Counter::model()->findAll(array('select'=>'stk_cd,stk_desc','condition'=>"approved_stat = 'A'",'order'=>'stk_cd')),'stk_cd','StockCdAndDesc'),array('class'=>'span6','prompt'=>'-Select Stock-')); ?>
	
	<?php echo $form->textFieldRow($model,'qty',array('class'=>'span3 tnumber','maxlength'=>16,'style'=>'text-align:right')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
