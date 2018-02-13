<?php
$this->breadcrumbs=array(
	'Counters'=>array('index'),
	$model->stk_cd=>array('view','id'=>$model->stk_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Counter', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->stk_cd),'icon'=>'eye-open'),
);
?>

<h1>Update Stock <?php echo $model->stk_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>