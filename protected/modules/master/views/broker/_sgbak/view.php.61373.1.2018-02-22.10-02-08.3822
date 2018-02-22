<?php
/* @var $this BrokerController */
/* @var $model Broker */

$this->breadcrumbs=array(
	'Brokers'=>array('index'),
	$model->broker_cd,
);

$this->menu=array(
	array('label'=>'List Broker', 'url'=>array('index')),
	array('label'=>'Create Broker', 'url'=>array('create')),
	array('label'=>'Update Broker', 'url'=>array('update', 'id'=>$model->broker_cd)),
	array('label'=>'Delete Broker', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->broker_cd),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Broker', 'url'=>array('admin')),
);
?>

<h1>View Broker #<?php echo $model->broker_cd; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'broker_cd',
		'broker_name',
		'cre_dt',
		'user_id',
		'upd_dt',
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
	),
)); ?>
