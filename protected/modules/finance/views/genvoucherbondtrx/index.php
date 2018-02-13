

<style>
	#vvoucherbondtrx-form input[type=radio]
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
	'Genvoucherbondtrx'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate Voucher to Settle Bond Transaction', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
	
);

?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'vvoucherbondtrx-form',
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
			<?php echo $form->datePickerRow($modeldummy,'value_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8',
				'name'=>'valuedt','id'=>'valuedt','options'=>array('format' => 'dd/mm/yyyy'))); ?>
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
				'label'=> 'Generate',
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
			<td width="3%">
				<?php echo $form->checkBox($modeldummy,'save_flg',array('value' => 'Y','name'=>'dummy')); ?>
			</td>
			<td width="10%">
				<?php echo $form->textField($modeldummy,'trx_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'dummy')); ?>
			</td>
			<td width="24%">
				<?php echo $form->textField($modeldummy,'trx_id',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="13%">
				<?php echo $form->textField($modeldummy,'nominal',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="35%">
				<?php echo $form->textField($modeldummy,'lawan',array('class'=>'span','name'=>'dummy')); ?>
			</td>
			<td width="17%">
				<?php echo $form->textField($modeldummy,'trx_ref',array('class'=>'span','name'=>'dummy')); ?>
			</td>
		</tr>
	</tbody>	
</table>
<table id='tableBond' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th id="header1"><input type="checkbox" id="checkall" checked="true" /></th>
			<th id="header2">Trx Date /<br />Value Date</th>
			<th id="header3">ID - Trx Type (Vch Type) - Bond /<br /> Reference</th>
			<th id="header4">Nominal - Price /<br />Net Amount</th>
			<th id="header5">Lawan /<br />Remarks</th>
			<th id="header6">File No/Vch Ref /<br />Bank Sub Acct</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($model as $row){
	?>
		<tr id="row<?php echo $x ?>">
			<td width="3%">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','class'=>'checkedbox','name'=>'Vvoucherbondtrx['.$x.'][save_flg]','onChange'=>'isCheckedAll(this)')); ?>
				<input type="hidden" name="Vvoucherbondtrx[<?php echo $x;?>][trx_date]" value="<?php echo $row->trx_date;?>" />
				<input type="hidden" name="Vvoucherbondtrx[<?php echo $x;?>][trx_seq_no]" value="<?php echo $row->trx_seq_no;?>" />
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'trx_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Vvoucherbondtrx['.$x.'][trx_date]',
						'readonly'=>'readonly','style'=>'display:none')); ?>
				<?php echo $form->textField($row,'value_dt',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','name'=>'Vvoucherbondtrx['.$x.'][value_dt]',
						'readonly'=>'readonly','style'=>'display:none')); ?>
				<?php echo DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('d/m/Y');?><br />
				<?php echo DateTime::createFromFormat('Y-m-d',$row->value_dt)->format('d/m/Y');?>
			</td>
			<td width="24%">
				<?php echo $form->textField($row,'trx_id',array('class'=>'span','name'=>'Vvoucherbondtrx['.$x.'][trx_id]','readonly'=>'readonly','style'=>'display:none;')); ?>
				<?php echo $form->textField($row,'trx_seq_no',array('name'=>'Vvoucherbondtrx['.$x.'][trx_seq_no]','readonly'=>'readonly','style'=>'display:none;')); ?>
				<?php echo $form->textField($row,'trx_type',array('class'=>'span','name'=>'Vvoucherbondtrx['.$x.'][trx_type]','readonly'=>'readonly','style'=>'display:none;','value'=>$row->trx_type == 'B'?'B':'S')); ?>
				<?php echo $form->textField($row,'bond_cd',array('class'=>'span','name'=>'Vvoucherbondtrx['.$x.'][bond_cd]','readonly'=>'readonly','style'=>'display:none;')); ?>
				<?php echo $form->textField($row,'trx_ref',array('class'=>'span','name'=>'Vvoucherbondtrx['.$x.'][trx_ref]','readonly'=>'readonly','style'=>'display:none;')); ?>
				
				<?php echo $row->trx_id;?>&nbsp;-&nbsp;
				<?php echo $row->trx_type == 'B'?'Buy':'Sell';?> (<?php echo $row->trx_type == 'B'?'Payment':'Receive';?>)&nbsp;-&nbsp;
				<?php echo $row->bond_cd?><br />
				<?php echo $row->trx_ref?>
			</td>
			<td width="13%">
				<?php echo $form->textField($row,'nominal',array('class'=>'span tnumber','name'=>'Vvoucherbondtrx['.$x.'][nominal]','readonly'=>'readonly','style'=>'display:none;')); ?>
				<?php echo $form->textField($row,'price',array('class'=>'span tnumber','name'=>'Vvoucherbondtrx['.$x.'][price]','readonly'=>'readonly','style'=>'display:none;')); ?>
				<?php echo $form->textField($row,'net_amount',array('class'=>'span tnumber','name'=>'Vvoucherbondtrx['.$x.'][net_amount]','readonly'=>'readonly','style'=>'display:none;')); ?>
				<div style="text-align: right"><?php echo ($row->nominal / 1000000000).' M - '.($row->price/100);?></div>
				<div style="text-align: right"><?php echo number_format($row->net_amount);?></div>
			</td>
			<td width="35%">
				<?php echo $form->textField($row,'lawan',array('class'=>'span','name'=>'Vvoucherbondtrx['.$x.'][lawan]','readonly'=>'readonly','style'=>'display:none;')); ?>
				<?php echo LawanBondTrx::model()->find(array('select'=>"NVL(lawan_name,lawan) as lawan_name",'condition'=>"lawan = '$row->lawan'"))->lawan_name.' ('.$row->lawan.')';?>
				<br />
				<?php echo $form->textField($row,'remarks',array('class'=>'span','maxlength'=>'50','name'=>'Vvoucherbondtrx['.$x.'][remarks]')); ?>
			</td>
			<td width="17%">
				<?php echo $form->textField($row,'folder_cd',array('class'=>'span','name'=>'Vvoucherbondtrx['.$x.'][folder_cd]','style'=>'text-transform:uppercase')); ?>
				<?php echo $form->textField($row,'bank_sl_acct',array('class'=>'span','name'=>'Vvoucherbondtrx['.$x.'][bank_sl_acct]')); ?>
			</td>
		</tr>
	<?php $x++;}} ?>
	</tbody>
