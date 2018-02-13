<?php
$this->breadcrumbs=array(
	'Portofolio yang Dijaminkan'=>array('index'),
	$model->stk_cd,
);

$this->menu=array(
	array('label'=>'Portofolio yang Dijaminkan', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','from_dt'=>$model->from_dt,'client_cd'=>$model->client_cd,'stk_cd'=>$model->stk_cd)),
);
?>

<h1>View Portofolio yang Dijaminkan #<?php echo $model->stk_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'from_dt','type'=>'date'),
		'client_cd',
		'stk_cd',
		array('name'=>'qty','type'=>'number'),
	),
)); ?>



