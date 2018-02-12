<?php
$this->breadcrumbs=array(
	'Voucher Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Voucher Inbox #'.$model->update_seq, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Voucher</h4>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'voucher',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelParentDetailCurr,'payrec_num',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetailCurr,'payrec_num',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->label($modelParentDetailCurr,'payrec_date',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetailCurr,'payrec_date',array('class'=>'span4','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelParentDetailCurr->payrec_date))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelParentDetailCurr,'payrec_type',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetailCurr,'payrec_type',array('class'=>'span4','readonly'=>'readonly','value'=>substr($modelParentDetailCurr->payrec_type,0,1)=='R'?'RECEIPT':'PAYMENT')); ?>
	</div>
	<div class="span6">
		<?php echo $form->label($modelParentDetailCurr,'client_cd',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetailCurr,'client_cd',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelParentDetailCurr,'folder_cd',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetailCurr,'folder_cd',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->label($modelParentDetailCurr,'curr_amt',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetailCurr,'curr_amt',array('class'=>'span4','readonly'=>'readonly','style'=>'text-align:right','value'=>Tmanydetail::reformatNumber($modelParentDetailCurr->curr_amt))); ?>
	</div>
</div>

<?php echo $form->label($modelParentDetailCurr,'remarks',array('class'=>'control-label')) ?>
<?php echo $form->textField($modelParentDetailCurr,'remarks',array('class'=>'span4','readonly'=>'readonly')); ?>

<?php $this->endWidget(); ?>

<br/><br/>

<?php if($modelChildDetailCurr){ ?>
<table id='tableLedger' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="3%">ID#</th>
			<th width="10%">Doc Date</th>
			<th width="9%">Gl Acct Code</th>
			<th width="13%">Sl Acct Code</th>
			<th width="15%">Debit Amount</th>
			<th width="15%">Credit Amount</th>
			<th width="35%">Ledger Narrative</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelChildDetailCurr as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->tal_id ?></td>
			<td><?php echo Tmanydetail::reformatDate($row->doc_date) ?></td>
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd ?></td>
			<td style="text-align:right"><?php if($row->db_cr_flg == 'D')echo Tmanydetail::reformatNumber($row->curr_val);else echo '0.00'; ?></td>
			<td style="text-align:right"><?php if($row->db_cr_flg == 'C')echo Tmanydetail::reformatNumber($row->curr_val);else echo '0.00'; ?></td>
			<td><?php echo $row->ledger_nar ?></td>
		</tr>
	<?php $x++;} ?>
		<tr>
			<td colspan=4></td>
			<td style="text-align:right"><?php $debit=0; foreach($modelChildDetailCurr as $row)if($row->db_cr_flg == 'D')$debit+=$row->curr_val;echo Tmanydetail::reformatNumber($debit); ?></td>
			<td style="text-align:right"><?php $credit=0; foreach($modelChildDetailCurr as $row)if($row->db_cr_flg == 'C')$credit+=$row->curr_val;echo Tmanydetail::reformatNumber($credit); ?></td>
			<td></td>
		</tr>
	</tbody>
</table>
<?php } ?>

<br/><br/><br/>

<h4>Data Voucher (Updated)</h4>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'voucher',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelParentDetail,'payrec_num',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetail,'payrec_num',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->label($modelParentDetail,'payrec_date',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetail,'payrec_date',array('class'=>'span4','readonly'=>'readonly','value'=>Tmanydetail::reformatDate($modelParentDetail->payrec_date))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelParentDetail,'payrec_type',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetail,'payrec_type',array('class'=>'span4','readonly'=>'readonly','value'=>substr($modelParentDetail->payrec_type,0,1)=='R'?'RECEIPT':'PAYMENT')); ?>
	</div>
	<div class="span6">
		<?php echo $form->label($modelParentDetail,'client_cd',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetail,'client_cd',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->label($modelParentDetail,'folder_cd',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetail,'folder_cd',array('class'=>'span4','readonly'=>'readonly')); ?>
	</div>
	<div class="span6">
		<?php echo $form->label($modelParentDetail,'curr_amt',array('class'=>'control-label')) ?>
		<?php echo $form->textField($modelParentDetail,'curr_amt',array('class'=>'span4','readonly'=>'readonly','style'=>'text-align:right','value'=>Tmanydetail::reformatNumber($modelParentDetail->curr_amt))); ?>
	</div>
</div>

<?php echo $form->label($modelParentDetail,'remarks',array('class'=>'control-label')) ?>
<?php echo $form->textField($modelParentDetail,'remarks',array('class'=>'span4','readonly'=>'readonly')); ?>

<?php $this->endWidget(); ?>

<br/><br/>

<?php if($modelChildDetail){ ?>
<table id='tableLedger' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="3%">ID#</th>
			<th width="10%">Doc Date</th>
			<th width="9%">Gl Acct Code</th>
			<th width="13%">Sl Acct Code</th>
			<th width="15%">Debit Amount</th>
			<th width="15%">Credit Amount</th>
			<th width="35%">Ledger Narrative</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelChildDetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->tal_id ?></td>
			<td><?php echo Tmanydetail::reformatDate($row->doc_date) ?></td>
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd ?></td>
			<td style="text-align:right"><?php if($row->db_cr_flg == 'D')echo Tmanydetail::reformatNumber($row->curr_val);else echo '0.00'; ?></td>
			<td style="text-align:right"><?php if($row->db_cr_flg == 'C')echo Tmanydetail::reformatNumber($row->curr_val);else echo '0.00'; ?></td>
			<td><?php echo $row->ledger_nar ?></td>
		</tr>
	<?php $x++;} ?>
		<tr>
			<td colspan=4></td>
			<td style="text-align:right"><?php $debit=0; foreach($modelChildDetail as $row)if($row->db_cr_flg == 'D')$debit+=$row->curr_val;echo Tmanydetail::reformatNumber($debit); ?></td>
			<td style="text-align:right"><?php $credit=0; foreach($modelChildDetail as $row)if($row->db_cr_flg == 'C')$credit+=$row->curr_val;echo Tmanydetail::reformatNumber($credit); ?></td>
			<td></td>
		</tr>
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
