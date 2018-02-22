<?php
$this->breadcrumbs=array(
	'Fixedassets'=>array('index'),
	$model->asset_cd=>array('view','id'=>$model->asset_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Fixedasset', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->asset_cd),'icon'=>'eye-open'),
);
?>

<h1>Update Fixed Asset <?php echo $model->asset_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>