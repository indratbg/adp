<?php
$this->breadcrumbs=array(
	'Fixedassets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Fixedasset', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Input Fixed Asset</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>