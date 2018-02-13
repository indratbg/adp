<?php
$this->breadcrumbs=array(
	'Taxrates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Taxrate', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Dividend Tax Rate</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>