<?php
$this->breadcrumbs=array(
	'Levies'=>array('index'),
	$model->eff_dt,
);

$this->menu=array(
	array('label'=>'Levy', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','eff_dt'=>$model->eff_dt,'stk_type'=>$model->stk_type,'mrkt_type'=>$model->mrkt_type,'value_from'=>$model->value_from,'value_to'=>$model->value_to)),
);
?>

<h1>View Levy #<?php echo $model->eff_dt; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'eff_dt','type'=>'date'),
		array('name'=>'stk_type','value'=>Constanta::$stock_type[$model->stk_type]),
		array('name'=>'mrkt_type','value'=>Constanta::$market_type[$model->mrkt_type]),
		'value_from',
		'value_to',
		array('name'=>'levy_pct','value'=>$model->levy_pct." %"),
		
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
