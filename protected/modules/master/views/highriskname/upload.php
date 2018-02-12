<?php
$this->breadcrumbs=array(
	'Highrisknames'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Highriskname', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Upload','url'=>array('upload'),'icon'=>'plus','itemOptions'=>array('class'=>'active')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/highriskname/index','icon'=>'list'),
);
?>

<h1>Upload Highrisk Name</h1>

<?php AHelper::showFlash($this) ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'thighriskname-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->errorSummary($modelh); ?>
	
	<?php 
		//foreach($modelPreview as $row)
		//	echo $form->errorSummary($row); 
	?>

	
	<?php echo $form->hiddenField($model,'scenario');?>
	<?php echo $form->dropDownListRow($modelh,'kategori',AConstant::$highrisk_kategori,array('class'=>'span3','id'=>'kategori')); ?>
	<?php echo $form->fileFieldRow($model,'upload_file',array('required'=>'required'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Upload',
		)); ?>
	
<?php $this->endWidget(); ?>
<br />
<pre>
<b>Petunjuk Upload :</b>
1. Pilih kategori data high risk.
2. Format file harus .xls (Microsoft Excel 2003 Format).
3. Urutan header kolom dari kiri ke kanan adalah sebagai berikut:
&emsp;&emsp;&emsp;NAME - COUNTRY - BIRTH - ADDRESS - DESCRIPTION
</pre>


<script>
	
</script>
