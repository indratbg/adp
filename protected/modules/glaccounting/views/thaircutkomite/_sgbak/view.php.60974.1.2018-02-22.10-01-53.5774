<?php
$this->breadcrumbs=array(
	'Haircut MKBD'=>array('index'),
	$model->stk_cd,
);

$this->menu=array(
	array('label'=>'Haircut MKBD', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','status_dt'=>$model->status_dt,'stk_cd'=>$model->stk_cd,'eff_dt'=>$model->eff_dt)),
);
?>

<h1>View Haircut MKBD</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			array('name'=>'status_dt','type'=>'date'),
			'stk_cd',
			array('name'=>'haircut','value'=>number_format((float)$model->haircut,0,'.',',')),
			array('name'=>'eff_dt','type'=>'date'),
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
