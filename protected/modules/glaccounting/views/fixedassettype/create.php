<?php
$this->breadcrumbs=array(
	'Fixed Asset Type'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Fixed Asset Type', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Fixed Asset Type</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>