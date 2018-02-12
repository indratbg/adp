<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tipoclient-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php if($model->isNewRecord): ?>
		<?php echo $form->dropdownListRow($model,'stk_cd',Chtml::listData(Tpee::model()->findAll($criteria_stk),'stk_cd','stk_cd'),array('class' => 'span2')); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'stk_cd',array('class' => 'span2', 'readonly' => 'readonly')); ?>
	<?php endif; ?>
<!--	
	<?php if(!$client): ?>
		<?php echo $form->textFieldRow($model,'client_name',array('class'=>'span5','maxlength'=>50,'readonly' => 'readonly')); ?>
		<?php echo $form->textFieldRow($model,'branch_code',array('class'=>'span1','maxlength'=>3,'readonly' => 'readonly')); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'client_name',array('class'=>'span5','maxlength'=>50,'readonly' => 'readonly','value'=>$client->client_name)); ?>
		<?php echo $form->textFieldRow($model,'branch_code',array('class'=>'span1','maxlength'=>3,'readonly' => 'readonly','value'=>$client->branch_code)); ?>
	<?php endif; ?>
-->	
	<?php echo $form->dropdownListRow($model,'client_cd',Chtml::listData(Client::model()->findAll($criteria_client),'client_cd','CodeAndName'),array('class' => 'span7','prompt'=>'-Pilih Client-')); ?>
	
	<?php echo $form->textFieldRow($model,'brch_cd',array('class'=>'span2','readonly'=>'readonly')) ?>
	
	<?php if(!$model->getAttribute('fixed_qty')): ?>	
		<?php echo $form->textFieldRow($model,'fixed_qty',array('class'=>'span3 tnumber','maxlength'=>16,'style'=>'text-align:right','value'=>0)); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'fixed_qty',array('class'=>'span3 tnumber','maxlength'=>16,'style'=>'text-align:right')); ?>
	<?php endif; ?>
	
	<?php if(!$model->getAttribute('pool_qty')): ?>
		<?php echo $form->textFieldRow($model,'pool_qty',array('class'=>'span3 tnumber','maxlength'=>16,'style'=>'text-align:right','value'=>0)); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'pool_qty',array('class'=>'span3 tnumber','maxlength'=>16,'style'=>'text-align:right')); ?>
	<?php endif; ?>
	
	<?php if(!$model->getAttribute('alloc_qty')): ?>
		<?php echo $form->textFieldRow($model,'alloc_qty',array('class'=>'span3 tnumber','maxlength'=>16,'style'=>'text-align:right','value'=>0)); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'alloc_qty',array('class'=>'span3 tnumber','maxlength'=>16,'style'=>'text-align:right')); ?>
	<?php endif; ?>
	<?php if(!$model->getAttribute('ipo_perc')): ?>
		<?php echo $form->textFieldRow($model,'ipo_perc',array('class'=>'span3 tnumber','maxlength'=>3,'style'=>'text-align:right','value'=>1)); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'ipo_perc',array('class'=>'span3 tnumber','maxlength'=>3,'style'=>'text-align:right')); ?>
	<?php endif; ?>
	
	<?php echo $form->textFieldRow($model,'batch',array('id'=>'batch','class'=>'span3','maxlength'=>10)); ?>
	
	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>

	$('#Tipoclient_client_cd').change(function(){
		fillBrchCd();
	});
	
	function fillBrchCd()
	{
		var client_cd = $('#Tipoclient_client_cd').val();
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetBrchCd'); ?>',
			'dataType' : 'json',
			'data'     : {'client_cd' : client_cd},
			'success'  : function(data){
				var result = data.content;
				$('#Tipoclient_brch_cd').val(result.branch_code);
			}
		});
	}
	
	$("#batch").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});

</script>