<?php
$this->breadcrumbs=array(
	'Withdraw Cash Exception'=>array('index'),
	$model->client_cd,
);

$this->menu=array(
	array('label'=>'Withdraw Cash Exception', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->client_cd)),
);
?>

<h1>View Withdraw Cash Exception #<?php echo $model->client_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'client_cd',
	),
)); ?>

<!--

<h3>Identity Attributes</h3>-->

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
