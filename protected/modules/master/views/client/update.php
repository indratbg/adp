<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	$model->client_cd=>array('view','id'=>$model->client_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Update Individual Client '.$model->client_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','url'=>array('update','id'=>$model->client_cd),'icon'=>'pencil','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->client_cd),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'modelClientindi'=>$modelClientindi,
												'modelCif'=>$modelCif,'modelClientBank'=>$modelClientBank,
												'modelClientEmergency'=>$modelClientEmergency,
												'modelClientMember'=>$modelClientMember,
												'minimumFeeFlg'=>$minimumFeeFlg,
												'withholdingTaxFlg'=>$withholdingTaxFlg,
												'acopenFeeFlg'=>$acopenFeeFlg,
												'taxOnInterestFlg'=>$taxOnInterestFlg,
												'pphFlg'=>$pphFlg,
												'init_deposit_cd'=>$init_deposit_cd,
												'cancel_reason'=>$cancel_reason,
												'render'=>$render)); ?>