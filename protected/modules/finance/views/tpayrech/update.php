<?php
$this->breadcrumbs=array(
	'List'=>array('index'),
	$model->payrec_num=>array('view','payrec_num'=>$model->payrec_num),
	'Update',
);

$controllerId = $this->getId();

$this->menu=array(
	array('label'=>'Update Voucher '.$model->payrec_num, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','url'=>array('update','id'=>$model->payrec_num),'icon'=>'pencil','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->payrec_num),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php if($controllerId == 'tpayrechalt'): ?>
<pre><strong>Note : Cancel / Update voucher menghasilkan tanggal reversal sama dengan tanggal voucher yang dicancel/update</strong></pre>
<?php else: ?>
<pre><strong>Note : Cancel / Update voucher menghasilkan tanggal reversal sama dengan tanggal hari ini (Untuk voucher non AR/AP)</strong></pre>
<?php endif; ?>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('/tpayrech/_form', array('model'=>$model,
												'modelDetail'=>$modelDetail,
												'modelLedger'=>$modelLedger,
												'modelDetailLedger'=>$modelDetailLedger,
												'modelDetailLedgerNonRev'=>$modelDetailLedgerNonRev,
												'modelFolder'=>$modelFolder,
												'modelCheq'=>$modelCheq,
												'modelCheqLedger'=>$modelCheqLedger,
												'modelJvchh'=>$modelJvchh,
												'tempModel'=>$tempModel,
												'oldModel'=>$oldModel,
												'oldModelDetail'=>$oldModelDetail,
												'oldModelDetailLedger'=>$oldModelDetailLedger,
												'oldModelFolder'=>$oldModelFolder,
												'oldModelLedger'=>$oldModelLedger,
												'reverseModelLedger'=>$reverseModelLedger,
												'reverseModelFolder'=>$reverseModelFolder,
												'retrieved'=>$retrieved,
												'reretrieve_flg'=>$reretrieve_flg,
												'cancel_reason'=>$cancel_reason,
												'cancel_reason_cheq'=>$cancel_reason_cheq,)); ?>