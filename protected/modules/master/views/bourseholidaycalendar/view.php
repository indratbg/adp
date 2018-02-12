<?php
$this->breadcrumbs=array(
	'IDX Holidays'=>array('index'),
	Yii::app()->format->formatDate($model->tgl_libur),
);

$this->menu=array(
	array('label'=>'IDX Holiday', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->tgl_libur)),
);
?>

<h1>View IDX Holiday #<?php echo Yii::app()->format->formatDate($model->tgl_libur); ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'tgl_libur','type'=>'date'),
		array('name'=>'ket_libur','type'=>'raw','value'=>nl2br($model->ket_libur)),
		'flag_libur',
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
