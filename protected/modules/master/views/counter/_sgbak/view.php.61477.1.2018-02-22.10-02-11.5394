<?php
$this->breadcrumbs=array(
	'Counters'=>array('index'),
	$model->stk_cd,
);

$this->menu=array(
	array('label'=>'Counter', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->stk_cd)),
);
?>

<h1>View Stock #<?php echo $model->stk_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'stk_cd',
		array('name'=>'ctr_type','value'=> $model->ctr_type? Parameter::getParamDesc('CTRTYP',$model->ctr_type):'-'),
		array('name'=>'indry_type','value'=> $model->indry_type? Parameter::getParamDesc('INDRYT',$model->indry_type):'-'),
		'stk_desc',
		'stk_type',
		array('name'=>'pp_from_dt','type'=>'date'),
		array('name'=>'pp_to_dt','type'=>'date'),
		array('name'=>'regr_cd','value'=> $model->regr_cd? Parameter::getParamDesc('REGRCD',$model->regr_cd):'-'),		
		array('name'=>'lot_size'),
		'pph_appl_flg',
		'levy_appl_flg',
		'mrg_cap_type',
		'layer',
		'isin_code',
	),
)); ?>
	

<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		array('name'=>'cre_dt','type'=>'date'),
		array('name'=>'upd_dt','type'=>'date'),
		'upd_by',
		array('name'=>'approved_dt','type'=>'date'),
		'approved_by',
		'approved_stat',
	),
)); ?>
