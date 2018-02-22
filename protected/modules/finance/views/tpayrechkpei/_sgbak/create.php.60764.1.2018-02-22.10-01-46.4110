<?php
$this->breadcrumbs=array(
	'List'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Create KPEI Voucher ', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?>
<?php echo $this->renderPartial('/tpayrechkpei/_form', array('model'=>$model,
												'modelLedger'=>$modelLedger,
												//'modelLedgerSave'=>$modelLedgerSave,
												'modelDetailLedger'=>$modelDetailLedger,
												'modelFolder'=>$modelFolder,
												'modelCheqLedger'=>$modelCheqLedger,	
												'tempModel'=>$tempModel,											
												'retrieved'=>$retrieved)); ?>