<?php
$this->breadcrumbs=array(
	'Trepos'=>array('index'),
	$model->repo_num,
);

$this->menu=array(
	array('label'=>'View Repo '.$model->client_cd.' '.$model->repo_ref, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'View','icon'=>'eye-open','url'=>array('view','id'=>$model->repo_num),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->repo_num),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'trepo',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php $total=0; ?>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($model,'repo_type',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		<?php echo $form->textFieldRow($model,'repo_type',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span7">
		<?php echo $form->label($model,'secu_type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'secu_type',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>Parameter::getParamDesc('SECUTY', $model->secu_type))) ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($model,'client_cd',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'client_cd',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span7">
		<?php echo $form->label($model,'client_type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'client_type',array('readonly'=>'readonly','class'=>'span5','label'=>false,'value'=>AConstant::$client_type[$model->client_type])); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($model,'repo_ref',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'repo_ref',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($model,'Tanggal',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'repo_date',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>Tmanydetail::reformatDate($model->repo_date))) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($model,'extent_num',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'extent_num',array('readonly'=>'readonly','label'=>false,'class'=>'span8')) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($model,'Tanggal',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'extent_dt',array('readonly'=>'readonly','label'=>false,'class'=>'span5','value'=>Tmanydetail::reformatDate($model->extent_dt))) ?>
	</div>
	<div class="span4" style="width:200px">
		<div class="span5" style="margin-left:-30px">
			<?php echo $form->label($model,'Jatuh Tempo',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		</div>
		<?php echo $form->textFieldRow($model,'due_date',array('readonly'=>'readonly','label'=>false,'class'=>'span8','value'=>Tmanydetail::reformatDate($model->due_date))) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($model,'Nilai Perjanjian',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'repo_val',array('readonly'=>'readonly','label'=>false,'class'=>'span8 tnumber','style'=>'text-align:right','value'=>Tmanydetail::reformatNumber($model->repo_val))) ?>
	</div>
	<div class="span4">
		<?php echo $form->label($model,'Bunga %',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'fee_per',array('readonly'=>'readonly','label'=>false,'class'=>'span5 tnumber','style'=>'text-align:right')) ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->label($model,'return_val',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($model,'return_val',array('readonly'=>'readonly','class'=>'span8 tnumber','style'=>'text-align:right','label'=>false,'value'=>Tmanydetail::reformatNumber($model->return_val))); ?>
	</div>
	<div class="span4">
		<?php echo $form->label($model,'Penghentian Pengakuan',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		<?php echo $form->textField($model,'penghentian_pengakuan',array('class'=>'span2','readonly'=>'readonly','style'=>'width:50px')) ?>
	</div>
	<div class="span4" style="width:200px">
		<div class="span5" style="margin-left:-30px">
			<?php echo $form->label($model,'Serah Saham',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
		</div>
		<?php echo $form->textField($model,'serah_saham',array('class'=>'span2','readonly'=>'readonly','style'=>'width:50px')) ?>
	</div>
</div>


<?php $this->endWidget(); ?>

<br/><br/>

<table id='tableHist' class='table table-bordered table-condensed'>
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
		foreach($modelHist as $row){ 
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

<table id='tableVch' class='table table-bordered table-condensed' style='display:<?php if($modelVch){ ?>table<?php }else{ ?>none<?php } ?>'>
	<thead>
		<tr>
			<th width="25%">Journal Ref</th>
			<th width="13%">Voucher Type</th>
			<th width="10%">Date</th>
			<th width="7%">Vch Ref</th>
			<th width="13%">Amount</th>
			<th width="24%"></th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelVch as $row){ 
	?>
		<tr id="rowVch<?php echo $x ?>">
			<td><?php if($row->doc_num != '-')echo $row->doc_num.' - '.$row->doc_ref_num;else echo '' ?></td>
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
			<td><?php if($row->folder_cd != '-')echo $row->folder_cd;else echo '' ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::reformatNumber($row->amt) ?></td>
			<td><?php echo $row->remarks ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
	<tfoot>
			<tr>
				<td colspan="4"></td>
				<td>
					<input type="text" class="span tnumber" id="totalAmount" name="totalAmount" readonly="readonly" value="<?php foreach($modelVch as $row)$total+=$row->amt; echo Tmanydetail::reformatNumber($total) ?>" style="text-align:right"/>
				</td>
				<td></td>
			</tr>
		</tfoot>
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
