<?php
$this->breadcrumbs=array(
	'Highrisknames'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Highriskname', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','name'=>$model->name,'kategori'=>$model->kategori)),
);
?>

<h1>View Highriskname #<?php echo $model->name; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'kategori',
		'country',
		'birth',
		'address',
		'descrip',
		'ref_date',
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
