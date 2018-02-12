<?php
$this->breadcrumbs=array(
	'Bankaccts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Bankacct', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Bankacct</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>