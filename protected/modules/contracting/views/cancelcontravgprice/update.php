<?php
$this->breadcrumbs=array(
	'Contract Avg Price'=>array('index'),
	//$model->contr_num=>array('view','id'=>$model->contr_num),
	'Update',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Update Contract Based on Average Price</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'model1'=>$model1,'totalqty'=>$totalqty,'trueqty'=>$trueqty,'rowz'=>$rowz,'rowCount'=>$rowCount,'maxduedtforamt'=>$maxduedtforamt)); ?>