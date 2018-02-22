

<style>
	#tbondtrx-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableBond, #tableBondSource
	{
		background-color:#C3D9FF;
	}
	#tableBond thead, #tableBond tbody, #tableBondSource thead, #tableBondSource tbody
	{
		display:block;
	}
	#tableBond tbody, #tableBondSource tbody
	{
		
		max-height:340px;
		overflow-y:scroll;
		background-color:#FFFFFF;
	}
	
	#tableBond td, #tableBondSource td
	{
		vertical-align: top;
	}
	
	#tableDummy
	{
		background-color:#C3D9FF;
		visibility:hidden;
	}
	#tableDummy thead, #tableDummy tbody
	{
		display:block;
	}
	#tableDummy tbody
	{
		
		max-height:50px;
		overflow-y:scroll;
		background-color:#FFFFFF;
	}
	
	#tableDummy td
	{
		vertical-align: top;
	}
	
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Bondticket'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Bond Transaction Ticket', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/bondticket/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
	
);

?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tbondtrx-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php echo $form->errorSummary($modeldummy);?>
<?php 
	if($model){
		foreach($model as $row)
			echo $form->errorSummary(array($row));
	} 
?>

<br/>

<div>
	<?php //echo $form->radioButtonListInlineRow($model[],'filterCriteria',array('Balance Sheet Aktiva','Balance Sheet Pasiva','Profit and Loss')) ?>
	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->datePickerRow($modeldummy,'trx_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8',
				'name'=>'trxdate','id'=>'trxdate','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span7">
			ID&emsp;&emsp;
			<?php echo $form->textField($modeldummy,'trx_id',array('disabled'=>$modeldummy->allid == null || $modeldummy->allid == 'N'?'':'disabled','class'=>'span2 tnumber','maxlength'=>5,'id'=>'trxid','name'=>'trxid')); ?>
			&emsp;
			<?php echo $form->checkBox($modeldummy,'allid',array('value' => 'Y','name'=>'allid','id'=>'allid')); ?>&nbsp;&nbsp;All
			&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
			<input type="hidden" id="scenario" name="scenario"/>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnFilter',
				'buttonType' => 'submit',
				'type'=>'primary',
				'label'=>'Retrieve'
			)); ?>
			&emsp;
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnSubmit',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Save',
			)); ?>
		</div>
	</div>
