<?php
$this->breadcrumbs=array(
	'Changed Tickers'=>array('index'),
	$model->stk_cd_old,
);

$this->menu=array(
	array('label'=>'Changed Ticker', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->stk_cd_old)),
);
?>

<h1>View Changed Ticker #<?php echo $model->stk_cd_old; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'stk_cd_old',
		'stk_cd_new',
		array('name'=>'eff_dt','type'=>'date'),
		array('name'=>'run_dt','type'=>'date'),
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
