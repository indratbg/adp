<?php
$this->breadcrumbs=array(
	'Securities Ledgers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'SecuritiesLedger', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
);
?>

<h1>Securities Journal Account Code</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>