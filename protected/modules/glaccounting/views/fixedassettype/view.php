<?php
$this->breadcrumbs=array(
	'Fixed Asset Type'=>array('index'),
	$model->prm_cd_1,
);

$this->menu=array(
	array('label'=>'Fixed Asset Type', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','prm_cd_1'=>$model->prm_cd_1,'prm_cd_2'=>$model->prm_cd_2)),
);
?>

<h1>View Fixed Asset Type</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'prm_cd_2',
		'prm_desc',
		array('name'=>'gl_acct_db','value'=>$model->gl_acct_db.' '.$model->sl_acct_db),
		array('name'=>'gl_acct_cr','value'=>$model->gl_acct_cr.' '.$model->sl_acct_cr),
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		array('name'=>'cre_dt','type'=>'date'),
		array('name'=>'upd_dt','type'=>'date'),
	),
)); ?>
