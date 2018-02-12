<?php
$this->breadcrumbs=array(
	'Bankmasters'=>array('index'),
	$model->bank_cd=>array('view','id'=>$model->bank_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Update Operational Bank '.$model->bank_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','url'=>array('update','id'=>$model->bank_cd),'icon'=>'pencil','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->bank_cd),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'modelAcct'=>$modelAcct,'cancel_reason'=>$cancel_reason,'check'=>$check)); ?>