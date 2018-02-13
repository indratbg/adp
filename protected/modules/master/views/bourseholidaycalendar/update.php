<?php
$this->breadcrumbs=array(
	'IDX Holidays'=>array('index'),
	$model->tgl_libur=>array('view','id'=>$model->tgl_libur),
	'Update',
);

$this->menu=array(
	array('label'=>'IDX Holiday', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->tgl_libur),'icon'=>'eye-open'),
);
?>

<h1>Update IDX Holiday <?php echo $model->tgl_libur; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'listLiburJson'=>$listLiburJson)); ?>