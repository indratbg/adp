<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'glaccount-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'gl_a',array('class'=>'span3','maxlength'=>4,'id'=>'glA')); ?>
	
	<?php echo $form->textFieldRow($model,'sl_a',array('class'=>'span3','maxlength'=>12,'id'=>'slA'));?> 
	
	<?php echo $form->label($model,'Account Name'.CHtml::$afterRequiredLabel,array('class'=>'control-label', 'for'=>'acctName')); ?>
	<?php echo $form->textFieldRow($model,'acct_name',array('class'=>'span3','maxlength'=>50,'label'=>false,'id'=>'acctName')); ?>
	
	<?php if(!$model->isNewRecord): ?>
		<?php echo $form->radioButtonListInlineRow($model,'acct_stat',array('A'=>'Active','C'=>'Closed')); ?>
	<?php endif; ?>
	
	<!-- DANASAKTI -->
	<?php echo $form->dropDownListRow($model,'brch_cd',CHtml::listData(Branch::model()->findAll(array('order'=>'brch_cd')),'brch_cd','brch_cd'),array('class'=>'span3','prompt'=>'-Select Branch Code-')); ?>
	<!-- END DANASAKTI -->
	
	<?php echo $form->label($model,'Printing Style'.CHtml::$afterRequiredLabel,array('class'=>'control-label', 'for'=>'prtType')); ?>
	<?php echo $form->radioButtonListRow($model,'prt_type',array('S'=>'Summary / Header only','D'=>'Detail / Normal'),array('label'=>false,'id'=>'prtType')); ?>

	<?php echo $form->textFieldRow($model,'acct_short',array('class'=>'span3','maxlength'=>20,'id'=>'acctShort')); ?>
	
	<?php echo $form->textFieldRow($model,'acct_type',array('class'=>'span3','maxlength'=>4,'id'=>'acctType')); ?>

	<?php echo $form->radioButtonListInlineRow($model,'def_cpc_cd',array('A'=>'Yes',''=>'No')); ?>
	
	<?php echo $form->textFieldRow($model,'mkbd_cd',array('class'=>'span1','maxlength'=>3)); ?>

	<?php echo $form->textFieldRow($model,'mkbd_group',array('class'=>'span1','maxlength'=>3)); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	$("#glA").change(function()
	{
		$("#acctShort").val($("#glA").val());
		getGla();
	});
	
	$('#slA').change(function()
	{	
		if($('#slA').val() === '000000')
		{
			$('#Glaccount_prt_type_0').prop('checked',true);
		}
		else
		{
			$('#Glaccount_prt_type_1').prop('checked',true);
			getGla();
		}
	})
	
	function getGla(){
		var gl_A = $('#glA').val();
		var sl_A = $('#slA').val();
		var sl_Acut = sl_A.slice(0, 1);
		$.ajax({
		    		'type'     :'POST',
		    		'url'      : '<?php echo $this->createUrl('getgla'); ?>',
					'dataType' : 'json',
					'data'		:{	
									gl_a : gl_A,
									sl_a : sl_A,
									sl_acut : sl_Acut,
									},
					'success': function(result)
								{
									$("#Glaccount_brch_cd").val(result.branch_cd);
								}
					,
					'async':false
				});
	}
</script>
