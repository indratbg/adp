<?php
$this->breadcrumbs=array(
	'Portofolio yang Dijaminkan'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Portofolio yang Dijaminkan', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Input Portofolio yang Dijaminkan</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>