<?php
$this->breadcrumbs=array(
	'Tstkmovement'=>array('index'),
	$model->doc_num=>array('view','doc_num'=>$model->doc_num,'db_cr_flg'=>$model->db_cr_flg,'seqno'=>$model->seqno),
	'Update',
);

$this->menu=array(
	array('label'=>'Update Stock Movement '.$model->doc_num, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','url'=>array('update','doc_num'=>$model->doc_num,'db_cr_flg'=>$model->db_cr_flg,'seqno'=>$model->seqno),'icon'=>'pencil','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'View','url'=>array('view','doc_num'=>$model->doc_num,'db_cr_flg'=>$model->db_cr_flg,'seqno'=>$model->seqno),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_form_update', array('model'=>$model,'modelReverse'=>$modelReverse,)); ?>