<?php
$this->breadcrumbs=array(
	'Tcontracts'=>array('indexavgprice'),
	//$model->contr_num=>array('view','id'=>$model->contr_num),
	'Update',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List Avg Price','url'=>array('indexavgprice'),'icon'=>'list'),
	//array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	//array('label'=>'View','url'=>array('view','id'=>$model->contr_num),'icon'=>'eye-open'),
);
?>

<h1>Update Contract Based on Average Price</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_formavgprice',array('model'=>$model,'model1'=>$model1,'totalqty'=>$totalqty,'trueqty'=>$trueqty,'rowz'=>$rowz,'rowCount'=>$rowCount,'avgprice'=>$avgprice)); ?>