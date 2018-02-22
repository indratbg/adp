<?php
$this->breadcrumbs=array(
	'Bond Master Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Bond Master Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>
<?php $format = new CFormatter;
	$format->numberFormat=array('decimals'=>null, 'decimalSeparator'=>null, 'thousandSeparator'=>',');
 ?>
<h1>View Bond Master Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Bond Master</h4> 

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$modelDetail,
	'attributes'=>array(
		'bond_cd',
				array('name'=>'bond_group_cd','value'=>Parameter::model()->find("prm_cd_1='BONDGR'and prm_cd_2 = '$modelDetail->bond_group_cd'")->prm_desc),
				array('name'=>'product_type','value'=>Parameter::model()->find("prm_cd_1='BPROD' and prm_desc = '$modelDetail->product_type'")?Parameter::model()->find("prm_cd_1='BPROD' and prm_desc = '$modelDetail->product_type'")->prm_desc:'-'),
				'bond_desc',
				'short_desc',
				'isin_code',
				'issuer',
				array('name'=>'sec_sector','value'=>Parameter::model()->find("prm_cd_1='BINDUS' and prm_CD_2 = '$modelDetail->sec_sector'")?Parameter::model()->find("prm_cd_1='BINDUS' and prm_CD_2 = '$modelDetail->sec_sector'")->prm_desc:'-'),
				array('name'=>'maturity_date', 'type'=>'date'),
				array('name'=>'first_coupon_date', 'type'=>'date'),
				array('name'=>'listing_date', 'type'=>'date'),
				array('name'=>'issue_date', 'type'=>'date'),
				array('name'=>'int_type','value'=>Parameter::model()->find("prm_cd_1='BRATE'  and prm_desc = '$modelDetail->int_type'")->prm_desc),
				array('name'=>'interest','value'=>$format->formatNumber($modelDetail->interest)),
				array('name'=>'int_freq','value'=>Parameter::model()->find("prm_cd_1='BFREQ' and prm_desc = '$modelDetail->int_freq'")->prm_desc),
				array('name'=>'day_count_basis','value'=>Parameter::model()->find("prm_cd_1='BDAYC' and prm_desc = '$modelDetail->day_count_basis'")->prm_desc),
				array('name'=>'fee_ijarah','value'=>$format->formatNumber($modelDetail->fee_ijarah)),
				array('name'=>'nisbah','value'=>$format->formatNumber($modelDetail->nisbah)),	
				
		
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
