<?php
$this->breadcrumbs=array(
	'Tinterestrates'=>array('index'),
	$model->client_cd=>array('view','id'=>$model->client_cd),
	'Update',
);

/*
$this->menu=array(
	array('label'=>'Tinterestrate', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	//array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','client_cd'=>$model->client_cd),'icon'=>'eye-open'),
);*/


$this->menu=array(
	array('label'=>'Update Interest Rate '.$model->client_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','client_cd'=>$model->client_cd),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','client_cd'=>$model->client_cd),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>


<br />


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'modelInt'=>$modelInt,'cancel_reason'=>$cancel_reason,'check'=>$check)); ?>