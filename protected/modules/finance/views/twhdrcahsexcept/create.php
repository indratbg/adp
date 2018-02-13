<?php
$this->breadcrumbs=array(
	'Withdraw Cash Exception'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Withdraw Cash Exception', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Withdraw Cash Exception</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>