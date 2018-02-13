<?php
$this->breadcrumbs=array(
	'Clientsuspends'=>array('index'),
	$model->client_cd=>array('view','id'=>$model->client_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	//array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	//array('label'=>'View','url'=>array('view','id'=>$model->client_cd),'icon'=>'eye-open'),
);
?>

<h1>Update Clientsuspend <?php echo $model->client_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>