<?php
$this->breadcrumbs=array(
	'Sales Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Sales Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Sales Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Sales</h4> 
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetail,
			'id'=>'tablecompare',
			'attributes'=>array(
				'rem_cd',
				array('name'=>'rem_type','value'=>Sales::$rem_type[$modelDetail->rem_type]),
				array('name'=>'rem_susp_stat','value'=>AConstant::$is_flag_status[$modelDetail->rem_susp_stat]),
				'rem_name',
				'rem_name_abbr',
				array('name'=>'ic_type','value'=>Parameter::getParamDesc('IDTYPE', $modelDetail->ic_type)),
				'rem_ic_num',
				array('name'=>'branch_cd','value'=>Branch::getBranchName($modelDetail->branch_cd)),
				array('name'=>'join_dt','type'=>'date'),
				array('name'=>'lic_num','value'=>Sales::$lic_num[$modelDetail->lic_num]),
				array('name'=>'lic_expry_dt','type'=>'date'),
				
				'def_addr_1',
				'def_addr_2',
				'def_addr_3',
				'post_cd',
				
				'contact_pers',
				'phone_num',
				'handphone_num',
				'fax_num',
			),
		)); ?>
	</div>
	<div class="span6">
		<?php 
			$this->widget('bootstrap.widgets.TbDetailView',array( 
			    'data'=>$modelDetailUpd,
			    'id'=>'tableupdated', 
			    'attributes'=>array( 
			    	'rem_cd',
					array('name'=>'rem_type','value'=>Sales::$rem_type[$modelDetailUpd->rem_type]),
					array('name'=>'rem_susp_stat','value'=>AConstant::$is_flag_status[$modelDetailUpd->rem_susp_stat]),
					'rem_name',
					'rem_name_abbr',
					array('name'=>'ic_type','value'=>Parameter::getParamDesc('IDTYPE', $modelDetailUpd->ic_type)),
					'rem_ic_num',
					array('name'=>'branch_cd','value'=>Branch::getBranchName($modelDetailUpd->branch_cd)),
					array('name'=>'join_dt','type'=>'date'),
					array('name'=>'lic_num','value'=>Sales::$lic_num[$modelDetailUpd->lic_num]),
					array('name'=>'lic_expry_dt','type'=>'date'),
					
					'def_addr_1',
					'def_addr_2',
					'def_addr_3',
					'post_cd',
					
					'contact_pers',
					'phone_num',
					'handphone_num',
					'fax_num',
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
