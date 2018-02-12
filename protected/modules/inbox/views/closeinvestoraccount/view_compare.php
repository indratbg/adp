<?php
$this->breadcrumbs=array(
	'Clientflacct Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Clientflacct Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Clientflacct Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Clientflacct</h4> 
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetail,
			'id'=>'tablecompare',
			'attributes'=>array(
				array('name'=>'client_cd','value'=>$modelDetail->client_cd.' - '.$modelDetail->client->client_name),
				array('name'=>'bank_cd','value'=>$modelDetail->bank_cd.' - '.$modelDetail->bank->bank_name),
				'bank_acct_num',
				'acct_name',
				//'acct_stat',
				array('name'=>'acct_stat','value'=>AConstant::$acct_stat2[$modelDetail->acct_stat]),
				'bank_short_name',
				'bank_acct_fmt',
			),
		)); ?>
	</div>
	<div class="span6">
		<?php 
			$this->widget('bootstrap.widgets.TbDetailView',array( 
			    'data'=>$modelDetailUpd,
			    'id'=>'tableupdated', 
			    'attributes'=>array( 
			    	array('name'=>'client_cd','value'=>$modelDetailUpd->client_cd.' - '.$modelDetailUpd->client->client_name),
					array('name'=>'bank_cd','value'=>$modelDetailUpd->bank_cd.' - '.$modelDetailUpd->bank->bank_name),
					'bank_acct_num',
					'acct_name',
					//'acct_stat',
					array('name'=>'acct_stat','value'=>AConstant::$acct_stat2[$modelDetailUpd->acct_stat]),
					'bank_short_name',
					'bank_acct_fmt',
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