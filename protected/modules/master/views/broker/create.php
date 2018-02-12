<?php
/* @var $this BrokerController */
/* @var $model Broker */

$this->breadcrumbs=array(
	'Brokers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Broker', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Create Broker</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>