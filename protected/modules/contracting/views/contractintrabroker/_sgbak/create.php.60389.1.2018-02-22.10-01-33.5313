<?php
$this->breadcrumbs=array(
	'Contract Intra Broker'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Contracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Contract Intra Broker</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'defaultbrok'=>$defaultbrok)); ?>