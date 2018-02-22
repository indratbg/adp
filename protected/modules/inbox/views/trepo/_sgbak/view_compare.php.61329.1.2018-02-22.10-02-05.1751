<?php
$this->breadcrumbs=array(
	'Repo Entry Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Repo Inbox #'.$model->update_seq, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Repo </h4> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'trepo',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetailCurr,'repo_type',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'repo_type',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span7">
		<?php echo $form->label($modelParentDetailCurr,'secu_type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'secu_type',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>Parameter::getParamDesc('SECUTY', $modelParentDetailCurr->secu_type))) ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetailCurr,'client_cd',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'client_cd',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span7">
		<?php echo $form->label($modelParentDetailCurr,'client_type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'client_type',array('readonly'=>'readonly','class'=>'span5','label'=>false,'value'=>AConstant::$client_type[$modelParentDetailCurr->client_type])); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetailCurr,'repo_ref',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'repo_ref',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetailCurr,'Tanggal',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'repo_date',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>Tmanydetail::reformatDate($modelParentDetailCurr->repo_date))) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetailCurr,'extent_num',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'extent_num',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetailCurr,'Tanggal',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'extent_dt',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>Tmanydetail::reformatDate($modelParentDetailCurr->extent_dt))) ?>
	</div>
	<div class="span4" style="width:200px">
		<div class="span5" style="margin-left:-30px">
			<?php echo $form->label($modelParentDetailCurr,'Jatuh Tempo',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		</div>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'due_date',array('readonly'=>'readonly','label'=>false,'class'=>'span8','value'=>Tmanydetail::reformatDate($modelParentDetailCurr->due_date))) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetailCurr,'Nilai Perjanjian',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'repo_val',array('readonly'=>'readonly','label'=>false,'class'=>'span8 tnumber','style'=>'text-align:right','value'=>Tmanydetail::reformatNumber($modelParentDetailCurr->repo_val))) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetailCurr,'Bunga %',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'fee_per',array('readonly'=>'readonly','label'=>false,'class'=>'span5 tnumber','style'=>'text-align:right')) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetailCurr,'return_val',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetailCurr,'return_val',array('readonly'=>'readonly','class'=>'span8 tnumber','style'=>'text-align:right','label'=>false,'value'=>Tmanydetail::reformatNumber($modelParentDetailCurr->return_val))); ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetailCurr,'Penghentian Pengakuan',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		<?php echo $form->textField($modelParentDetailCurr,'penghentian_pengakuan',array('class'=>'span2','readonly'=>'readonly','style'=>'width:50px')) ?>
	</div>
	<div class="span4" style="width:200px">
		<div class="span5" style="margin-left:-30px">
			<?php echo $form->label($modelParentDetailCurr,'Serah Saham',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		</div>
		<?php echo $form->textField($modelParentDetailCurr,'serah_saham',array('class'=>'span2','readonly'=>'readonly','style'=>'width:50px')) ?>
	</div>
</div>

<?php $this->endWidget(); ?>

<br/>

<?php if($modelChildDetailCurr){ ?>
<table id='tableHist' class='table table-bordered table-condensed' style='display:<?php if($voucher){ ?>none<?php }else{ ?>table<?php } ?>'>
	<thead>
		<tr>
			<th width="100px">Repo Date</th>
			<th width="100px">Due Date</th>
			<th width="150px">Nomor Perjanjian</th>
			<th width="100px">Nilai</th>
			<th width="100px">Return Value</th>
			<th width="80px">Interest Rate %</th>
			<th width="70px">Tax</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
	if(!$voucher)
		foreach($modelChildDetailCurr as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo Tmanydetail::reformatDate($row->repo_date) ?></td>
			<td><?php echo Tmanydetail::reformatDate($row->due_date) ?></td>
			<td><?php echo $row->repo_ref ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->repo_val) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->return_val) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->interest_rate) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->interest_tax) ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<table id='tableVch' class='table table-bordered table-condensed' style='display:<?php if($voucher){ ?>table<?php }else{ ?>none<?php } ?>'>
	<thead>
		<tr>
			<th width="30%">Journal Ref</th>
			<th width="13%">Voucher Type</th>
			<th width="10%">Date</th>
			<th width="8%">Vch Ref</th>
			<th width="12%">Amount</th>
			<th width="27%"></th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
	if($voucher)
		foreach($modelChildDetailCurr as $row){ 
	?>
		<tr id="rowVch<?php echo $x ?>">
			<td><?php if($row->doc_num != '-')echo $row->doc_num.' - '.$row->doc_ref_num;else echo '-' ?></td>
			<td>
				<?php 
					switch($row->payrec_type)
					{
						case 'RD':
							$row->payrec_type = 'Receipt';
							break;
						case 'PD':
							$row->payrec_type = 'Payment';
							break;
						case 'RV':
							$row->payrec_type = 'Receipt to Settle';
							break;
						case 'PV':
							$row->payrec_type = 'Payment to Settle';
							break;
						default:
							$row->payrec_type = 'PB';
							break;
					}
				?>
				<?php echo $row->payrec_type ?>
			</td>
			<td><?php echo Tmanydetail::reformatDate($row->doc_dt) ?></td>
			<td><?php echo $row->folder_cd ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->amt) ?></td>
			<td><?php echo $row->remarks ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
<?php } ?>

<br/>

