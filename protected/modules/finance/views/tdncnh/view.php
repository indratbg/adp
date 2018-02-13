<?php
$this->breadcrumbs=array(
	'Interest Journal Entrys'=>array('index'),
	$model->folder_cd,
);

$this->menu=array(
	array('label'=>'View Interest Journal '.$model->folder_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->dncn_num),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->dncn_num),'icon'=>'eye-open','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);


?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Interest Journal Entry',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
		
	<div class="row-fluid control-group">
	
		<div class="span4">
			<?php echo $form->datePickerRow($model,'dncn_date',array('class'=>'span4','readonly'=>true,'disabled'=>true,'style'=>'margin-left:-80px;'));?>	
		</div>
		<div class="span6" style="margin-left:-40px;">
			<?php echo $form->dropDownListRow($model,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),
				array('class'=>'span2','name'=>'Tdncnh[db_cr_flg]','readonly'=>'true','disabled'=>true,'style'=>'margin-left:-30px;')); 
			?>
		</div>
		<div class="span2" style="margin-left:-170px;">
			<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span9','readonly'=>true,'style'=>'margin-left:-90px;'));?>
			
		</div>
	</div>
	<div class="row-fluid control-group">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'sl_acct_cd',array('class'=>'span5','readonly'=>true,'style'=>'margin-left:-80px;'));?>
		</div>
		<div class="span6" style="margin-left:-200px;" >
			<?php echo $form->textFieldRow($model,'dncn_num',array('class'=>'span5','readonly'=>true,'style'=>'margin-left:-30px;'));?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'ledger_nar',array('class'=>'span11','readonly'=>true,'style'=>'margin-left:-80px;'));?>
<?php $this->endWidget(); ?>

<br/><br/>

<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">GL Account</th>
			<th width="80px">SL Account</th>
			<th width="100px">Amount</th>
			<th width="50px">Db/Cr</th>
			<th width="300px">Ledger Description</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modeldetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd ?></td>
			<td style="text-align: right;"><?php echo number_format((float)$row->curr_val,2,',','.') ?></td>
			<td><?php echo Constanta::$gljournal[$row->db_cr_flg] ?></td>
			<td><?php echo $row->ledger_nar ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'date'),
		'user_id',
		array('name'=>'upd_dt','type'=>'datetime'),
		'upd_by',
	),
)); ?>
