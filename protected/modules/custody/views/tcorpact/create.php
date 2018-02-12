<?php
$this->breadcrumbs=array(
	'Tcorpacts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Tcorpact', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Corporate Action</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'criteriaCorp'=>$criteriaCorp)); ?>