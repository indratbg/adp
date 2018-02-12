<?php
$this->breadcrumbs=array(
	'Penyertaan Reksa dana'=>array('index'),
	$model->doc_ref_num,
);

$this->menu=array(
	array('label'=>'Penyertaan Reksa dana', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->doc_ref_num)),
);
?>

<h1>View Penyertaan Reksadana</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'reks_cd',
			'reks_name',
			'reks_type',
			'afiliasi',
			array('name'=>'trx_date','type'=>'date'),
			'trx_type',
			array('name'=>'subs','value'=>number_format((float) $model->subs,0,'.',',')),
			array('name'=>'redm','value'=>number_format((float) $model->redm,0,'.',',')),
			'gl_a1',
			'sl_a1',
			'gl_a2',
			'sl_a2',
			'doc_ref_num',
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
