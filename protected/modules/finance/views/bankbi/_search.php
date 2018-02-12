<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>

	<?php echo $form->textFieldRow($model,'bi_code',array('class'=>'span5','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'bank_name',array('class'=>'span5','maxlength'=>255)); ?>
	<?php echo $form->dropDownListRow($model,'ip_bank_cd',CHtml::listData(Ipbank::model()->findAll(
						array('condition'=>"approved_stat='A' ", 'order'=>'bank_cd' )), 'bank_cd', 'DropDownName'),
						array('class'=>'span5','id'=>'ip_bank_cd','prompt'=>'-Choose IP Bank-')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>