<?php
$this->breadcrumbs=array(
	'Client Types'=>array('index'),
	$model->cl_type1=>array('view','cl_type1'=>$model->cl_type1,'cl_type2'=>$model->cl_type2,'cl_type3'=>$model->cl_type3),
	'Update',
);

$this->menu=array(
	array('label'=>'Client Type', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','cl_type1'=>$model->cl_type1,'cl_type2'=>$model->cl_type2,'cl_type3'=>$model->cl_type3),'icon'=>'eye-open'),
);
?>

<h1>Update Client Type <?php echo $model->cl_type1."".$model->cl_type2."".$model->cl_type3; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>