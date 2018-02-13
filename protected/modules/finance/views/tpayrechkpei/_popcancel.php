<?php 
if($is_successsave): ?>
<script>
	window.parent.closePopupModalAndRedirect('<?php echo $this->createUrl('index') /*Yii::app()->createUrl('/finance/tpayrechkpei/index');*/ ?>')
</script>
<?php endif; ?>

<style>
	.form-horizontal .controls{margin-left: 0px;}
	.form-actions{text-align: right;}
</style>

<?php if(!$is_successsave)AHelper::showFlash($this) ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'id'=>'menuaction-form', 
    'enableAjaxValidation'=>false, 
    'type'=>'horizontal' 
)); ?>
	
	<?php 
		echo $form->errorSummary($model); 
	 	echo $form->errorSummary($modelHeader); 
	 	echo $form->errorSummary($modelDetail); 
		foreach($reverseModelJournal as $row)echo $form->errorSummary($row); 	
	 	echo $form->errorSummary($modelFolder); 
		echo $form->errorSummary($modelJvchh);
	 	echo $form->errorSummary($reverseModelFolder);
		foreach($modelCheq as $row)echo $form->errorSummary($row); 	 
	 ?>

	<?php  echo $form->textAreaRow($model, 'cancel_reason', array('class'=>'span5', 'rows'=>5,'label'=>false)); ?>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType'=>'submit', 
            'type'=>'primary', 
            'label'=>'Save', 
        )); ?>
    </div> 
<?php $this->endWidget(); ?>
