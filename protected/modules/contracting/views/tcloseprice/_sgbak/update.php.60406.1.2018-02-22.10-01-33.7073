<?php
$this->breadcrumbs=array(
	'Close Price'=>array('index'),
	$model->stk_date=>array('view','stk_date'=>$model->stk_date,'stk_cd'=>$model->stk_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Close Price', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','stk_date'=>$model->stk_date,'stk_cd'=>$model->stk_cd),'icon'=>'eye-open'),
);
?>

<h1>Update Close Price <?php echo $model->stk_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>