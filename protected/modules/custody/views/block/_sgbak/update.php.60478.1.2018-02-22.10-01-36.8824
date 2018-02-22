<?php
$this->breadcrumbs=array(
	'Blocks'=>array('index'),
	$model->prm_cd_1=>array('view','id'=>$model->prm_cd_1),
	'Update',
);

$this->menu=array(
	array('label'=>'Block', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Update Block <?php echo $model->prm_cd_2; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>