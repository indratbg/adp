<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Create Institutional Client ', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'supplRequired'=>$supplRequired,'modelClientinst'=>$modelClientinst,
												'modelCif'=>$modelCif,'modelClientBank'=>$modelClientBank,'modelClientAutho'=>$modelClientAutho,'modelClientMember'=>$modelClientMember,
												'minimumFeeFlg'=>$minimumFeeFlg,
												'withholdingTaxFlg'=>$withholdingTaxFlg,
												'acopenFeeFlg'=>$acopenFeeFlg,
												'taxOnInterestFlg'=>$taxOnInterestFlg,
												'pphFlg'=>$pphFlg,
												'init_deposit_cd'=>$init_deposit_cd,
												'cancel_reason'=>$cancel_reason,
												'cancel_reason_autho'=>$cancel_reason_autho,
												'render'=>$render)); ?>