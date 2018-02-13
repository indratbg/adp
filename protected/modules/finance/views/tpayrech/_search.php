<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'payrec_num',array('class'=>'span5','maxlength'=>17)); ?>
	<?php echo $form->dropDownListRow($model,'payrec_type',array(''=>'ALL','R'=>'RECEIPT','P'=>'PAYMENT'),array('class'=>'span5')); ?>
	<div class="control-group">
		<?php echo $form->label($model,'payrec_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'payrec_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'payrec_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'payrec_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5','maxlength'=>12)); ?>
	<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span5','maxlength'=>8)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
