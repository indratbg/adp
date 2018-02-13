<?php
$this->breadcrumbs=array(
	'Bankmasters'=>array('index'),
	$model->bank_cd,
);

$this->menu=array(
	array('label'=>'View Operational Bank '.$model->bank_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->bank_cd),'itemOptions'=>array('style'=>'float:right;display:inline')),
	array('label'=>'View','icon'=>'eye-open','url'=>array('view','id'=>$model->bank_cd),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bankMaster',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php echo $form->label($model,'bank_cd',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
<?php echo $form->textFieldRow($model,'bank_cd',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($model,'bank_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($model,'bank_name',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($model,'short_bank_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($model,'short_bank_name',array('readonly'=>'readonly','label'=>false)) ?>
<?php echo $form->label($model,'rtgs_cd',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php echo $form->textFieldRow($model,'rtgs_cd',array('readonly'=>'readonly','label'=>false)) ?>

<?php $this->endWidget(); ?>

<br/><br/>

<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="3%">Bank Code</th>
			<th width="8%">Main Acct</th>
			<th width="10%">Sub Acct Code</th>
			<th width="15%">Bank Acct Code</th>
			<th width="3%">Account Type</th>
			<th width="3%">Branch Code</th>
			<th width="3%">Vch Prefix</th>
			<th width="3%">Currency</th>
			<th width="8%">Close Date</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelAcct as $row){ 
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
			<td><?php echo $row->closed_date?DateTime::createFromFormat('Y-m-d H:i:s',$row->closed_date)->format('d M Y'):'' ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'cre_dt',
		'user_id',
		'upd_dt',
		'upd_by',
	),
)); ?>
