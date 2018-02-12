<?php
$this->breadcrumbs=array(
	'Tipoclients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Tipoclient', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Input Client IPO Stock</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'criteria_stk'=>$criteria_stk,'criteria_client'=>$criteria_client,'client'=>'')); ?>