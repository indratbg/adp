<?php
$this->breadcrumbs=array(
	'Highrisknames'=>array('index'),
	$model->name=>array('view','name'=>$model->name,'kategori'=>$model->kategori),
	'Update',
);

$this->menu=array(
	array('label'=>'Highriskname', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','name'=>$model->name,'kategori'=>$model->kategori),'icon'=>'eye-open'),
);
?>

<h1>Update Highriskname <?php echo $model->name; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>