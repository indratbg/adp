<?php
$this->breadcrumbs=array(
	'Deposito Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Deposito Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
	
);
?>

<h1>View Deposito Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Deposito</h4> 

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$modelDetail,
	'attributes'=>array(
		'ref_num',
		array('name'=>'bank','value'=>Ipbank::model()->find("approved_stat = 'A' AND bank_cd ='$modelDetail->bank_cd'")->bank_name),
		'bank_branch',
		array('name'=>'type','value'=>Parameter::model()->find("prm_cd_1 = 'BANKTY' AND prm_cd_2 ='$modelDetail->bank_type'")->prm_desc),
		array('name'=>'from_dt','type'=>'date'),
		array('name'=>'to_dt','type'=>'date'),
		array('name'=>'amount','type'=>'number'),
		array('name'=>'jaminan_lps','type'=>'number'),
	),
)); ?>

<h4>Approval Attributes</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'status','value'=>AConstant::$inbox_stat[$model->status]),
				array('name'=>'update_date','type'=>'datetime'),
				'user_id',
				'ip_address',
				array('name'=>'cancel_reason','type'=>'raw','value'=>nl2br($model->cancel_reason)),
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'approved_status','value'=>AConstant::$inbox_app_stat[$model->approved_status]),
				array('name'=>'approved_date','type'=>'datetime'),
				'approved_user_id',
				array('name'=>'reject_reason','type'=>'raw','value'=>nl2br($model->reject_reason)),
			),
		)); ?>
	</div>
</div>

<?php if($model->approved_status == AConstant::INBOX_APP_STAT_ENTRY): ?>	
	<br/>
	<div style="text-align:right;">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'ok',
			'url'=>$this->createUrl('approve',array('id'=>$model->primaryKey)),
			'label'=>'Approve',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'remove',
			'url'=>$this->createUrl('reject',array('id'=>$model->primaryKey)),
			'htmlOptions'=>array('class'=>'reject-inbox'),
			'label'=>'Reject',
		)); ?>
	</div>
	<?php 
		$param  = array(array('class'=>'reject-inbox','title'=>'Reject Reason','url'=>'AjxPopReject','urlparam'=>array('id'=>$model->primaryKey,'label'=>false)));
	  	AHelper::popupwindow($this, 600, 500, $param);
	?>
<?php endif; ?>
