<?php
$this->breadcrumbs=array(
	'Tipoclients'=>array('index'),
	'Import',
);

$this->menu=array(
	array('label'=>'Tipoclient', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Import','url'=>array('index'),'icon'=>'upload','itemOptions'=>array('class'=>'active')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tipoclient/index','icon'=>'list'),
);
?>

<h1>Import Client IPO Stock</h1>

<?php AHelper::showFlash($this) ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tipoclient-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropdownListRow($model,'stk_cd',Chtml::listData(Tpee::model()->findAll($criteria_stk),'stk_cd','stk_cd'),array('class' => 'span2')); ?>

<?php echo $form->radioButtonListRow($model,'data_type',array('Fixed','Pooling','Approved Pooling')); ?>

<?php echo $form->textFieldRow($model,'batch',array('id'=>'batch','class'=>'span2','maxlength'=>10)); ?>

<?php echo $form->textFieldRow($model,'ipo_perc',array('class'=>'span2 tnumber','maxlength'=>3,'style'=>'text-align:right')); ?>

<?php echo $form->fileFieldRow($model,'source_file',array('required'=>'required'));?>

<?php echo $form->label($model,'&nbsp',array('class'=>'control-label')) ?>

<i style="font-size:11px;color:blue">* Data harus dalam TAB delimited TEXT file, TANPA HEADING, berisi Client Code dan Quantity</i>

<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Import dan Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>

<script>
		
	$("#batch").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});

</script>