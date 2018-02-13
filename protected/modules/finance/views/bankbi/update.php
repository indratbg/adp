<?php
/* @var $this BankbiController */
/* @var $model Bankbi */

$this->breadcrumbs=array(
	'Clearing Code'=>array('index'),
	$model->bi_code=>array('view','id'=>$model->bi_code),
	'Update',
);

$this->menu=array(
	array('label'=>'Bank BI', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->bi_code)),
);
?>

<h1>Update Clearing <?php echo $model->bank_name; ?></h1>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>