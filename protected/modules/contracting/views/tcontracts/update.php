<?php
$this->breadcrumbs=array(
	'Tcontracts'=>array('index'),
	//$model->contr_num=>array('view','id'=>$model->contr_num),
	'Update',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	//array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	//array('label'=>'View','url'=>array('view','id'=>$model->contr_num),'icon'=>'eye-open'),
);
?>

<h1>Update Contract <?php echo $model->contr_num; ?></h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'model1'=>$model1,'sid'=>$sid,'rowCount'=>$rowCount,'totalqty'=>$totalqty)); ?>