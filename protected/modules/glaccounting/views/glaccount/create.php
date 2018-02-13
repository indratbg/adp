<?php
$this->breadcrumbs=array(
	'Glaccounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Glaccount', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create GL Account</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>