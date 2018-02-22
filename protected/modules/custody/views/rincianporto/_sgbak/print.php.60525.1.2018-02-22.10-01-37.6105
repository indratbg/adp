<?php
$this->breadcrumbs=array(
	'Print Report Rincian Portofolio'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Print Report Rincian Portofolio', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Generate','url'=>array('generate'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/rincianporto/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'porto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary($model);?>


<a href="<?php echo $url.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>" class="btn btn-small btn-primary" >Export to Excel</a>

<iframe src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" style="min-height:600px;max-width: 100%;"></iframe>

<?php $this->endWidget();?>

