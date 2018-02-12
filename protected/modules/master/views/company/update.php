<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->kd_broker=>array('view','id'=>$model->kd_broker),
	'Update',
);

$this->menu=array(
	array('label'=>'Company', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->kd_broker),'icon'=>'eye-open'),
);
?>

<h1>Update Company <?php echo $model->kd_broker; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'status'=>$status)); ?>