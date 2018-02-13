<?php
$this->breadcrumbs=array(
	'Clientflaccts'=>array('index'),
	$model->client_cd=>array('view','id'=>$model->client_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Clientflacct', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','client_cd'=>$model->client_cd,'bank_acct_num'=>$model->bank_acct_num),'icon'=>'eye-open'),
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

<h1>Update Investor Account <?php echo $trimmedclientcd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'listMask'=>$listMask)); ?>