<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>


	<?php //echo $form->textFieldRow($model,'doc_num',array('class'=>'span5'));?>
	<?php echo $form->textFieldRow($model,'client_cd',array('class'=>'span5'));?>
	<?php echo $form->textFieldRow($model,'client_name',array('class'=>'span5'));?>
	<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span5'));?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
