<?php
$this->breadcrumbs=array(
	'Bankaccts'=>array('index'),
	$model->bank_cd,
);

$this->menu=array(
	array('label'=>'Bankacct', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->bank_cd)),
);
?>

<h1>View Bankacct #<?php echo $model->bank_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'bank_cd',
		'sl_acct_cd',
		'bank_acct_cd',
		'chq_num_mask',
		'bank_acct_type',
		'brch_cd',
		'folder_prefix',
		'gl_acct_cd',
		'curr_cd',
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
