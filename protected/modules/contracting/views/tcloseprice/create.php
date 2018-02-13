<?php
$this->breadcrumbs=array(
	'Tclosepricegens'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Close Price', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Close Price</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>