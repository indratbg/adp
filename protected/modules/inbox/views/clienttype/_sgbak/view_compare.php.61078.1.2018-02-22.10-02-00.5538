<?php
$this->breadcrumbs=array(
	'Client Type Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Client Type Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Client Type Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Client Type</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array( 
			'data'=>$modelDetail,
			'id'=>'tablecompare',
			'attributes'=>array(
				array('name'=>'cl_type1','value'=>Constanta::$client_type1[$modelDetail->cl_type1]),
				array('name'=>'cl_type2','value'=>Constanta::$client_type2[$modelDetail->cl_type2]),
				array('name'=>'cl_type3','value'=>Constanta::$client_type3[trim($modelDetail->cl_type3)]),
				'type_desc',
				//'dup_contract',
				//'avg_contract',
				//'nett_allow',
				//'rebate_pct',
				//'comm_pct',
				//'user_id',
				//array('name'=>'cre_dt','type'=>'date'),
				//array('name'=>'upd_dt','type'=>'date'),
				'os_p_acct_cd',
				'os_s_acct_cd',
				'os_contra_g_acct_cd',
				'os_contra_l_acct_cd',
				//'os_setoff_g_acct_cd',
			//	'os_setoff_l_acct_cd',
				//'int_on_payable',
				//'int_on_receivable',
				//'int_on_pay_chrg_cd',
				//'int_on_rec_chrg_cd',
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailUpd,
			'id'=>'tableupdated',
			'attributes'=>array(
				array('name'=>'cl_type1','value'=>Constanta::$client_type1[$modelDetailUpd->cl_type1]),
				array('name'=>'cl_type2','value'=>Constanta::$client_type2[$modelDetailUpd->cl_type2]),
				array('name'=>'cl_type3','value'=>Constanta::$client_type3[trim($modelDetailUpd->cl_type3)]),
				'type_desc',
				//'dup_contract',
				//'avg_contract',
				//'nett_allow',
				//'rebate_pct',
				//'comm_pct',
				//'user_id',
				//array('name'=>'cre_dt','type'=>'date'),
				//array('name'=>'upd_dt','type'=>'date'),
				'os_p_acct_cd',
				'os_s_acct_cd',
				'os_contra_g_acct_cd',
				'os_contra_l_acct_cd',
				//'os_setoff_g_acct_cd',
			//	'os_setoff_l_acct_cd',
				//'int_on_payable',
				//'int_on_receivable',
				//'int_on_pay_chrg_cd',
				//'int_on_rec_chrg_cd',
			),
		)); ?>
	</div>
 </div>
  <script>
  		var ctr  = 0;
  		$('#tableupdated tbody tr td').each(function() {
  			var temp  = $(this).html().trim();
  			var temp2 = ($('#tablecompare tbody tr td').get(ctr).innerHTML).trim();
  			
  			if(!temp)temp = '-';
  			
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
