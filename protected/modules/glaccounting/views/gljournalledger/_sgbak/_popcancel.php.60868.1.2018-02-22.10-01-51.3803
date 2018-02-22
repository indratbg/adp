<?php if($is_successsave): ?>
<script>
	window.parent.closePopupModalAndRedirect('<?php echo Yii::app()->createUrl('/glaccounting/Gljournalledger/index'); ?>')
</script>
<?php endif; ?>

<style>
	.form-horizontal .controls{margin-left: 0px;}
	.form-actions{text-align: right;}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'id'=>'menuaction-form', 
    'enableAjaxValidation'=>false, 
    'type'=>'horizontal' 
)); ?>
	<?php if(!$is_successsave)AHelper::showFlash($this) ?>
	<?php echo $form->errorSummary(array($model,$model1,$model2)); ?>
	<?php 
		if(isset($modelfolder)) echo $form->errorSummary(array($modelfolder));
	?>
	
	<?php if(isset($modeltrepovch)){
		
		echo $form->errorSummary(array($model,$model1,$model2,$modelrepo,$modeltrepovch));
	}
	 ?>
<?php 
		foreach($modelreversal as $row)
			echo $form->errorSummary(array($row)); 
	?>

	<?php echo $form->textAreaRow($model, 'cancel_reason', array('class'=>'span5', 'rows'=>5,'label'=>false)); ?>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType'=>'submit', 
            'type'=>'primary', 
            'label'=>'Save', 
        )); ?>
    </div> 
<?php $this->endWidget(); ?>
