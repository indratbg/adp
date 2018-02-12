<style>
	#tableLedger
	{
		background-color:#C3D9FF;
	}
	#tableLedger thead, #tableLedger tbody
	{
		display:block;
	}
	#tableLedger tbody
	{
		max-height:200px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>	

<?php
$this->breadcrumbs=array(
	'GL Journal Entry'=>array('index'),
	$model->jvch_num=>array('view','id'=>$model->jvch_num),
	'Update',
);
/*
$this->menu=array(
	array('label'=>'GL Journal Entry', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->jvch_num),'icon'=>'eye-open'),
);
*/


$this->menu=array(
	array('label'=>'Update GL Journal '.$model->folder_cd.' (Remarks)', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->jvch_num),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->jvch_num),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>




<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php
	$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a, acct_name","condition"=>"sl_a = '000000' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
?>
<?php
	//$gl_a = Glaccount::model()->findAll(array("select"=>"DISTINCT(TRIM(gl_a)) gl_a","condition"=>"prt_type <> 'S' AND acct_stat = 'A' AND approved_stat = 'A'","order"=>"gl_a"));
	$sql="select dflg1 from mst_sys_param where param_id='SYSTEM' and param_cd1='VCH_REF'";
	$dflg1=DAO::queryRowSql($sql);
	$folder_cd=$dflg1['dflg1'];
	
?>
	<br/>

	<?php echo $form->errorSummary($model); ?>
	
		<?php 
		foreach($modelDetail as $row)
			echo $form->errorSummary(array($row)); 
	?>
		
	<div class="row-fluid control-group">
	
		<div class="span4">
			<?php echo $form->datePickerRow($model,'jvch_date',array('class'=>'span4','placeholder'=>'dd/mm/yyyy','required'=>'required','style'=>'margin-left:-80px;','readonly'=>true));?>
		
		</div>
		<div class="span2" style="margin-left:-140px;">
				<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span9','readonly'=>true,'style'=>'margin-left:-90px;'));?>
		<?php echo $form->textField($model,'curr_amt',array('style'=>'display:none;'));?>
			<?php //echo $form->textFieldRow($model,'jvch_num',array('class'=>'span5','readonly'=>true));?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'jvch_num',array('class'=>'span5','readonly'=>true,'style'=>'margin-left:-30px;'));?>
		</div>
	</div>
	<div class="row-fluid control-group">
		<div class="span">
			<?php echo $form->textFieldRow($model,'remarks',array('class'=>'span8','required'=>'required','style'=>'margin-left:-80px;width:545px;'));?>	
		</div>
	</div>


<br/>

<input type="hidden" id="rowCount" name="rowCount"/>
	<legend style="font-size: 2em;">Ledger Detail</legend>
	<table id='tableLedger' class='table-bordered table-condensed' >
		<thead>
			<tr>
			<th id="header1"></th>
			<th id="header2">GL Account</th>
			<th id="header3">SL Account</th>
			<th id="header4">Amout</th>
			<th id="header5">Db/Cr</th>
			<th id="header6">Ledger Description</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
				<td>
					<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Taccountledger['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
					<input type="hidden" name="Taccountledger[<?php echo $x ?>][rowid]" value="<?php echo $row->rowid ?>"/>	
			
				</td>
				
				<td width="100px" class="glAcct">
					<?php echo $form->dropDownList($row,'gl_acct_cd',CHtml::listData($gl_a, 'gl_a', 'glDescrip'),array('disabled'=>true,'class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','onChange'=>'filterSlAcct(this)','readonly'=>$row->save_flg !='Y'?'readonly':'','prompt'=>'-Choose-','id'=>"gl_acct_cd_$x")) ;?>
					
				<td width="100px" class="slAcct">
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][sl_acct_cd]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="150px" class="amt">
					<?php echo $form->textField($row,'curr_val',array('class'=>'span tnumberdec amt','name'=>'Taccountledger['.$x.'][curr_val]','style'=>'text-align:right','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="80px" class="dbcr">
					
					<?php echo $form->dropDownList($row,'db_cr_flg',array('D'=>'DEBIT','C'=>'CREDIT'),array('disabled'=>true,'class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td width="420px" class="remarks">
					<?php echo $form->textField($row,'ledger_nar',array('class'=>'span','name'=>'Taccountledger['.$x.'][ledger_nar]','onchange'=>'ledger_nar('.$x.')','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>



	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnSubmit'),
			'label'=>'Update',
		)); ?>
	</div>



<?php $this->endWidget(); ?>



<script>

var rowCount = <?php echo count($modelDetail) ?>;
	init();
	function init()
	{
		$("#Tjvchh_jvch_date").attr('disabled',true);
		//	$("#Tjvchh_jvch_date").datepicker({format : "dd/mm/yyyy"});		
	}

	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	
	
	function adjustWidth(){
		
		$("#header1").width($("#tableLedger tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableLedger tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableLedger tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableLedger tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableLedger tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableLedger tbody tr:eq(0) td:eq(5)").width());
	}
	
	
	$("#btnSubmit").click(function()
	{
		assignRowCount();
	});
	
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		if(!$(obj).is(':checked') && $("#tableLedger tbody tr:eq("+x+") td:eq(4) [type=hidden]").val())resetValue(obj,x); // Reset Value when the checkbox is unchecked and the row contains an existing record
		
		$("#tableLedger tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		//$("#tableLedger tbody tr:eq("+x+") td:eq(1) select").attr("readonly",!$(obj).is(':checked')?true:false);
		//$("#tableLedger tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		//$("#tableLedger tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		//$("#tableLedger tbody tr:eq("+x+") td:eq(4) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableLedger tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(9) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	
		function assignRowCount()
	{
		$("#rowCount").val(rowCount);
	}
	
	function ledger_nar(num){
		//	alert(num);
			var ledger_nar=$('#Taccountledger_'+num+'_ledger_nar').val();
			$('#Taccountledger_'+num+'_ledger_nar').val(ledger_nar.toUpperCase());
		}
		
$('#Tjvchh_remarks').change(function(){
	$('#Tjvchh_remarks').val($('#Tjvchh_remarks').val().toUpperCase());
})

</script>
