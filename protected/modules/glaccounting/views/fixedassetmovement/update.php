<?php
/* @var $this FixedAssetMovementController */
/* @var $model FixedAssetMovement */

$this->breadcrumbs=array(
	'Fixed Asset Movements'=>array('index'),
	$model->asset_cd=>array('view','id'=>$model->asset_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Update Fixed Asset Movement '.$model->asset_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->asset_cd),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>



<?php echo $this->renderPartial('_form', array('model'=>$model,'modelReceive'=>$modelReceive,'fasset'=>$fasset,'brch'=>$brch,'mvmt_check'=>$mvmt_check)); ?>
<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
