<?php
$this->breadcrumbs=array(
	'IPO Stock Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'IPO Stock Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>
<?php $format = new CFormatter;
	$format->numberFormat=array('decimals'=>null, 'decimalSeparator'=>null, 'thousandSeparator'=>',');
 ?>

<h1>View IPO Stock Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data IPO Stock</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetail,
			'id'=>'tablecompare',
			'attributes'=>array(
				'stk_cd',
				'stk_name',
				'jenis_penjaminan',
				array('name'=>'tgl_kontrak','type'=>'date'),
				array('name'=>'eff_dt_fr','type'=>'date'),
				array('name'=>'eff_dt_to','type'=>'date'),
				array('name'=>'offer_dt_fr','type'=>'date'),
				array('name'=>'offer_dt_to','type'=>'date'),
				array('name'=>'distrib_dt_fr','type'=>'date'),
				array('name'=>'allocate_dt','type'=>'date'), 
				array('name'=>'paym_dt','type'=>'date'),
				array('name'=>'price','value'=>$format->formatNumber($modelDetail->price)),
				array('name'=>'nilai_komitment','value'=>$format->formatNumber($modelDetail->nilai_komitment)),
				array('name'=>'bank_garansi','value'=>$format->formatNumber($modelDetail->bank_garansi)),
				array('name'=>'unsubscribe_qty','value'=>$format->formatNumber($modelDetail->unsubscribe_qty)),
				array('name'=>'order_price','value'=>$format->formatNumber($modelDetail->order_price)),
				
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailUpd,
			'id'=>'tableupdated',
			'attributes'=>array(
				'stk_cd',
				'stk_name',
				'jenis_penjaminan',
				array('name'=>'tgl_kontrak','type'=>'date'),
				array('name'=>'eff_dt_fr','type'=>'date'),
				array('name'=>'eff_dt_to','type'=>'date'),
				array('name'=>'offer_dt_fr','type'=>'date'),
				array('name'=>'offer_dt_to','type'=>'date'),
				array('name'=>'distrib_dt_fr','type'=>'date'),
				array('name'=>'allocate_dt','type'=>'date'), 
				array('name'=>'paym_dt','type'=>'date'),
				array('name'=>'price','value'=>$format->formatNumber($modelDetailUpd->price)),
				array('name'=>'nilai_komitment','value'=>$format->formatNumber($modelDetailUpd->nilai_komitment)),
				array('name'=>'bank_garansi','value'=>$format->formatNumber($modelDetailUpd->bank_garansi)),
				array('name'=>'unsubscribe_qty','value'=>$format->formatNumber($modelDetailUpd->unsubscribe_qty)),
				array('name'=>'order_price','value'=>$format->formatNumber($modelDetailUpd->order_price)),
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
