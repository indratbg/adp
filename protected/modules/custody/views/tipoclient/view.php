<?php
$this->breadcrumbs=array(
	'Tipoclients'=>array('index'),
	$model->client_cd,
);

$this->menu=array(
	array('label'=>'Tipoclient', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','client_cd'=>$model->client_cd,'stk_cd'=>$model->stk_cd)),
);
?>

<?php 
	$formatNumber = new CFormatter;
	$formatNumber->numberFormat['thousandSeparator'] = ',';
 ?>

<h1>View Client IPO Stock #<?php echo $model->client_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'client_cd',
		'stk_cd',
		'brch_cd',
		array('name'=>'fixed_qty','value'=>$formatNumber->formatNumber($model->fixed_qty)),
		array('name'=>'pool_qty','value'=>$formatNumber->formatNumber($model->pool_qty)),
		array('name'=>'alloc_qty','value'=>$formatNumber->formatNumber($model->alloc_qty)),
		'batch',
	),
)); ?>

