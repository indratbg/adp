<?php if($is_successsave): ?>
<script>
	sendModifyReason("<?php echo $model->cancel_reason ?>");

	function sendModifyReason(reason)
	{
		window.parent.getModifyReason(reason);
	}
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
	
	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textAreaRow($model, 'cancel_reason', array('class'=>'span5', 'id'=>'modify_reason', 'name'=>'Client[modify_reason]', 'rows'=>5,'label'=>false)); ?>

    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType'=>'submit', 
            'type'=>'primary', 
            'label'=>'Save', 
        )); ?>
    </div> 
<?php $this->endWidget(); ?>
