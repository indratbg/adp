<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'stk_cd',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'stk_desc',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->dropDownListRow($model, 'ctr_type', Parameter::getCombo('CTRTYP','-Choose Stock Type-'),array('class'=>'span3','id'=>'ctrtype')); ?>

	<div class="control-group">
		<?php echo $form->label($model,'pp_to_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'pp_to_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'pp_to_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'pp_to_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
