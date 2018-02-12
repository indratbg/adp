<?php
$this->breadcrumbs=array(
	'Clientflaccts'=>array('index'),
	$model->client_cd,
);

$this->menu=array(
	array('label'=>'Clientflacct', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','client_cd'=>$model->client_cd,'bank_acct_num'=>$model->bank_acct_num)),
);
?>

<?php
	$pos = strrpos($model->client_cd,' - ');
				
	if($pos){
		$trimmedclientcd = substr($model->client_cd,0,$pos);
	}else{
		$trimmedclientcd = $model->client_cd;
	}
?>

<h1>View Investor Account #<?php echo $trimmedclientcd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'client_cd','value'=>$model->client_cd.' - '.$model->client->client_name),
		array('name'=>'bank_cd','value'=>$model->bank_cd.' - '.$model->bank->bank_name),
		'bank_acct_num',
		'acct_name',
		//'acct_stat',
		array('name'=>'acct_stat','value'=>AConstant::$acct_stat[$model->acct_stat]),
		'bank_short_name',
		'bank_acct_fmt',
		array('name'=>'from_dt','type'=>'date'),
		array('name'=>'to_dt','type'=>'date'),
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'date'),
		'user_id',
		array('name'=>'upd_dt','type'=>'date'),
		'upd_user_id',
		array('name'=>'approved_dt','type'=>'date'),
		'approved_by',
		//'approved_stat',
		array('name'=>'approved_stat','value'=>AConstant::$inbox_app_stat[$model->approved_stat]),
	),
)); ?>
