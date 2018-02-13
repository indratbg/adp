<?php
$this->breadcrumbs=array(
	'Levies'=>array('index'),
	$model->eff_dt=>array('view','eff_dt'=>$model->eff_dt,'stk_type'=>$model->stk_type,'mrkt_type'=>$model->mrkt_type,'value_from'=>$model->value_from,'value_to'=>$model->value_to),
	'Update',
);

$this->menu=array(
	array('label'=>'Levy', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','eff_dt'=>$model->eff_dt,'stk_type'=>$model->stk_type,'mrkt_type'=>$model->mrkt_type,'value_from'=>$model->value_from,'value_to'=>$model->value_to),'icon'=>'eye-open'),
);
?>

<h1>Update Levy <?php echo $model->eff_dt; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>