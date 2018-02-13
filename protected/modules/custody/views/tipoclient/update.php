<?php
$this->breadcrumbs=array(
	'Tipoclients'=>array('index'),
	$model->client_cd=>array('view','client_cd'=>$model->client_cd,'stk_cd'=>$model->stk_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Tipoclient', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','client_cd'=>$model->client_cd,'stk_cd'=>$model->stk_cd),'icon'=>'eye-open'),
);
?>

<h1>Update Client IPO Stock <?php echo $model->client_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'criteria_stk'=>$criteria_stk,'criteria_client'=>$criteria_client,'client'=>$client)); ?>