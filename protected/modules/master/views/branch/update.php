<?php
$this->breadcrumbs=array(
	'Branches'=>array('index'),
	$model->brch_cd=>array('view','id'=>$model->brch_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Branch', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->brch_cd),'icon'=>'eye-open'),
);
?>

<h1>Update Branch <?php echo $model->brch_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>