<?php
$this->breadcrumbs=array(
	'Haircut MKBD'=>array('index'),
	$model->stk_cd=>array('view','stk_cd'=>$model->stk_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Haircut MKBD', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','status_dt'=>$model->status_dt,'stk_cd'=>$model->stk_cd,'eff_dt'=>$model->eff_dt),'icon'=>'eye-open'),
);
?>

<h1>Update Haircut MKBD</h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>