<?php
/* @var $this FixedAssetMovementController */
/* @var $model FixedAssetMovement */

$this->breadcrumbs=array(
	'Fixed Asset Movements'=>array('index'),
	$model->asset_cd,
);

$this->menu=array(
	array('label'=>'View Fixed Asset Movements', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','doc_date'=>$model->doc_date,'asset_cd'=>$model->asset_cd)),
);
?>

<h1>View Fixed Asset Movement <?php echo $model->asset_cd; ?></h1>

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'doc_date','type'=>'date'),
		'branch_cd',
		'asset_cd',
		'asset_desc',
		'mvmt_type',
		'qty',
		'to_branch',
	),
)); ?>

<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		array('name'=>'cre_dt','type'=>'date'),
		array('name'=>'upd_by','type'=>'date'),
	),
)); ?>


