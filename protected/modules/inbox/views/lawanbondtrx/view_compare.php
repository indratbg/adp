<?php
$this->breadcrumbs=array(
	'Bond Counter Party Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Bond Counter Party Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>
<?php
 $query="SELECT DISTINCT lawan_type, p.descrip,  capital_tax_pcn, deb_gl_acct, Cre_gl_acct
		FROM MST_LAWAN_BOND_TRX m ,
		( SELECT prm_cd_2, prm_desc AS descrip
		FROM MST_PARAMETER
		WHERE prm_cd_1 = 'LAWAN') p
		WHERE m.lawan_type = p.prm_cd_2
		and lawan_type = '$modelDetail->lawan_type'
		ORDER BY 1";
$lawan_type_list=DAO::queryRowSql($query);
?>
<?php
 $query="SELECT DISTINCT lawan_type, p.descrip,  capital_tax_pcn, deb_gl_acct, Cre_gl_acct
		FROM MST_LAWAN_BOND_TRX m ,
		( SELECT prm_cd_2, prm_desc AS descrip
		FROM MST_PARAMETER
		WHERE prm_cd_1 = 'LAWAN') p
		WHERE m.lawan_type = p.prm_cd_2
		and lawan_type = '$modelDetailUpd->lawan_type'
		ORDER BY 1";
$lawan_type_list1=DAO::queryRowSql($query);
?>
<h1>View Bond Counter Party Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Bond Counter Party</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetail,
			'id'=>'tablecompare',
			'attributes'=>array(
						'lawan',
						'lawan_name',	
						'ctp_cd',
						'custody_cbest_cd',
						array('name'=>'lawan_type','value'=>$lawan_type_list['descrip']),
						'capital_tax_pcn',
						'phone',
						'fax',
						'contact_person',
						'e_mail',
						'deb_gl_acct',
						'cre_gl_acct',
						'sl_acct_cd',
						'participant',
						'is_active'
				
				
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailUpd,
			'id'=>'tableupdated',
			'attributes'=>array(
							'lawan',
							'lawan_name',	
							'ctp_cd',
							'custody_cbest_cd',
							array('name'=>'lawan_type','value'=>$lawan_type_list1['descrip']),
							'capital_tax_pcn',
							'phone',
							'fax',
							'contact_person',
							'e_mail',
							'deb_gl_acct',
							'cre_gl_acct',
							'sl_acct_cd',
							'participant',
							'is_active'
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
