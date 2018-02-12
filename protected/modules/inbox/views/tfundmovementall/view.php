<?php
$this->breadcrumbs=array(
	'Upload Fund Movement Inbox'=>array('index'),
	'Unprocessed Upload Rekening Dana Mutation',
);

$this->menu=array(

	array('label'=>'Processed Fund Movement', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
array('label'=>'List','url'=>Yii::app()->request->baseUrl.'?r=finance/tfundmovement/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Unprocessed','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','url'=>array('indexProcessed'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),

);
?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Fund Movement</h4> 

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$modelParentDetail,
	'attributes'=>array(
		array('name'=>'doc_date','type'=>'date'),
		array('name'=>'trx_type','value'=>$modelParentDetail->from_client=='BUNGA'?'BUNGA':Constanta::$movement_type[$modelParentDetail->trx_type]),
		'client_cd',
		'brch_cd',
		array('name'=>'source','value'=>$modelParentDetail->source =='H2H'?'HOST TO HOST':$modelParentDetail->source),
		 array('name'=>'bank_mvmt_date','type'=>'datetime'),
	//	 array('name'=>'bank_mvmt_date','value'=>DateTime::createFromFormat('Y-m-d H:i:s',$modelParentDetail->bank_mvmt_date)?DateTime::createFromFormat('Y-m-d H:i:s',$modelParentDetail->bank_mvmt_date)->format('d M Y H:i:s'):'-'),
		'acct_name',
		'remarks',
		'from_client',
		'from_acct',
		'from_bank',
		'to_client',
		'to_acct',
		'to_bank',
		array('name'=>'trx_amt','value'=>number_format((float)$modelParentDetail->trx_amt,0,'.',',')),
		'fee',
		'folder_cd',
		'fund_bank_cd',
		'fund_bank_acct',
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
			'id'=>'btnApprove',
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


<script>
	$("#btnApprove").click(function(event)
	{
		
		event.preventDefault();
		
		$.ajax({
			type    :"POST",
			url     :this.href,
			success:function(data){
				window.location.reload();								
			},
			statusCode:
			{
				500		: function(data){
					alert("Push Failed");
					window.location.reload();
				}
			}							
		});
	})
</script>
