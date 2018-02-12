<?php
$this->breadcrumbs=array(
	'Stock Movement'=>array('index'),
	$model->doc_num,
);

$this->menu=array(
	array('label'=>'View Stock Movement '.$model->doc_num, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','doc_num'=>$model->doc_num,'db_cr_flg'=>$model->db_cr_flg,'seqno'=>$model->seqno),'itemOptions'=>array('style'=>Tstkmovement::checkButtonVisible($model->doc_num, $model->ref_doc_num)?'float:right;display:inline':'float:right;display:none')),
	array('label'=>'View','icon'=>'eye-open','url'=>array('view','doc_num'=>$model->doc_num,'db_cr_flg'=>$model->db_cr_flg,'seqno'=>$model->seqno),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Stock Movement</h4> 

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
			array('name'=>'doc_dt','type'=>'date'),
			'movement_type',
			'movement_type_2',
			'sl_desc_debit',
			'sl_desc_credit',
			'client_cd',
			'stk_cd',
			'withdraw_reason_cd',
			 array('name'=>'qty','value'=>number_format($model->qty,0)),
			 array('name'=>'price','value'=>number_format($model->price,0)),
			'doc_rem',
		),
	)); ?>