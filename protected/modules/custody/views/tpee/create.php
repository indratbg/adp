<?php
$this->breadcrumbs=array(
	'Tpees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Tpee', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Input IPO Stock</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>