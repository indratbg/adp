<?php
$this->breadcrumbs=array(
	'Operational Bank Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Operational Bank Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Operational Bank Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Operational Bank</h4>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bankMaster',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php echo $form->label($modelParentDetailCurr,'bank_cd',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
<?php echo $form->textFieldRow($modelParentDetailCurr,'bank_cd',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($modelParentDetailCurr,'bank_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($modelParentDetailCurr,'bank_name',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($modelParentDetailCurr,'short_bank_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($modelParentDetailCurr,'short_bank_name',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($modelParentDetailCurr,'rtgs_cd',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($modelParentDetailCurr,'rtgs_cd',array('readonly'=>'readonly','label'=>false)) ?>

<?php $this->endWidget(); ?>

<br/><br/>

<?php if($modelChildDetailCurr){ ?>
<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">Bank Code</th>
			<th width="80px">Main Acct</th>
			<th width="100px">Sub Acct Code</th>
			<th width="150px">Bank Acct Code</th>
			<th width="30px">Account Type</th>
			<th width="30px">Branch Code</th>
			<th width="30px">Vch Prefix</th>
			<th width="30px">Currency</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelChildDetailCurr as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->bank_cd ?></td>
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd ?></td>
			<td><?php echo $row->bank_acct_cd ?></td>
			<td><?php echo $row->bank_acct_type ?></td>
			<td><?php echo $row->brch_cd ?></td>
			<td><?php echo $row->folder_prefix?></td>
			<td><?php echo $row->curr_cd ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
<?php } ?>

<br/><br/><br/>

<h4>Data Operational Bank(Updated)</h4>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bankMaster',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php echo $form->label($modelParentDetail,'bank_cd',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
<?php echo $form->textFieldRow($modelParentDetail,'bank_cd',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($modelParentDetail,'bank_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($modelParentDetail,'bank_name',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($modelParentDetail,'short_bank_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($modelParentDetail,'short_bank_name',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($modelParentDetail,'rtgs_cd',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($modelParentDetail,'rtgs_cd',array('readonly'=>'readonly','label'=>false)) ?>

<?php $this->endWidget(); ?>

<br/><br/>

<?php if($modelChildDetail){ ?>
<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">Bank Code</th>
			<th width="80px">Main Acct</th>
			<th width="100px">Sub Acct Code</th>
			<th width="150px">Bank Acct Code</th>
			<th width="30px">Account Type</th>
			<th width="30px">Branch Code</th>
			<th width="30px">Vch Prefix</th>
			<th width="30px">Currency</th>
			<th width="20px">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelChildDetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->bank_cd ?></td>
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd ?></td>
			<td><?php echo $row->bank_acct_cd ?></td>
			<td><?php echo $row->bank_acct_type ?></td>
			<td><?php echo $row->brch_cd ?></td>
			<td><?php echo $row->folder_prefix?></td>
			<td><?php echo $row->curr_cd ?></td>
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
