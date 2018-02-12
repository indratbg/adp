<?php
$this->breadcrumbs=array(
	'Consolidation Journal Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Consolidation Journal Entry Inbox #'.$model->update_seq, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Consolidation Journal</h4> 

<?php //$this->widget('bootstrap.widgets.TbDetailView',array(
	//'data'=>$modelParentDetail,
//	'attributes'=>array(
	/*'xn_doc_num',
	'folder_cd',
	array('name'=>'doc_date','type'=>'date'),
	'tal_id',
	'entity',
	'gl_acct_cd',
	'sl_acct_cd',
	array('name'=>'db_cr_flg','value'=>Constanta::$gljournal[$modelParentDetail->db_cr_flg]),
	array('name'=>'curr_val','value'=>number_format((float)$modelParentDetail->curr_val,2,'.',',')),
	'ledger_nar',
	*/
//	),
//)); ?>

<?php if($modelChildDetail){ ?>
<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">Journal Code</th>
			<th width="80px">Date</th>
			<th width="30px">No. Urut</th>
			<th width="30px">Entity</th>
			<th width="40px">Gl Main Acct Cd</th>
			<th width="40px">Sl Acct Cd</th>
			<th width="30px">Debit/Credit</th>
			<th width="100px">Amount</th>
			<th width="210px">Description</th>
			<th width="30px">Status</th>
		</tr>
	</thead>
	<tbody>
		
	<?php $x = 1;
	
		foreach($modelChildDetail as $row){
		if(DateTime::createFromFormat('Y/m/d H:i:s',$row->doc_date))$row->doc_date=DateTime::createFromFormat('Y/m/d H:i:s',$row->doc_date)->format('d M Y');	 
		if(DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date))$row->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('d M Y');
	?>
		<tr id="row<?php echo $x ?>">
			<td>
				<?php echo $row->xn_doc_num ?>
			</td>
			<td>
				<?php echo $row->doc_date ?>
			</td>
			<td><?php echo $row->tal_id ?></td>
			<td><?php echo $row->entity?></td>
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd?></td>
			<td><?php echo Constanta::$gljournal[$row->db_cr_flg] ?></td>
			<td style="text-align: right">
				<?php echo number_format((float)$row->curr_val,2,'.',',') ?>
			</td>
			<td>
				<?php echo $row->ledger_nar ?>
			</td>
			<td><?php echo AConstant::$inbox_stat[$listTmanyChildDetail[$x-1][0]->upd_status] ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
<?php } ?>
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
			//'id'=>'btnApprove',
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
