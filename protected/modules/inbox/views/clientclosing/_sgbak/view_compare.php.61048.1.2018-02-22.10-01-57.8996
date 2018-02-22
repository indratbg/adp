<?php
$this->breadcrumbs=array(
	'Client Closing Inbox'=>array('index'),
	$model->update_seq, 
);

$this->menu=array(
	array('label'=>'Client Closing Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Client Closing Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<!--
<h4>Data Client Closing</h4> 
<div class="row-fluid">
	<div class="span6">
	<?php /*$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$modelTclientclosing,
		'attributes'=>array(
			'client_cd',
			'client_name',
		),
	)); */?> 
	</div>
</div>
-->
<?php if($modelClient && $modelClientUpd){?>
<h4>Data Closed Client</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelClient,
			'id'=>'tablecompare',
			'attributes'=>array(
				'client_cd',
				'sid',
				'client_name',
				'susp_stat',
				array('name'=>'Sub Rekening 001','value'=>$subrek001),
				array('name'=>'closed_date','type'=>'date'),
				//'closed_ref'
			),
		)); ?>
	</div>
	<div class="span6">
		<?php 
			$this->widget('bootstrap.widgets.TbDetailView',array( 
			    'data'=>$modelClientUpd,
			    'id'=>'tableupdated', 
			    'attributes'=>array( 
			    	'client_cd',
			    	'sid',
					'client_name',
					'susp_stat',
					array('name'=>'Sub Rekening 001','value'=>$subrek001),
					array('name'=>'closed_date','type'=>'date'),
					//'closed_ref'
			    ), 
			)); ?>
	 </div>
</div>
<?php }?>
<?php if($modelClientFlacct && $modelClientFlacctUpd){?>
<h4>Data Investor Account</h4>
	<?php for($a=1;$a<=sizeof($modelClientFlacct);$a++){?>
<h6><?php echo $a;?>)</h6>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelClientFlacct[$a],
			'id'=>'tablecompare',
			'attributes'=>array(
				'client_cd',
				'bank_cd',
				'bank_acct_num',
				'acct_name',
				'acct_stat'
			),
		)); ?>
	</div>
	<div class="span6">
		<?php 
			$this->widget('bootstrap.widgets.TbDetailView',array( 
			    'data'=>$modelClientFlacctUpd[$a],
			    'id'=>'tableupdated', 
			    'attributes'=>array( 
			    	'client_cd',
					'bank_cd',
					'bank_acct_num',
					'acct_name',
					'acct_stat'
			    ), 
			)); ?>
	 </div>
</div>
	<?php }?>
<?php }?>
<h4>Data GL Account</h4>
<?php for($a=1;$a<=sizeof($modelGlAccount);$a++){?>
<h6><?php echo $a;?>)</h6>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelGlAccount[$a],
			'id'=>'tablecompare',
			'attributes'=>array(
				'gl_a',
				'sl_a',
				'acct_stat'
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array( 
		    'data'=>$modelGlAccountUpd[$a],
		    'id'=>'tableupdated', 
		    'attributes'=>array( 
		    	'gl_a',
				'sl_a',
				'acct_stat'
		    ), 
		)); ?>
	 </div>
</div>
<?php }?>
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
