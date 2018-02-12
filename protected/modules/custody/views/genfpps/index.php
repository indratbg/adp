<style>
	.tnumber
	{
		text-align:right
	}
	
	.help-inline.error
	{
		display: none
	}
	
	.radio.inline label
	{
		margin-left: 15px
	}
	
	#batch
	{
		margin-left: -50px;
	}
</style>

<?php
$this->menu=array(
	array('label'=>'Generate FPPS', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'genfpps-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model);
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<div class="row-fluid">
	<div class="span4" style="width:300px">
		<?php echo $form->dropDownListRow($model, 'stk_cd', CHtml::listData(Tpee::model()->findAll(array('condition'=>"distrib_dt_to > TRUNC(SYSDATE)-30 AND approved_stat = 'A'",'order'=>'stk_cd')), 'stk_cd', 'stk_cd'), array('class'=>'span6', 'id'=>'stkCd','prompt'=>'-Choose Stock-','required'=>true)) ?>
		<input type="hidden" id="stkCd_hid" value="<?php echo $model->stk_cd ?>" />
	</div>
	
	<div class="span2">
		
	</div>
	
	<div class="span4" style="width:300px">
		<?php echo $form->radioButtonListInlineRow($model, 'batch_opt', array(1=>'All', 2=>'Specified'), array('id'=>'batchOpt')) ?>
	</div>
	
	<div class="span2">
		<?php echo $form->textField($model,'batch',array('id'=>'batch','class'=>'span12')) ?>
	</div>
</div>


<div class="row-fluid">
	<div class="span4" style="width:300px">
		<?php echo $form->textFieldRow($model,'begin_subrek',array('id'=>'beginSubrek','class'=>'span6 tvalAlphaNum','maxlength'=>4)) ?>
	</div>
	
	<div class="span2">
		
	</div>
	
	<div class="span4" style="width:300px">
		<?php echo $form->radioButtonListInlineRow($model, 'format', array(1=>'Biasa', 2=>'Datindo'), array('id'=>'format')) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="width:300px">
		<?php echo $form->textFieldRow($model,'end_subrek',array('id'=>'endSubrek','class'=>'span6 tvalAlphaNum','maxlength'=>4)) ?>
	</div>
		
	<div class="span2">
		
	</div>
	
	<div class="span4" id="type_span" style="width:300px">
		<?php echo $form->radioButtonListInlineRow($model, 'type', array('F'=>'Fixed', 'P'=>'Pooling'), array('id'=>'type','required'=>true)) ?>
		<input type="hidden" id="type_hid" value="<?php echo $model->type ?>" />
	</div>
</div>

<br/>

<div class="row-fluid">
	<div class="span2">
		
	</div>
	<div class="span4" style="text-align:right">
		<div id="retrieve" style="float:left">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnRetrieve',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Retrieve',
				'htmlOptions'=>array('name'=>'submit','value'=>'retrieve')
			)); ?>
		</div>
		
		<div class="span1" style="float:left">
			
		</div>
		
		<div id="submit" style="float:left">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnDownload',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Download Excel File',
				'htmlOptions'=>array('name'=>'submit','value'=>'download','disabled'=>!$modelRetrieve)
			)); ?>
		</div>
	</div>
</div>

<br/>

<?php if($modelRetrieve): ?>
	<?php echo $this->renderPartial('list',array('model'=>$model,'modelRetrieve'=>$modelRetrieve,'form'=>$form)); ?>
<?php endif; ?>

<?php $this->endWidget() ?>

<script>
	$(document).ready(function()
	{		
		$("#batchOpt").change();
		$("#format").change();
	});
	
	$("#btnDownload").click(function()
	{
		$("#stkCd").val($("#stkCd_hid").val());
		
		if($("#type_hid").val() == 'F')
		{
			$("#GenFPPS_type_0").prop('checked',true);
		}
		else if($("#type_hid").val() == 'P')
		{
			$("#GenFPPS_type_1").prop('checked',true);
		}
	});
	
	$("#batchOpt").change(function()
	{
		if($("#batchOpt [type=radio]:checked").val() == 1)$("#batch").hide().removeAttr('required');
		else
			$("#batch").show().attr('required',true);
	});
	
	$("#format").change(function()
	{
		if($("#format [type=radio]:checked").val() == 1)
		{
			$("#type_span").hide();
			$("#type [type=radio]").removeAttr('required');
		}
		else
		{
			$("#type_span").show();
			$("#type [type=radio]").attr('required',true);
		}
	});
	
	$("#batch, #beginSubrek, #endSubrek").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
</script>