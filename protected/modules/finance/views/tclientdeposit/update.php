<?php
$this->breadcrumbs=array(
	'Deposit Client Entry'=>array('index'),
	$model[0]->client_cd=>array('view','id'=>$model[0]->client_cd),
	'Update',
);


$this->menu=array(
	array('label'=>'Update Deposit Client Entry '.$model[0]->client_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'View','url'=>array('view','id'=>$model[0]->client_cd),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model[0]->client_cd),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',
array('model'=>$model,
	'cancel_reason'=>$cancel_reason,
	'dropdown_folder_cd'=>$dropdown_folder_cd
	)); ?>


