<?php
$this->breadcrumbs=array(
	'Client Settlement Days Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Client Settlement Days Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Client Settlement Days Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Client Settlement Days</h4> 
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$modelDetail,
				'id'=>'tablecompare',
				'attributes'=>array(
					'exch_cd',
					//array('name'=>'Client','value'=>$modelDetail->client->getConcatForSettlementClientCmb()),
					'client_cd',
					array('name'=>'eff_dt','type'=>'date'),
					array('name'=>'market_type','value'=>Parameter::getParamDesc('MARKET', $modelDetail->market_type)),
					array('name'=>'ctr_type','value'=>Parameter::getParamDesc('CTRTYP', $modelDetail->ctr_type)),
					array('name'=>'sale_sts','value'=>AConstant::$settle_client_sale_sts[$modelDetail->sale_sts]),
					'script_sts',
					array('name'=>'csd_script','type'=>'number'),
					array('name'=>'csd_value','type'=>'number'),
					array('name'=>'kds_script','type'=>'number'),
					array('name'=>'kds_value','type'=>'number'),
				),
			)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$modelDetailUpd,
				'id'=>'tableupdated',
				'attributes'=>array(
					'exch_cd',
					//array('name'=>'Client','value'=>$modelDetailUpd->client->getConcatForSettlementClientCmb()),
					'client_cd',
					array('name'=>'eff_dt','type'=>'date'),
					array('name'=>'market_type','value'=>Parameter::getParamDesc('MARKET', $modelDetailUpd->market_type)),
					array('name'=>'ctr_type','value'=>Parameter::getParamDesc('CTRTYP', $modelDetailUpd->ctr_type)),
					array('name'=>'sale_sts','value'=>AConstant::$settle_client_sale_sts[$modelDetailUpd->sale_sts]),
					'script_sts',
					array('name'=>'csd_script','type'=>'number'),
					array('name'=>'csd_value','type'=>'number'),
					array('name'=>'kds_script','type'=>'number'),
					array('name'=>'kds_value','type'=>'number'),
				),
			)); ?>
	 </div>
  </div>
  <script>
  		var ctr  = 0;
  		$('#tableupdated tbody tr td').each(function() {
  			var temp  = $(this).html().trim();
  			var temp2 = ($('#tablecompare tbody tr td').get(ctr).innerHTML).trim();
  			
  			console.log(temp+" "+temp2);
  			if(temp != temp2){
  				temp = '<span class="label label-success">'+temp+'</span>';
  				$(this).html(temp);
  			}
  			ctr++;
  		});
  </script>

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
