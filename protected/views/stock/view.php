<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index'),
	$model->stockcode,
);

$this->menu=array(
	array('label'=>'Stock', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->stockcode)),
);
?>

<h1>View Stock #<?php echo $model->stockcode; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'stockcode',
		'stockname',
		'status',
		'previousprice',
		'openprice',
		'highestprice',
		'lowestprice',
		'lastprice',
		'lastvolume',
		'change',
		'changepercentage',
		'bid',
		'bidvolume',
		'offer',
		'offervolume',
		'totalfrequency',
		'totalvolume',
		'totalvalue',
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
