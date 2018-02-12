<?php
$this->breadcrumbs=array(
	'Client Closing'=>array('index'),
	$model->client_cd,
);

$this->menu=array(
	array('label'=>'Client Closing', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Close','icon'=>'plus','url'=>array('create'))
);
?>

<h1>View Closed Client #<?php echo $model->client_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'client_cd',
		'client_name'
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'date'),
		'user_id',
		array('name'=>'upd_dt','type'=>'date'),
		'upd_by',
		array('name'=>'approved_dt','type'=>'date'),
		'approved_by',
		'approved_stat',
	),
)); ?>
