<?php
/* @var $this BankbiController */
/* @var $model Bankbi */

$this->breadcrumbs=array(
	'Clearing Code'=>array('index'),
	$model->bi_code,
);

$this->menu=array(
	array('label'=>'Bank BI', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->bi_code)),
);
?>

<h1>View <?php echo $model->bank_name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'bi_code',
		'rtgs_code',
		'bank_name',
		'branch_name',
		'city',
		'ip_bank_cd',

	),
)); ?>
<br/>