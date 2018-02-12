<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->dropDownListRow($model,'kategori',AConstant::$highrisk_kategori,array('class'=>'span3','prompt'=>'All')); ?>
	
	<?php echo $form->textFieldRow($model,'descrip',array('class'=>'span5','maxlength'=>80)); ?>
	<div class="control-group">
		<?php echo $form->label($model,'ref_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'ref_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'ref_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'ref_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
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
