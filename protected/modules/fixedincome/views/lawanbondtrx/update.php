<?php
$this->breadcrumbs=array(
	'Lawan Bond Trxes'=>array('index'),
	$model->lawan=>array('view','id'=>$model->lawan),
	'Update',
);

$this->menu=array(
	array('label'=>'LawanBondTrx', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->lawan),'icon'=>'eye-open'),
);
?>

<h1>Update Counter Party <?php echo $model->lawan; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>