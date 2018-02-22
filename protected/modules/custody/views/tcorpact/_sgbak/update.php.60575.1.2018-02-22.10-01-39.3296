<?php
$this->breadcrumbs=array(
	'Tcorpacts'=>array('index'),
	$model->stk_cd=>array('view','stk_cd'=>$model->stk_cd,'x_dt'=>$model->x_dt),
	'Update',
);

$this->menu=array(
	array('label'=>'Tcorpact', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','stk_cd'=>$model->stk_cd,'x_dt'=>$model->x_dt),'icon'=>'eye-open'),
);
?>

<h1>Update Corporate Action <?php echo $model->stk_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'criteriaCorp'=>$criteriaCorp,'check'=>$check)); ?>