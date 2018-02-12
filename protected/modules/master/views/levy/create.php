<?php
$this->breadcrumbs=array(
	'Levies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Levy', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Levy</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>