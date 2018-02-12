<?php
$this->breadcrumbs=array(
	'Stock Movement Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Stock Movement Inbox #'.$model->update_seq, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Stock Movement</h4> 

<?php if(isset($modelDetailMove)): ?>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetail,
			'attributes'=>array(
				array('name'=>'doc_dt','type'=>'date'),
				'movement_type',
				'movement_type_2',
				'sl_desc_debit',
				'sl_desc_credit',
				'client_cd',
				'stk_cd',
				'withdraw_reason_cd',
				 array('name'=>'qty','value'=>number_format($modelDetail->qty,0)),
				 array('name'=>'price','value'=>number_format($modelDetail->price,0)),
				'doc_rem',
			),
		)); ?>
	</div>
	<div class="span6">
		<?php 
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$modelDetailMove,
				'attributes'=>array(
					array('name'=>'doc_dt','type'=>'date'),
					'movement_type',
					'movement_type_2',
					'sl_desc_debit',
					'sl_desc_credit',
					'client_cd',
					'stk_cd',
					'withdraw_reason_cd',
					 array('name'=>'qty','value'=>number_format($modelDetail->qty,0)),
					 array('name'=>'price','value'=>number_format($modelDetail->price,0)),
					'doc_rem',
				),
			));
		?>
	</div>
</div>
<?php else: ?>
	<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetail,
			'attributes'=>array(
				array('name'=>'doc_dt','type'=>'date'),
				'movement_type',
				'movement_type_2',
				'sl_desc_debit',
				'sl_desc_credit',
				'client_cd',
				'stk_cd',
				'withdraw_reason_cd',
				 array('name'=>'qty','value'=>number_format($modelDetail->qty,0)),
				 array('name'=>'price','value'=>number_format($modelDetail->price,0)),
				'doc_rem',
			),
		)); ?>
<?php endif; ?>

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