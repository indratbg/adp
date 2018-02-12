<?php
$this->breadcrumbs=array(
	'Tcorpacts'=>array('index'),
	$model->stk_cd,
);

$this->menu=array(
	array('label'=>'Tcorpact', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','stk_cd'=>$model->stk_cd,'x_dt'=>$model->x_dt)),
);
?>

<h1>View Tcorpact #<?php echo $model->stk_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'stk_cd',
		'ca_type',
		array('name'=>'cum_dt','type'=>'date'),
		array('name'=>'x_dt','type'=>'date'),
		array('name'=>'recording_dt','type'=>'date'),
		array('name'=>'distrib_dt','type'=>'date'),
		'from_qty',
		'to_qty',
		'rate',	
	),
)); ?>