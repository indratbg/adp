<?php
$this->breadcrumbs=array(
	'Settlementclients'=>array('index'),
	$model->exch_cd=>array('view','id'=>$model->exch_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Settlementclient', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','eff_dt'=>$model->eff_dt,'client_cd'=>$model->client_cd,'market_type'=>$model->market_type,
											  'ctr_type'=>$model->ctr_type,'sale_sts'=>$model->sale_sts),'icon'=>'eye-open'),
);
?>


<h1>Update Client Settlement Days <?php echo $model->client_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>