<?php
$this->breadcrumbs=array(
	'Haircut MKBD'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Haircut MKBD', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Haircut MKBD</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>