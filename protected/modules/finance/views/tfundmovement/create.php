<?php
$this->breadcrumbs=array(
	'Manually Input Fund Movement'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'', 'itemOptions'=>array('class'=>'nav-header','style'=>'height:20px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Manually Input Fund Movement</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>