<?php

$this->menu=array(
	array('label'=>'Process Change Ticker', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('indexprocess'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);
?>

<h1>Process Ticker Code Change</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tchangestkcd-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<input type="hidden" id="isproceed" name="isproceed" value="1" />
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
