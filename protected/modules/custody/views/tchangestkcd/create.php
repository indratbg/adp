<?php
$this->breadcrumbs=array(
	'Changed Tickers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Changed Ticker', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Change Ticker</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>