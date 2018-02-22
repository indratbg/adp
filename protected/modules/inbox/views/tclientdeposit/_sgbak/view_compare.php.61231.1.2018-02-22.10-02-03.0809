<?php
$this->breadcrumbs=array(
	'Deposit Client Entry Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Deposit Client Inbox #'.$model->update_seq, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>




<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Deposit Client</h4> 


<br/>

<?php if($modelChildDetailCurr){ ?>
<table id='tableAcct' class='table table-bordered table-condensed' style="width: 100%">
	<thead>
		<tr>
			<th width="50px"></th>
			<th width="80px">Client Cd</th>
			<th width="50px">Journal Ref</th>
			<th width="50px">Mutasi</th>
			<th width="30px">Tambah</th>
			<th width="30px">Kurang</th>
			<th width="150px">No Perjanjian</th>
			<th width="30px">Type</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelChildDetailCurr as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->trx_date  ?></td>
			<td><?php echo $row->client_cd ?></td>
			<td><?php echo $row->folder_cd ?></td>
			<td><?php echo $row->debit==0?'Tambahkan':'Kurangi' ?></td>
			<td style="text-align: right"><?php echo number_format((float)$row->credit,2,',','.') ?></td>
			<td style="text-align: right"><?php echo  number_format((float)$row->debit,2,',','.') ?></td>
			<td><?php echo $row->no_perjanjian ?></td>
			<td><?php echo AConstant::$doc_type_client_deposit[$row->doc_type] ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
<?php } ?>



<h4>Data Deposit Client(Updated)</h4>

<br/>

<?php if($modelChildDetail){ ?>
<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="50px"></th>
			<th width="80px">Client Cd</th>
			<th width="50px">Journal Ref</th>
			<th width="50px">Mutasi</th>
			<th width="30px">Tambah</th>
			<th width="30px">Kurang</th>
			<th width="150px">No Perjanjian</th>
			<th width="30px">Type</th>
			<th width="20px">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelChildDetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->trx_date ?></td>
			<td><?php echo $row->client_cd ?></td>
			<td><?php echo $row->folder_cd ?></td>
			<td><?php echo $row->mvmt_type ?></td>
			<td style="text-align: right"><?php echo number_format((float)$row->credit,2,',','.') ?></td>
			<td style="text-align: right"><?php echo number_format((float)$row->debit,2,',','.') ?></td>
			<td><?php echo $row->no_perjanjian ?></td>
			<td><?php echo AConstant::$doc_type_client_deposit[$row->doc_type] ?></td>
			<td><?php echo AConstant::$inbox_stat[$listTmanyChildDetail[$x-1][0]->upd_status] ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
<?php } ?>
  <script>
  /*
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
  */
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
