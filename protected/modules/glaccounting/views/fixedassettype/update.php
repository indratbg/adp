<?php
$this->breadcrumbs=array(
	'Fixed Asset Type'=>array('index'),
	$model->prm_cd_1=>array('view','prm_cd_1'=>$model->prm_cd_1,'prm_desc'=>$model->prm_desc),
	'Update',
);

$this->menu=array(
	array('label'=>'Fixed Asset Type', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','prm_cd_1'=>$model->prm_cd_1,'prm_cd_2'=>$model->prm_cd_2),'icon'=>'eye-open'),
);
?>

<h1>Update Fixed Asset Type</h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>