<h4>Data Repo (Updated)</h4> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'trepo',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetail,'repo_type',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		<?php echo $form->textFieldRow($modelParentDetail,'repo_type',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span7">
		<?php echo $form->label($modelParentDetail,'secu_type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'secu_type',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>Parameter::getParamDesc('SECUTY', $modelParentDetail->secu_type))) ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetail,'client_cd',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'client_cd',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span7">
		<?php echo $form->label($modelParentDetail,'client_type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'client_type',array('readonly'=>'readonly','class'=>'span5','label'=>false,'value'=>AConstant::$client_type[$modelParentDetail->client_type])); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetail,'repo_ref',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'repo_ref',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetail,'Tanggal',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'repo_date',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>$modelParentDetail->repo_date)) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetail,'extent_num',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'extent_num',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetail,'Tanggal',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'extent_dt',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>$modelParentDetail->extent_dt)) ?>
	</div>
	<div class="span4" style="width:200px">
		<div class="span5" style="margin-left:-30px">
			<?php echo $form->label($modelParentDetail,'Jatuh Tempo',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		</div>
		<?php echo $form->textFieldRow($modelParentDetail,'due_date',array('readonly'=>'readonly','label'=>false,'class'=>'span8','value'=>$modelParentDetail->due_date)) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetail,'Nilai Perjanjian',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'repo_val',array('readonly'=>'readonly','label'=>false,'class'=>'span8 tnumber','style'=>'text-align:right','value'=>Tmanydetail::reformatNumber($modelParentDetail->repo_val))) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetail,'Bunga %',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'fee_per',array('readonly'=>'readonly','label'=>false,'class'=>'span5 tnumber','style'=>'text-align:right')) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($modelParentDetail,'return_val',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelParentDetail,'return_val',array('readonly'=>'readonly','class'=>'span8 tnumber','style'=>'text-align:right','label'=>false,'value'=>Tmanydetail::reformatNumber($modelParentDetail->return_val))); ?>
	</div>
	<div class="span4">
		<?php echo $form->label($modelParentDetail,'Penghentian Pengakuan',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		<?php echo $form->textField($modelParentDetail,'penghentian_pengakuan',array('class'=>'span2','readonly'=>'readonly','style'=>'width:50px')) ?>
	</div>
	<div class="span4" style="width:200px">
		<div class="span5" style="margin-left:-30px">
			<?php echo $form->label($modelParentDetail,'Serah Saham',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		</div>
		<?php echo $form->textField($modelParentDetail,'serah_saham',array('class'=>'span2','readonly'=>'readonly','style'=>'width:50px')) ?>
	</div>
</div>

<?php $this->endWidget(); ?>

<br/>

<?php if($modelChildDetail){ ?>
<table id='tableHist' class='table table-bordered table-condensed'  style='display:<?php if($voucher){ ?>none<?php }else{ ?>table<?php } ?>'>
	<thead>
		<tr>
			<th width="100px">Repo Date</th>
			<th width="100px">Due Date</th>
			<th width="150px">Nomor Perjanjian</th>
			<th width="100px">Nilai</th>
			<th width="100px">Return Value</th>
			<th width="80px">Interest Rate %</th>
			<th width="70px">Tax</th>
			<th width="50px">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
	if(!$voucher)
		foreach($modelChildDetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php if($listTmanyChildDetail[$x-1][0]->upd_status == 'U')echo $row->repo_date; else echo Tmanydetail::reformatDate($row->repo_date) ?></td>
			<td><?php if($listTmanyChildDetail[$x-1][0]->upd_status == 'U')echo $row->due_date; else echo Tmanydetail::reformatDate($row->due_date) ?></td>
			<td><?php echo $row->repo_ref ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->repo_val) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->return_val) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->interest_rate) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->interest_tax) ?></td>
			<td><?php echo AConstant::$inbox_stat[$listTmanyChildDetail[$x-1][0]->upd_status] ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<table id='tableVch' class='table table-bordered table-condensed' style='display:<?php if($voucher){ ?>table<?php }else{ ?>none<?php } ?>'>
	<thead>
		<tr>
			<th width="25%">Journal Ref</th>
			<th width="13%">Voucher Type</th>
			<th width="10%">Date</th>
			<th width="8%">Vch Ref</th>
			<th width="12%">Amount</th>
			<th width="24%"></th>
			<th width="8%">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
	if($voucher)
		foreach($modelChildDetail as $row){ 
	?>
		<tr id="rowVch<?php echo $x ?>">
			<td><?php echo $row->doc_num.' - '.$row->doc_ref_num ?></td>
			<td>
				<?php 
					switch($row->payrec_type)
					{
						case 'RD':
							$row->payrec_type = 'Receipt';
							break;
						case 'PD':
							$row->payrec_type = 'Payment';
							break;
						case 'RV':
							$row->payrec_type = 'Receipt to Settle';
							break;
						case 'PV':
							$row->payrec_type = 'Payment to Settle';
							break;
						default:
							$row->payrec_type = 'PB';
							break;
					}
				?>
				<?php echo $row->payrec_type ?>
			</td>
			<td><?php if($listTmanyChildDetail[$x-1][0]->upd_status == 'U')echo $row->doc_dt; else echo Tmanydetail::reformatDate($row->doc_dt) ?></td>
			<td><?php echo $row->folder_cd ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->amt) ?></td>
			<td><?php echo $row->remarks ?></td>
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
				array('name'=>$model->status!='U'?'cancel_reason':'edit_reason','type'=>'raw','value'=>nl2br($model->cancel_reason)),
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
			'url'=>$this->createUrl('AjxPopReject',array('id'=>$model->primaryKey)),
			'htmlOptions'=>array('class'=>'reject-inbox'),
			'label'=>'Reject',
		)); ?>
	</div>
	<?php 
		$param  = array(array('class'=>'reject-inbox','title'=>'Reject Reason','url'=>'AjxPopReject','urlparam'=>array('id'=>$model->primaryKey,'label'=>false)));
	  	AHelper::popupwindow($this, 600, 500, $param);
	?>
<?php endif; ?>

