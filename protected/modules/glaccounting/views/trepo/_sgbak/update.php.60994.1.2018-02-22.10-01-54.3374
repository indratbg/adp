<?php
$this->breadcrumbs=array(
	'Trepos'=>array('index'),
	$model->repo_num=>array('view','id'=>$model->repo_num),
	'Update',
);

$this->menu=array(
	array('label'=>'Update Repo '.$model->client_cd.' '.$model->repo_ref, 'itemOptions'=>array('style'=>'font-size:29px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'View','url'=>array('view','id'=>$model->repo_num),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','url'=>array('update','id'=>$model->repo_num),'icon'=>'pencil','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'modelHist'=>$modelHist,'modelVch'=>$modelVch,'perpanjangan'=>$perpanjangan,'voucher'=>$voucher,'oldPkId'=>$oldPkId,'cancel_reason'=>$cancel_reason)); ?>