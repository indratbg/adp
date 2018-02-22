<style>
	.tnumber
	{
		text-align:right;
	}
</style>

<?php 
	//$listType1 = Lsttype1::model()->findAll();
	//$listType2 = Lsttype2::model()->findAll();
	//$client = Client::model()->findAll(array('order'=>'CLIENT_CD'));
	//$stock = Counter::model()->findAll(array('order'=>'STK_CD')); 
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'taxrate-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->datePickerRow($model,'begin_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php echo $form->datePickerRow($model,'end_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php echo $form->radioButtonListRow($model,'rate_type',array('UMUM','SPECIAL'),array('id'=>'rateType')) ?>
	
	<div class="special">
	<?php echo $form->label($model,'client_cd',array('class'=>'control-label','id'=>'label_clientCd')) ?>
	<?php echo $form->dropDownListRow($model,'client_cd',Chtml::listData(Client::model()->findAllBySql('SELECT CLIENT_CD, CLIENT_NAME FROM MST_CLIENT ORDER BY CLIENT_CD'),'client_cd','CodeAndName'),array('class'=>'span3','maxlength'=>12,'id'=>'clientCd','prompt'=>'-Select Client Code-','label'=>false)); ?>
	
	<?php echo $form->label($model,'stk_cd',array('class'=>'control-label','id'=>'label_stkCd')) ?>
	<?php echo $form->dropDownListRow($model,'stk_cd',Chtml::listData(Counter::model()->findAllBySql('SELECT STK_CD FROM MST_COUNTER ORDER BY STK_CD'),'stk_cd','stk_cd'),array('class'=>'span3','maxlength'=>12,'id'=>'stkCd','prompt'=>'-Select Stock Code-','label'=>false)); ?>
	</div>
	<div class="umum">
	<?php echo $form->label($model,'client_type_1',array('class'=>'control-label','id'=>'label_clientType1')) ?>
	<?php echo $form->dropDownListRow($model,'client_type_1',Chtml::listData(Lsttype1::model()->findAll(),'cl_type1','cl_desc'),array('class'=>'span3','id'=>'clientType1','prompt'=>'-Select Client Type 1-','label'=>false)); ?>

	<?php echo $form->label($model,'client_type_2',array('class'=>'control-label','id'=>'label_clientType2')) ?>
	<?php echo $form->dropDownListRow($model,'client_type_2',Chtml::listData(Lsttype2::model()->findAll(),'cl_type2','cl_desc'),array('class'=>'span3','maxlength'=>1,'id'=>'clientType2','prompt'=>'-Select Client Type 2-','label'=>false)); ?>
	</div>

	<?php echo $form->textFieldRow($model,'rate_1',array('class'=>'span2 tnumber','maxlength'=>11)); ?>
	
	<div class="umum">
	<?php echo $form->label($model,'rate_2',array('class'=>'control-label','id'=>'label_rate2')) ?>
	<?php echo $form->textField($model,'rate_2',array('class'=>'span2 tnumber','value'=>!$model->rate_2?'0':$model->rate_2,'id'=>'rate2','maxlength'=>11)); ?>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php  
	$new = 1;
	if($model->getAttribute('rate_type'))$new = 0;
?>

<script>
	if(<?php echo $new ?>)$('#Taxrate_rate_type_0').prop('checked',true);
	
	$('#rateType').change(function()
	{
		if($('#Taxrate_rate_type_0').is(':checked'))
		{
			$(".special").hide();
			$(".umum").show();
		}
		else
		{
			$(".umum").hide();
			$(".special").show();
		}
	});
	$('#rateType').trigger('change');
</script>
