<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'reks_cd',array('class'=>'span5','maxlength'=>25)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'nab_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'nab_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'nab_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'nab_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'nab_unit',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'nab',array('class'=>'span5')); ?>

	<div class="control-group">
		<?php echo $form->label($model,'mkbd_dt',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'mkbd_dt_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'mkbd_dt_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'mkbd_dt_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
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
