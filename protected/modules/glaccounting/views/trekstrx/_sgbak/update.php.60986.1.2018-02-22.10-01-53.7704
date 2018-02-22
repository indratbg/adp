<?php
$this->breadcrumbs=array(
	'Peyertaan Reksa dana'=>array('index'),
	$model->doc_ref_num=>array('view','id'=>$model->doc_ref_num),
	'Update',
);

$this->menu=array(
	array('label'=>'Penyertaan Reksa dana', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->doc_ref_num),'icon'=>'eye-open'),
);
?>

<h1>Update Penyertaan Reksa Dana</h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model,'oldModel'=>$oldModel)); ?>