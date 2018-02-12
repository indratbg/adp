<?php
$this->breadcrumbs=array(
	'Securities Ledgers'=>array('index'),
	$model->gl_acct_cd,
);

$this->menu=array(
	array('label'=>'SecuritiesLedger', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','gl_acct_cd'=>$model->gl_acct_cd,'ver_bgn_dt'=>$model->ver_bgn_dt)),
);
?>

<h1>View SecuritiesLedger #<?php echo $model->gl_acct_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'sl_code',
		'sl_desc',
		'gl_acct_cd',
		'fl_dbcr',
		array('name'=>'ver_bgn_dt','type'=>'date'),
		array('name'=>'ver_end_dt','type'=>'date'),
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'date'),
		array('name'=>'upd_dt','type'=>'date'),
		'user_id',
	),
)); ?>