</div>
<input type="hidden" id="rowCount" name="rowCount"/>
	<?php 
		if($model){
		$x = 1;
	?>
<table id='tableDummy' class='table-bordered table-condensed'>
	<tbody>
		<tr id="row1">
			<td width="2%">
				<?php echo $form->checkBox($modeldummy,'save_flg',array('value' => 'Y','name'=>'dummy')); ?>
			</td>
			<td width="10%">
				<?php echo $form->textField($modeldummy,'trx_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'dummy')); ?>
			</td>
			<td width="10%">
				<?php echo $form->textField($modeldummy,'value_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'dummy')); ?>
			</td>
			<td width="5%">
				<?php echo $form->textField($modeldummy,'trx_id',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="6%">
				<?php echo $form->textField($modeldummy,'trx_type',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="14%">
				<?php echo $form->textField($modeldummy,'bond_cd',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="15%">
				<?php echo $form->textField($modeldummy,'nominal',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="16%">
				<?php echo $form->textField($modeldummy,'lawan',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="9%">
				<?php echo $form->textField($modeldummy,'price',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="13%">
				<?php echo $form->textField($modeldummy,'trx_id_yymm',array('class'=>'span','name'=>'dummy')); ?>
			</td>
		</tr>
	</tbody>	
</table>
<h4>Current Bond Transactions</h4>
<table id='tableBondSource' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th id="sheader1"></th>
			<th id="sheader2">Trx Date</th>
			<th id="sheader3">Value Date</th>
			<th id="sheader4">ID</th>
			<th id="sheader5">Type</th>
			<th id="sheader6">Bond</th>
			<th id="sheader7">Nominal</th>
			<th id="sheader8">Counterpart</th>
			<th id="sheader9">Price(%)</th>
			<th id="sheader10">Ticket No.</th>
		</tr>
	</thead>	
	<tbody>
	<?php
		foreach($model as $row){
			if($row->save_flg != 'Y'){
	?>
		<tr id="row<?php echo $x ?>">
			<td width="2%">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tbondtrx['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
				<input type="hidden" name="Tbondtrx[<?php echo $x;?>][trx_date]" value="<?php echo $row->trx_date;?>" />
				<input type="hidden" name="Tbondtrx[<?php echo $x;?>][trx_seq_no]" value="<?php echo $row->trx_seq_no;?>" />
				<input type="hidden" name="Tbondtrx[<?php echo $x;?>][old_trx_id_yymm]" id="oldtrxidyymm" value="<?php echo $row->old_trx_id_yymm;?>" />
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'trx_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Tbondtrx['.$x.'][trx_date]',
						'disabled'=>'disabled',)); ?>
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'value_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Tbondtrx['.$x.'][value_dt]',
						'disabled'=>'disabled',)); ?>
				<input type="hidden" name="Tbondtrx[<?php echo $x;?>][value_dt]" value="<?php echo $row->value_dt;?>" />
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'trx_id',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_id]','readonly'=>'readonly')); ?>
				<?php //echo $form->textField($row,'trx_seq_no',array('name'=>'Tbondtrx['.$x.'][trx_seq_no]','readonly'=>'readonly','style'=>'display:none;')); ?>
			</td>
			<td width="6%">
				<?php echo $form->textField($row,'trx_type',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_type]','readonly'=>'readonly','value'=>$row->trx_type == 'B'?'Buy':'Sell')); ?>
			</td>
			<td width="14%">
				<?php echo $form->textField($row,'bond_cd',array('class'=>'span','name'=>'Tbondtrx['.$x.'][bond_cd]','readonly'=>'readonly')); ?>
			</td>
			<td width="15%">
				<?php echo $form->textField($row,'nominal',array('style'=>'text-align: right','class'=>'span tnumber','name'=>'Tbondtrx['.$x.'][nominal]','readonly'=>'readonly')); ?>
			</td>
			<td width="16%">
				<?php echo $form->textField($row,'lawan',array('class'=>'span','name'=>'Tbondtrx['.$x.'][lawan]','readonly'=>'readonly')); ?>
				<?php echo LawanBondTrx::model()->find(array('select'=>'lawan_name','condition'=>"lawan = '$row->lawan'"))->lawan_name;?>
			</td>
			<td width="9%">
				<?php echo $form->textField($row,'price',array('style'=>'text-align: right','class'=>'span tnumber','name'=>'Tbondtrx['.$x.'][price]','readonly'=>'readonly')); ?>
			</td>
			<td width="13%">
				<?php echo $form->textField($row,'trx_id_yymm',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_id_yymm]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
			</td>
		</tr>
	<?php $x++;}} ?>
	</tbody>	
</table>
<h4>Input Ticket</h4>
<table id='tableBond' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th id="header1"></th>
			<th id="header2">Trx Date</th>
			<th id="header3">Value Date</th>
			<th id="header4">ID</th>
			<th id="header5">Type</th>
			<th id="header6">Bond</th>
			<th id="header7">Nominal</th>
			<th id="header8">Counterpart</th>
			<th id="header9">Price(%)</th>
			<th id="header10">Ticket No.</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($model as $row){
			if($row->save_flg == 'Y'){
	?>
		<tr id="row<?php echo $x ?>">
			<td width="2%">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tbondtrx['.$x.'][save_flg]','onChange'=>'rowControlUndo(this)')); ?>
				<input type="hidden" name="Tbondtrx[<?php echo $x;?>][trx_date]" value="<?php echo $row->trx_date;?>" />
				<input type="hidden" name="Tbondtrx[<?php echo $x;?>][trx_seq_no]" value="<?php echo $row->trx_seq_no;?>" />
				<input type="hidden" name="Tbondtrx[<?php echo $x;?>][old_trx_id_yymm]" id="oldtrxidyymm" value="<?php echo $row->old_trx_id_yymm;?>" />
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'trx_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Tbondtrx['.$x.'][trx_date]',
						'disabled'=>'disabled',)); ?>
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'value_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Tbondtrx['.$x.'][value_dt]',
						'disabled'=>'disabled',)); ?>
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'trx_id',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_id]','readonly'=>'readonly')); ?>
				<?php //echo $form->textField($row,'trx_seq_no',array('name'=>'Tbondtrx['.$x.'][trx_seq_no]','readonly'=>'readonly','style'=>'display:none;')); ?>
			</td>
			<td width="6%">
				<?php echo $form->textField($row,'trx_type',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_type]','readonly'=>'readonly','value'=>$row->trx_type == 'B'?'Buy':'Sell')); ?>
			</td>
			<td width="14%">
				<?php echo $form->textField($row,'bond_cd',array('class'=>'span','name'=>'Tbondtrx['.$x.'][bond_cd]','readonly'=>'readonly')); ?>
			</td>
			<td width="15%">
				<?php echo $form->textField($row,'nominal',array('class'=>'span tnumber','name'=>'Tbondtrx['.$x.'][nominal]','readonly'=>'readonly')); ?>
			</td>
			<td width="16%">
				<?php echo $form->textField($row,'lawan',array('class'=>'span','name'=>'Tbondtrx['.$x.'][lawan]','readonly'=>'readonly')); ?>
				<?php echo LawanBondTrx::model()->find(array('select'=>'lawan_name','condition'=>"lawan = '$row->lawan'"))->lawan_name;?>
			</td>
			<td width="9%">
				<?php echo $form->textField($row,'price',array('class'=>'span tnumber','name'=>'Tbondtrx['.$x.'][price]','readonly'=>'readonly')); ?>
			</td>
			<td width="13%">
				<?php echo $form->textField($row,'trx_id_yymm',array('class'=>'span','name'=>'Tbondtrx['.$x.'][trx_id_yymm]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
			</td>
		</tr>
	<?php $x++;}}} ?>
	</tbody>
</table>
<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	var rowCount = <?php echo count($model); ?>;
	var authorizedCancel = true;

	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	})
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	
	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	$('#allid').change(function(){
		if($(this).prop('checked')){
			$('#trxid').attr('disabled','disabled');
		}else{
			$('#trxid').attr('disabled',false);
		}
	});
	adjustWidth();
	<?php if ($model){?>
		adjustWidth();
		$("#btnSubmit").attr('disabled',false);
	<?php }else{?>
		$("#btnSubmit").attr('disabled','disabled');
	<?php }?>
	
	function adjustWidth(){
		$("#header1").width($("#tableDummy tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableDummy tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableDummy tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableDummy tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableDummy tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableDummy tbody tr:eq(0) td:eq(5)").width());
		$("#header7").width($("#tableDummy tbody tr:eq(0) td:eq(6)").width());
		$("#header8").width($("#tableDummy tbody tr:eq(0) td:eq(7)").width());
		$("#header9").width($("#tableDummy tbody tr:eq(0) td:eq(8)").width());
		$("#header10").width($("#tableDummy tbody tr:eq(0) td:eq(9)").width());
		
		$("#sheader1").width($("#tableDummy tbody tr:eq(0) td:eq(0)").width());
		$("#sheader2").width($("#tableDummy tbody tr:eq(0) td:eq(1)").width());
		$("#sheader3").width($("#tableDummy tbody tr:eq(0) td:eq(2)").width());
		$("#sheader4").width($("#tableDummy tbody tr:eq(0) td:eq(3)").width());
		$("#sheader5").width($("#tableDummy tbody tr:eq(0) td:eq(4)").width());
		$("#sheader6").width($("#tableDummy tbody tr:eq(0) td:eq(5)").width());
		$("#sheader7").width($("#tableDummy tbody tr:eq(0) td:eq(6)").width());
		$("#sheader8").width($("#tableDummy tbody tr:eq(0) td:eq(7)").width());
		$("#sheader9").width($("#tableDummy tbody tr:eq(0) td:eq(8)").width());
		$("#sheader10").width($("#tableDummy tbody tr:eq(0) td:eq(9)").width());
	}
		
	function rowControl(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		//alert(x);
		//$("#tableBond tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableBondSource tbody tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBondSource tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("onchange","rowControlUndo(this)");
		cloneRow(obj);
		deleteRow(obj);	
	}
	
	function rowControlUndo(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		//alert(x);
		//$("#tableBond tbody tr:eq("+x+")").attr("id","row"+(x+1));
		var oldtrxidyymmval = $("#tableBond tbody tr:eq("+x+") td:eq(0) #oldtrxidyymm").val();
		//alert(oldtrxidyymmval);
		$("#tableBond tbody tr:eq("+x+") td:eq(9) [type=text]").val(oldtrxidyymmval);
		$("#tableBond tbody tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		//$("#tableBond tbody tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBond tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("onchange","rowControl(this)");
		cloneRowUndo(obj);
		deleteRow(obj);	
	}
	
   	function cloneRow(obj){
   		$(obj).closest('tr').clone().prependTo('#tableBond');
   	}
   	
   	function cloneRowUndo(obj){
   		$(obj).closest('tr').clone().prependTo('#tableBondSource');
   	}
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		//rowCount--;
		//reassignId();
	}
	
	$('#tableBond').find('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	function formatDate(){
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	}
</script>

