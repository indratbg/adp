<?php
$this->breadcrumbs=array(
	'Tbond Trxes'=>array('index'),
	$model->trx_id=>array('view','trx_date'=>$model->trx_date,'trx_seq_no'=>$model->trx_seq_no),
	'Update',
);

$this->menu=array(
	array('label'=>'TBondTrx', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','trx_date'=>$model->trx_date,'trx_seq_no'=>$model->trx_seq_no),'icon'=>'eye-open'),
);
?>

<h1>Update Bond Transaction <?php echo $model->trx_date.' #'.$model->trx_seq_no; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_formupd',array('model'=>$model,'model1'=>$model1,'modeloutsdone'=>$modeloutsdone,'modelbondbuy'=>$modelbondbuy,'modelsell'=>$modelsell,'sellcount'=>$sellcount,'modelmultiprice'=>$modelmultiprice)); ?>