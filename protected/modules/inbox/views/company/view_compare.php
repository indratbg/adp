<?php
$this->breadcrumbs=array(
	'Company Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Company Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Company Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Company</h4> 
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetail,
			'id'=>'tablecompare',
			'attributes'=>array(
				'kd_broker',
				'nama_prsh',
				'other_1',
				'con_pers_title',
				'contact_pers',
				array('name'=>'round','type'=>'number'),
				array('name'=>'limit_mkbd','type'=>'number'),
				'kom_fee_pct',
				'vat_pct',
				'pph_pct',
				'levy_pct',
				array('name'=>'min_fee_flag','value'=>AConstant::$is_flag_ch[$modelDetail->min_fee_flag]),
				array('name'=>'min_value','type'=>'number'),
				array('name'=>'min_charge','type'=>'number'),
				'brok_nom_asing',
				'brok_nom_lokal',
				'jenis_ijin1',
				'no_ijin1',
				array('name'=>'tgl_ijin1','type'=>'date'),
				'jenis_ijin2',
				'no_ijin2',
				array('name'=>'tgl_ijin2','type'=>'date'),
				'jenis_ijin3',
				'no_ijin3',
				array('name'=>'tgl_ijin3','type'=>'date'),
				'jenis_ijin4',
				'no_ijin4',
				array('name'=>'tgl_ijin4','type'=>'date'),
				'jenis_ijin5',
				'no_ijin5',
				array('name'=>'tgl_ijin5','type'=>'date'),
				'other_2',
				'def_addr_1',
				'def_addr_2',
				'def_addr_3',
				'post_cd',
				'phone_num',
				'hp_num',
				'fax_num',
				'e_mail1',
			),
		)); ?>
	</div>
	<div class="span6">
		<?php 
			$this->widget('bootstrap.widgets.TbDetailView',array( 
			    'data'=>$modelDetailUpd,
			    'id'=>'tableupdated', 
			    'attributes'=>array( 
			    	'kd_broker',
					'nama_prsh',
					'other_1',
					'con_pers_title',
					'contact_pers',
					array('name'=>'round','type'=>'number'),
					array('name'=>'limit_mkbd','type'=>'number'),
					array('name'=>'jsx_listed','value'=>AConstant::$is_flag_ch[$modelDetailUpd->jsx_listed]),
					array('name'=>'ssx_listed','value'=>AConstant::$is_flag_ch[$modelDetailUpd->ssx_listed]),
					'kom_fee_pct',
					'vat_pct',
					'pph_pct',
					'levy_pct',
					array('name'=>'min_fee_flag','value'=>AConstant::$is_flag_ch[$modelDetailUpd->min_fee_flag]),
					array('name'=>'min_value','type'=>'number'),
					array('name'=>'min_charge','type'=>'number'),
					'brok_nom_asing',
					'brok_nom_lokal',
					'jenis_ijin1',
					'no_ijin1',
					array('name'=>'tgl_ijin1','type'=>'date'),
					'jenis_ijin2',
					'no_ijin2',
					array('name'=>'tgl_ijin2','type'=>'date'),
					'jenis_ijin3',
					'no_ijin3',
					array('name'=>'tgl_ijin3','type'=>'date'),
					'jenis_ijin4',
					'no_ijin4',
					array('name'=>'tgl_ijin4','type'=>'date'),
					'jenis_ijin5',
					'no_ijin5',
					array('name'=>'tgl_ijin5','type'=>'date'),
					'other_2',
					'def_addr_1',
					'def_addr_2',
					'def_addr_3',
					'post_cd',
					'phone_num',
					'hp_num',
					'fax_num',
					'e_mail1',
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
