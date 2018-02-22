<?php
$this->breadcrumbs=array(
	'Portofolio yang Dijaminkan'=>array('index'),
	$model->stk_cd=>array('view','from_dt'=>$model->from_dt,'client_cd'=>$model->client_cd,'stk_cd'=>$model->stk_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Portofolio yang Dijaminkan', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','from_dt'=>$model->from_dt,'client_cd'=>$model->client_cd,'stk_cd'=>$model->stk_cd),'icon'=>'eye-open'),
);
?>

<h1>Update Portofolio yang Dijaminkan <?php echo $model->stk_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>