<?php
$this->breadcrumbs=array(
	'Client Exception'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Client Exception', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Client Exception</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>