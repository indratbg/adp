<?php
/* @var $this FixedAssetMovementController */
/* @var $model FixedAssetMovement */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>


		<?php echo $form->datePickerRow($model,'doc_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		<?php echo $form->textFieldRow($model,'asset_cd',array('class'=>'span2','id'=>'asset_cd'));?>
		<?php echo $form->dropDownListRow($model,'mvmt_type',Fixedassetmovement::$mvmt,array('class'=>'span2','style'=>'font-family:courier','id'=>'mvmt_type'));?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->