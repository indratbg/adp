<style>
		#tableRPVDVP
	{
		background-color:#C3D9FF;
	}
	#tableRPVDVP thead, #tableRPVDVP tbody
	{
		display:block;
	}
	#tableRPVDVP tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>
<?php
$this->menu=array(
	array('label'=>'RVP DVP Instruction Letter', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'rpvdvp-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model);
	foreach($modelDetail as $row)echo $form->errorSummary(array($row));
	foreach($modelPrint as $row)echo $form->errorSummary(array($row));
?>

<br/>
<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="rowCount" id="rowCount" />

<div class="row-fluid">
	<div class="span5">
		<div class="control-group">
			<div class="span4">
				<label>Transaction</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'trx_date',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span2">
				<label>Value</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'value_date',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span7">
				<label>Broker Phone extension no.</label>
			</div>
			<div class="span5">
					<?php echo $form->textField($model,'broker_phone_ext',array('class'=>'span12'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span7">
				<label>Broker Contact Persons</label>
			</div>
			<div class="span5">
					<?php echo $form->textField($model,'contact_person',array('class'=>'span12'));?>
			</div>
		</div>
		
	</div>
	
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Sign by 1</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'sign_by_1',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1='SIGNBY' and prm_cd_2='EF'")), 'prm_cd_2', 'prm_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
			</div>
			<div class="span2">
				<label>Sign by 2</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'sign_by_2',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1='SIGNBY' and prm_cd_2='AK'")), 'prm_cd_2', 'prm_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Suffix nomor surat</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'suffix_no_surat',array('class'=>'span11'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>ID</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'specified_id',array('class'=>'span11'));?>
			</div>
			<div class="span2">
				<?php echo $form->checkBox($model,'all_id',array('value'=>'ALL'))."&nbsp;All";?>
			</div>
			<div class="span4">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
									'id'=>'btnFilter',
									'buttonType'=>'submit',
									'type'=>'primary',
									'label'=>'Retrieve',
								)); ?>
			&nbsp;
				<?php $this->widget('bootstrap.widgets.TbButton', array(
									'id'=>'btnPrint',
									'buttonType'=>'submit',
									'type'=>'primary',
									'label'=>'Print',
								)); ?>
			</div>
		</div>
		
	</div>
</div>
<br/>

<table id="tableRPVDVP" class="table-condensed">
	<thead>
		<th width="80px">Trx Date</th>
		<th width="80px">Value Dt</th>
		<th width="50px">Trx Id</th>
		<th width="160px">Ref</th>
		<th width="100px">Buy/Sell</th>
		<th width="100px">Bond Cd</th>
		<th width="140px">Nominal</th>
		<th width="100px">Price (%)</th>
		<th width="30px">Print</th>
		<th width="150px">Nomor Surat</th>
	</thead>
	<tbody>
		<?php $x = 1; 
		foreach($modelDetail as $row){ ?>
		<tr>
			<td>
				<?php echo $form->textField($row,'trx_date',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_date]','placeholder'=>'dd/mm/yyyy','readonly'=>true));?>
				<?php echo $form->textField($row,'trx_seq_no',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_seq_no]','style'=>'display:none'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'value_dt',array('class'=>'span','name'=>'Tbondtrx['.$x.'][value_dt]','placeholder'=>'dd/mm/yyyy','readonly'=>true));?>
			</td>
			<td>
				<?php echo $form->textField($row,'trx_id',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_id]','readonly'=>true));?>
			</td>
			<td>
				<?php echo $form->textField($row,'trx_ref',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_ref]','readonly'=>true));?>
			</td>
			<td>
				<?php echo $form->textField($row,'trx_type',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_type]','readonly'=>true));?>
			</td>
			<td>
				<?php echo $form->textField($row,'bond_cd',array('class'=>'span','name'=>'Tbondtrx['.$x.'][bond_cd]','readonly'=>true));?>
			</td>
			<td>
				<?php echo $form->textField($row,'nominal',array('class'=>'span tnumber','name'=>'Tbondtrx['.$x.'][nominal]','readonly'=>true,'style'=>"text-align: right"));?>
			</td>
			<td>
				<?php echo $form->textField($row,'price',array('class'=>'span','name'=>'Tbondtrx['.$x.'][price]','readonly'=>true,'style'=>"text-align: right"));?>
			</td>
			<td>
				<?php echo $form->checkBox($row,'save_flg',array('value'=>'Y','class'=>'span','name'=>'Tbondtrx['.$x.'][save_flg]'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'nomor_surat',array('maxlength'=>'7','class'=>'span','name'=>'Tbondtrx['.$x.'][nomor_surat]','readonly'=>false));?>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right">
				Counterpart
			</td>
			<td colspan="3">
				<?php echo $form->textField($row,'lawan_name',array('class'=>'span','name'=>'Tbondtrx['.$x.'][lawan_name]','readonly'=>true));?>
			</td>
		</tr>
		<?php 
		$x++;
		}  ?>
	</tbody>
</table>


<!-- <iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe> -->

<?php echo $form->datePickerRow($model,'dummydate',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>

<script>
	var rowCount = '<?php echo count($modelDetail);?>';
	var url = '<?php echo $url;?>';
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		cekTrx_ID();
		if(url)
		{
			window.open(url);
		}
		if(rowCount==0)
		{
			$('#tableRPVDVP').hide();
		}
		else
		{
			$('#tableRPVDVP').show();
		}
	}
	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
	})
	$('#btnPrint').click(function(){
		$('#scenario').val('print');
		$('#rowCount').val(rowCount);
	})
	
	$('#Rptrvpdvpinstructionletter_all_id').change(function(){
		cekTrx_ID();
	});
	function cekTrx_ID()
	{
		if($('#Rptrvpdvpinstructionletter_all_id').is(':checked'))
		{
			$('#Rptrvpdvpinstructionletter_specified_id').val('');
			$('#Rptrvpdvpinstructionletter_specified_id').prop('disabled',true);	
		}
		else
		{
			$('#Rptrvpdvpinstructionletter_specified_id').prop('disabled',false);
		}
	}
	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	function adjustWidth(){
		var header = $("#tableRPVDVP").find('thead');
		var firstRow = $("#tableRPVDVP").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');;
		firstRow.find('td:eq(9)').css('width',(header.find('th:eq(9)').width())-17 + 'px');
	}
	
</script>
