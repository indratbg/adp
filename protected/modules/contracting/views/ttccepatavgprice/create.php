<?php
$this->breadcrumbs=array(
	'Ttccepatavgprice'=>array('index'),
	//$model->contr_num=>array('view','id'=>$model->contr_num),
	'Create',
);

$this->menu=array(
	array('label'=>'Ttccepatavgprice', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('class'=>'active')),
	//array('label'=>'View','url'=>array('view','id'=>$model->contr_num),'icon'=>'eye-open'),
);
?>

<h1>Create TC Cepat</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('modelfotd'=>$modelfotd,'model'=>$model,'model1'=>$model1,'rowCount'=>$rowCount,
		'totalqty'=>$totalqty,'avgprice'=>$avgprice,'modelClient'=>$modelClient,'formstat'=>$formstat)); ?>