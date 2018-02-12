<?php
$this->breadcrumbs=array(
	'Tcontracts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Contracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List Intra Broker','url'=>array('indexintra'),'icon'=>'list'),
);
?>

<h1>Contract Intra Broker</h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_formintra', array('model'=>$model)); ?>