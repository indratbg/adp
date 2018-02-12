<?php
$this->breadcrumbs=array(
	'Fixedassets'=>array('index'),
	$model->asset_cd,
);

$this->menu=array(
	array('label'=>'Fixedasset', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->asset_cd)),
);
?>

<h1>View Fixed Asset #<?php echo $model->asset_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
				'branch_cd',
				'asset_cd',
				'asset_type',
				'asset_desc',
				array('name'=>'purch_dt','type'=>'date'),
				array('name'=>'purch_price','type'=>'number'),
				'age',
				'accum_last_yr',
				'asset_stat',
				
				
				
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
