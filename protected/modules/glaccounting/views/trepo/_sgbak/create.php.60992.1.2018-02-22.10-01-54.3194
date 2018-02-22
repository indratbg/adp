<?php
$this->breadcrumbs=array(
	'Trepos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Input Repo', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);
?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'modelHist'=>$modelHist,'modelVch'=>$modelVch,'perpanjangan'=>$perpanjangan,'voucher'=>$voucher)); ?>