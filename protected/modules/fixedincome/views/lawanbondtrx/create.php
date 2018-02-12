<?php
$this->breadcrumbs=array(
	'Lawan Bond Trxes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Counter Party', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Counter Party Entry</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>