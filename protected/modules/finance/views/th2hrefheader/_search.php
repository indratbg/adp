<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'trf_id',array('class'=>'span2','maxlength'=>8)); ?>
	<?php echo $form->dropDownListRow($model,'kbb_type1',array(''=>'ALL','1'=>'AP','2'=>'AR','3'=>'PE to RDI Penarikan','4'=>'RDI to Client','9'=>'Online transfer'),array('id'=>'kbbType1')); ?>
	
	<div id="kbbType2_div">
		<?php echo $form->dropDownListRow($model,'kbb_type2',array(''),array('id'=>'kbbType2')); ?>
	</div>
	
	<?php echo $form->dropDownListRow($model,'branch_group',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'KBBGRP' AND prm_desc <> 'XX'",'order'=>'prm_cd_2')),'prm_desc','prm_desc'),array('id'=>'branchGroup','prompt'=>'ALL')); ?>
	
	<div class="control-group">
		<?php echo $form->label($model,'trf_date',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'trf_date_date',array('maxlength'=>'2','class'=>'span1','placeholder'=>'dd')); ?>
			<?php echo $form->textField($model,'trf_date_month',array('maxlength'=>'2','class'=>'span1','placeholder'=>'mm')); ?>
			<?php echo $form->textField($model,'trf_date_year',array('maxlength'=>'4','class'=>'span1','placeholder'=>'yyyy')); ?>
		</div>
	</div>
	
	<?php echo $form->dropDownListRow($model,'trf_status',array('%'=>'ALL','S'=>'SENT','W'=>'WAITING'),array('id'=>'trfStatus')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	$(document).ready(function()
	{
		changeType();
	});

	$("#kbbType1").change(function()
	{
		changeType();
	});
	
	function changeType()
	{
		switch($("#kbbType1").val())
		{
			case '<?php echo AConstant::KBB_TYPE_AP ?>':
			case '<?php echo AConstant::KBB_TYPE_AR ?>':
				$("#kbbType2").empty()
				$("#kbbType2_div").hide();
				break;
				
			case '<?php echo AConstant::KBB_TYPE_TO_RDI ?>':
				fillType(['PENARIKAN','FEE']);
				break;
				
			case '<?php echo AConstant::KBB_TYPE_TO_CLIENT ?>':
				fillType(['BCA','LLG','RTGS']);
				break;
				
			default:
				$("#kbbType2").empty();
				$("#kbbType2_div").hide();
				break;
		}
	}
	
	function fillType(typeArr)
	{
		$("#kbbType2").empty();
		$("#kbbType2").append($("<option>").html("ALL").val(''));
		
		$.each(typeArr,function(key,value)
		{
			$("#kbbType2").append($("<option>").attr('value',value).html(value));
		});
		
		$("#kbbType2_div").show();
	}
</script>
