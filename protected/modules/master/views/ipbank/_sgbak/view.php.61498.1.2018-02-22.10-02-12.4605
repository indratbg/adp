<?php
$this->breadcrumbs=array(
	'IP Bank'=>array('index'),
	$model->bank_cd,
);

$this->menu=array(
	array('label'=>'IP Bank', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->bank_cd)),
);
?>

<h1>View IP Bank #<?php echo $model->bank_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'bank_cd',
		'bi_code',
		'bank_short_name',
		'bank_name'
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	array('name'=>'cre_dt','type'=>'datetime'),
        'user_id',
        array('name'=>'upd_dt','type'=>'datetime'),
        'upd_by',
        array('name'=>'approved_dt','type'=>'datetime'),
	),
)); ?>
