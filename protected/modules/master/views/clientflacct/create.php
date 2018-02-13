<?php
$this->breadcrumbs=array(
	'Clientflaccts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Clientflacct', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Investor Account</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'listMask'=>$listMask)); ?>