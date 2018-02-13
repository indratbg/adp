<?php
$this->breadcrumbs=array(
	'Glaccounts'=>array('index'),
	$model->sl_a,
);

$this->menu=array(
	array('label'=>'Glaccount', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','sl_a'=>$model->sl_a,'gl_a'=>$model->gl_a)),
);
?>

<h1>View Gl Account <?php echo $model->gl_a.' '.$model->sl_a; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'gl_a',
		'sl_a',
		'acct_name',
		array('name'=>'acct_stat','value'=>$model->acct_stat=='A'?'ACTIVE':'CLOSED'),
		'brch_cd',
		'prt_type',
		'acct_type',
		'acct_short',
		'def_cpc_cd',
		'mkbd_cd',
		'mkbd_group',
	),
)); ?>

