<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Company', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Company</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'status'=>$status)); ?>