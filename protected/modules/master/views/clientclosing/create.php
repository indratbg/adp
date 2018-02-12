<?php
$this->breadcrumbs=array(
	'Client Closings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Client Closing', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Client Closing</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'modelVClientmember'=>$modelVClientmember,'isvalid'=>$isvalid)); ?>