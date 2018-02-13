<?php
$this->breadcrumbs=array(
	'Glaccounts'=>array('index'),
	$model->sl_a=>array('view','sl_a'=>$model->sl_a,'gl_a'=>$model->gl_a),
	'Update',
);

$this->menu=array(
	array('label'=>'Glaccount', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','sl_a'=>$model->sl_a,'gl_a'=>$model->gl_a),'icon'=>'eye-open'),
);
?>

<h1>Update Gl Account <?php echo $model->gl_a.' '.$model->sl_a; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>