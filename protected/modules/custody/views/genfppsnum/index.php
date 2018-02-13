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
	array('label'=>'Generate FPPS NUmber', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
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

<br/>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->dropDownListRow($model, 'stk_cd', CHtml::listData(Tpee::model()->findAll(array('condition'=>"distrib_dt_to >= TRUNC(SYSDATE) AND approved_stat = 'A'",'order'=>'stk_cd')), 'stk_cd', 'stk_cd'), array('class'=>'span6', 'id'=>'stkCd','prompt'=>'-Choose Stock-','required'=>true)) ?>
		<input type="hidden" id="stkCd_hid" value="<?php echo $model->stk_cd ?>" />
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'batch',array('id'=>'batch','class'=>'span5','maxlength'=>'10','required'=>true)) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->datePickerRow($model,'fpps_cre_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span7',
				'options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span4" style="text-align:center">
		<div id="retrieve" style="">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnRetrieve',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Retrieve',
				'htmlOptions'=>array('name'=>'submit','value'=>'retrieve')
			)); ?>&emsp;&emsp;
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnSave',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Save',
				'htmlOptions'=>array('name'=>'submit','value'=>'save','disabled'=>'disabled')
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
	<?php if($modelRetrieve){?>
		$('#btnSave').attr('disabled',false);
	<?php }else{?>
		$('#btnSave').attr('disabled','disabled');
	<?php }?>
</script>