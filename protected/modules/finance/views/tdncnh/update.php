<?php
$this->breadcrumbs=array(
	'Interest Journal Entry'=>array('index'),
	$model->dncn_num=>array('view','id'=>$model->dncn_num),
	'Update',
);


$this->menu=array(
	array('label'=>'Update Interest Journal '.$model->folder_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->dncn_num),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->dncn_num),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_formupdate',
array('model'=>$model,'modeldetail'=>$modeldetail,'cancel_reason'=>$cancel_reason,'check'=>$check,'oldmodel'=>$oldmodel,'oldmodeldetail'=>$oldmodeldetail,'modelreversal'=>$modelreversal,'modelRevJvch'=>$modelRevJvch,
'modelfolder'=>$modelfolder)); ?>


