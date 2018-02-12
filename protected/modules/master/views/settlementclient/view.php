<?php
$this->breadcrumbs=array(
	'Client Settlement'=>array('index'),
	$model->exch_cd,
);

$this->menu=array(
	array('label'=>'Client Settlement', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','eff_dt'=>$model->eff_dt,'client_cd'=>$model->client_cd,'market_type'=>$model->market_type,
											  					   'ctr_type'=>$model->ctr_type,'sale_sts'=>$model->sale_sts)),
);
?>

<h1>View Client Settlement Days <?php echo $model->client_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//array('name'=>'Client','value'=>$model->client->getConcatForSettlementClientCmb()),
		'client_cd',
		array('name'=>'eff_dt','type'=>'date'),
		array('name'=>'market_type','value'=>Parameter::getParamDesc('MARKET', $model->market_type)),
		array('name'=>'ctr_type','value'=>Parameter::getParamDesc('CTRTYP', $model->ctr_type)),
		array('name'=>'sale_sts','value'=>AConstant::$settle_client_sale_sts[$model->sale_sts]),
		array('name'=>'csd_script','type'=>'number'),
		array('name'=>'csd_value','type'=>'number'),
		array('name'=>'kds_value','type'=>'number'),
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
