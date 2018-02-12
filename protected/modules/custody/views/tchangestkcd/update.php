<?php
$this->breadcrumbs=array(
	'Changed Tickers'=>array('index'),
	$model->stk_cd_old=>array('view','id'=>$model->stk_cd_old),
	'Update',
);

$this->menu=array(
	array('label'=>'Changed Ticker', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->stk_cd_old),'icon'=>'eye-open'),
);
?>

<h1>Update Changed Ticker <?php echo $model->stk_cd_old; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>