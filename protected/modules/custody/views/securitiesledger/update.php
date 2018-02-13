<?php
$this->breadcrumbs=array(
	'Securities Ledgers'=>array('index'),
	$model->gl_acct_cd=>array('view','gl_acct_cd'=>$model->gl_acct_cd,'ver_bgn_dt'=>$model->ver_bgn_dt),
	'Update',
);

$this->menu=array(
	array('label'=>'SecuritiesLedger', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','gl_acct_cd'=>$model->gl_acct_cd,'ver_bgn_dt'=>$model->ver_bgn_dt),'icon'=>'eye-open'),
);
?>

<h1>Update SecuritiesLedger <?php echo $model->gl_acct_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>