</table>

<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	$("#checkall").change(function(){
		if($(this).prop('checked')){
			$(".checkedbox").each(function(){
				$(this).attr('checked',true);
			});
		}else{
			$(".checkedbox").each(function(){
				$(this).attr('checked',false);
			});
		}
	});

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
	
	function isCheckedAllInit(){
		ischeckedall = null;
		rcnt = 0;
		$(".checkedbox").each(function(){
			if ($(this).prop('checked') == false){
				ischeckedall = 0;
			}else{
				ischeckedall++;
			}
			rcnt++;
		});
		
		if ((ischeckedall > 0) && (ischeckedall == rcnt)){
			$("#checkall").prop('checked',true);
		}else{
			$("#checkall").prop('checked',false);
		}
	}
	isCheckedAllInit();
	
	function adjustWidth(){
		$("#header1").width($("#tableDummy tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableDummy tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableDummy tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableDummy tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableDummy tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableDummy tbody tr:eq(0) td:eq(5)").width());

	}
	
	function isCheckedAll(obj){
		ischeckedall = null;
		rcnt = 0;
		if ($(obj).prop('checked') == false){
			ischeckedall = 0;
		}else{	
			$(".checkedbox").each(function(){
				if ($(this).prop('checked') == false){
					ischeckedall = 0;
				}else{
					ischeckedall++;
				}
				rcnt++;
			});
		}
		
		if ((ischeckedall > 0) && (ischeckedall == rcnt)){
			$("#checkall").prop('checked',true);
		}else{
			$("#checkall").prop('checked',false);
		}
	}
	
	/*	
	function rowControl(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		//$("#tableBondSource tbody tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBondSource tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("class","checkedbox");
		$("#tableBondSource tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("onchange","rowControlUndo(this)");
		cloneRow(obj);
		deleteRow(obj);	
	}
	
	function rowControlUndo(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		//var oldctpnumval = $("#tableBond tbody tr:eq("+x+") td:eq(0) #oldctpnum").val();
		//$("#tableBond tbody tr:eq("+x+") td:eq(9) [type=text]").val(oldctpnumval);
		//$("#tableBond tbody tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBondSource tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("class","uncheckedbox");
		$("#tableBond tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("onchange","rowControl(this)");
		cloneRowUndo(obj);
		deleteRow(obj);	
	}
	*/
   	/*
   	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableBond tbody");
   		
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Vvoucherbondtrx["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Vvoucherbondtrx["+(x+1)+"][trx_date]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Vvoucherbondtrx["+(x+1)+"][trx_seq_no]");
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Vvoucherbondtrx["+(x+1)+"][trx_date]");
			obj.find("tr:eq("+x+") td:eq(2) [type=text]").attr("name","Vvoucherbondtrx["+(x+1)+"][trx_date]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Vvoucherbondtrx["+(x+1)+"][price]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Vvoucherbondtrx["+(x+1)+"][yield]");
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("name","Vvoucherbondtrx["+(x+1)+"][bond_rate]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Vvoucherbondtrx["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Vvoucherbondtrx["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"deleteRow(this)");
   			}
   		}
   	}
   	*/
   	/*
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
	*/
	$('#tableBond').find('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	function formatDate(){
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	}
</script>

