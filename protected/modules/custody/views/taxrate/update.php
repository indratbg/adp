<?php
$this->breadcrumbs=array(
	'Taxrates'=>array('index'),
	$model->seqno=>array('view','id'=>$model->seqno),
	'Update',
);

$this->menu=array(
	array('label'=>'Taxrate', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->seqno),'icon'=>'eye-open'),
);
?>

<h1>Update Dividend Taxrate <?php echo $model->seqno; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>