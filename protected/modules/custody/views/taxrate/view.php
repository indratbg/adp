<?php
$this->breadcrumbs=array(
	'Taxrates'=>array('index'),
	$model->tax_type,
);

$this->menu=array(
	array('label'=>'Taxrate', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->seqno)),
);
?>

<h1>View Dividend Tax Rate #<?php echo $model->tax_type; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'begin_dt','type'=>'date'),
		array('name'=>'end_dt','type'=>'date'),
		'tax_type',
		'client_cd',
		'stk_cd',
		'client_type_1',
		'client_type_2',
		'rate_1',
		'rate_2',
		'tax_desc',
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
