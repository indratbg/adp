<?php
$this->breadcrumbs=array(
	'Tcontracts'=>array('indexintra'),
	//$model->contr_num=>array('view','id'=>$model->contr_num),
	'Update',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List Intra Broker','url'=>array('indexintra'),'icon'=>'list'),
	//array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	//array('label'=>'View','url'=>array('view','id'=>$model->contr_num),'icon'=>'eye-open'),
);
?>

<h1>Update Contract Intra Broker <?php echo $model->contr_num; ?></h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_formintra',array('model'=>$model)); ?>