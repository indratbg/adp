<?php
$this->breadcrumbs=array(
	'GL Journal Entry'=>array('index'),
	$model->jvch_num=>array('view','id'=>$model->jvch_num),
	'Update',
);
/*
$this->menu=array(
	array('label'=>'GL Journal Entry', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->jvch_num),'icon'=>'eye-open'),
);
*/


$this->menu=array(
	array('label'=>'Update GL Journal '.$model->folder_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->jvch_num),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->jvch_num),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>




<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_formupdate',array('model'=>$model,'modeldetail'=>$modeldetail,'cancel_reason'=>$cancel_reason,
'check'=>$check,'oldmodel'=>$oldmodel,'oldmodeldetail'=>$oldmodeldetail,'modelreversal'=>$modelreversal,'modelfolder'=>$modelfolder,'modelfolderTAL'=>$modelfolderTAL)); ?>