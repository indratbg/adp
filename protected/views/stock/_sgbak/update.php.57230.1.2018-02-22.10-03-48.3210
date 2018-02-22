<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index'),
	$model->stockcode=>array('view','id'=>$model->stockcode),
	'Update',
);

$this->menu=array(
	array('label'=>'Stock', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->stockcode),'icon'=>'eye-open'),
);
?>

<h1>Update Stock <?php echo $model->stockcode; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>