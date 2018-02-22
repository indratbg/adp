
<style>
	#tableGen
	{
		background-color:#C3D9FF;
	}
	#tableGen thead, #tableGen tbody
	{
		display:block;
	}
	#tableGen tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
	
		
	
</style>	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>



<br/>

<?php echo $form->errorSummary($modelfilter); ?>
	
		<?php 
		foreach($modelheader as $row)
			echo $form->errorSummary(array($row)); 
	?>
		<?php 
		foreach($model as $row)
			echo $form->errorSummary(array($row)); 
	?>
		<?php 
		foreach($modelledger as $row)
			echo $form->errorSummary(array($row)); 
	?>
		<?php 
		foreach($modelrepo as $row)
			echo $form->errorSummary(array($row)); 
	?>
		<?php 
		foreach($modeltrepovch as $row)
			echo $form->errorSummary(array($row)); 
	?>
		<?php 
		foreach($modelfolder as $row)
			echo $form->errorSummary(array($row)); 
	?>

<input type="hidden" id="rowCount" name="rowCount"/>
<input type="hidden" id="scenario" name="scenario"/>
<div class="control-group">
	<div class="row-fluid">
		<div class="span3">
<?php echo $form->datePickerRow($modelfilter,'jur_date',array('onchange'=>'cekHoliday()','value'=>$modelfilter->jur_date,'class'=>'span2','placeholder'=>'dd/mm/yyyy','required'=>'required','style'=>'margin-left:-40px;width:100px;')); ;?>			
		</div>
		<div class="span2" >
			<label>Journal Type</label>
		</div>
		<div class="span4" style="margin-left: -40px;">
			<?php echo $form->radioButton($modelfilter,'jurnal_type',array('value'=>'0')).'Daily';?>&emsp;
			<?php echo $form->radioButton($modelfilter,'jurnal_type',array('value'=>'1')).'Year End';?>
		</div>
	
			<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnFilter','style'=>'margin-left:-90px;','class'=>'btn-small'),
			'label'=>'Retrieve',
		)); ?>
	</div>
	</div>

	
</div>

	
<br/>



<table id='tableGen' class='table-bordered table-condensed' >
	<thead>
		<tr>
			<th id="header1" >Repo Type</th>
			<th id="header2" >Client Cd</th>
			<th id="header3">Date</th>
			<th id="header4">Repo Value</th>
			<th id="header5">Int Rate</th>
			<th id="header6">Days</th>
			<th id="header7">Interest</th>
			<th id="header8">Tax</th>
			<th id="header9">After Tax</th>
			<th id="header10">Jurnal</th>
			<th id="header11">Folder</th>
			<th id="header12">Reference</th>
		</tr>
	</thead>
	<tbody >
	<?php $x = 1;
		foreach($model as $row){
		
	?>
		<tr id="row<?php echo $x ?>" >
			<td width="50px" style="font-size: 8pt;">
			
			<?php echo $row->repo_type;?>
			<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][repo_type]" value="<?php echo $row->repo_type;?>"/>
			<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][repo_num]" value="<?php echo $row->repo_num;?>"/>
			</td>
			<td  width="55px" style="font-size: 8pt;">
			<?php echo $row->client_cd ;?>
			<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][client_cd]" value="<?php echo $row->client_cd;?>"/>
			</td>
			<td width="90px" style="font-size: 8pt;">
				<?php echo 'From '.$row->repo_date ;?>
				<br/>
				<?php echo 'Due '.$row->due_date ;?>
				<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][repo_date]" value="<?php echo $row->repo_date;?>"/>
				<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][due_date]" value="<?php echo $row->due_date;?>"/>
			</td>
			<td  width="40px" style="font-size: 8pt;">
				<?php echo number_format((float)$row->repo_val,0,'.',',');?>
					<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][repo_val]" value="<?php echo $row->repo_val;?>"/>
			</td>
			<td width="35px"style="font-size: 8pt;">
				<?php echo $row->interest_rate ;?>
				<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][interest_rate]" value="<?php echo $row->interest_rate;?>"/>
			</td>
			<td width="30px" style="font-size: 8pt;">
				<?php echo $row->days ;?>
				<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][days]" value="<?php echo $row->days;?>"/>
			</td>
			<td  class="int_amt" width="130px"style="font-size: 8pt;">
				
				<?php echo $form->textField($row,'int_amt',array('id'=>"int_amt_$x",'style'=>'text-align:right;','class'=>'span','name'=>'Vgeneraterepointjur['.$x.'][int_amt]'));?>
				
			</td>
			<td class="int_tax_amt" width="80px" style="font-size: 8pt;">
				<?php echo $form->textField($row,'int_tax_amt',array('id'=>"int_tax_amt_$x",'style'=>'text-align:right;','class'=>'span','name'=>'Vgeneraterepointjur['.$x.'][int_tax_amt]'));?>
			</td>
			<td class="int_aft_tax" width="130px" style="font-size: 8pt;">
				<?php echo $form->textField($row,'int_aft_tax',array('id'=>"int_aft_tax_$x",'style'=>'text-align:right;','class'=>'span','name'=>'Vgeneraterepointjur['.$x.'][int_aft_tax]'));?>
			</td>
			<td width="40px" class="jur_flg" style="font-size: 8pt;">
				<?php echo $form->checkBox($row,'save_flg',array('onchange'=>'init()','checked'=>$row->sign_jur =='Y' || $row->jur_flg =='Y'?true:false,'value' => 'Y','name'=>'Vgeneraterepointjur['.$x.'][save_flg]','style'=>'margin-left:10px;')); ?>
				<input type="hidden" id="sign_jur_<?php echo $x?>" name="Vgeneraterepointjur[<?php echo $x ?>][sign_jur]" value=""/>
			</td>
			<td width="70px" style="font-size: 8pt;">
				<?php echo $form->textField($row,'folder_cd',array('id'=>"folder_cd_$x",'onchange'=>'upper('.$x.')','class'=>'span','name'=>'Vgeneraterepointjur['.$x.'][folder_cd]'));?>
			</td>
			<td  width="110px" style="font-size: 8pt;">
				<?php echo $row->repo_ref;?>
					<input type="hidden" name="Vgeneraterepointjur[<?php echo $x ?>][repo_ref]" value="<?php echo $row->repo_ref;?>"/>
			</td>
		</tr>
		
	<?php 
	$x++;
} ?>
	</tbody>
</table>
<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnProcess','style'=>'margin-left:150px;'),
			'label'=>'Process',
		)); ?>
		</div>
<?php $this->endWidget(); ?>

<script>

var rowCount=<?php echo count($model) ?>;
var fee=0;
$('#Vgeneraterepointjur_jur_date').datepicker({format : "dd/mm/yyyy"});


	if(rowCount == 0){
		$('#tableGen').hide();
		$('#btnProcess').hide();
	}
	else{
		$('#tableGen').show();
		$('#btnProcess').show();
	}
	

init();
function init(){
	
$("#tableGen").children('tbody').children('tr').each(function()
		{
			//var info_fee =  parseInt(setting.func.number.removeCommas($(this).children('td.info_fee').children('[type=text]').val()));
		
		if(!$(this).children('td.jur_flg').children('[type=checkbox]').is(':checked')){
			$(this).children('td.jur_flg').children('[type=hidden]').val('');
		}
		else{
			$(this).children('td.jur_flg').children('[type=hidden]').val('Y');
		}
		
		});

}




$('#btnFilter').click(function(){
	$('#scenario').val('filter');
	
});
$('#btnProcess').click(function(){
	$('#scenario').val('save');
	$('#rowCount').val(rowCount);
	
});

function info_fee(obj){
	var fee1 = $('#info_fee_hidden_'+obj).val();
	
	
	if($('#save_flg_'+obj).is(':checked')){
		$('#info_fee_'+obj).val('0');
		fee=0;
		init();
	}
	else{
		fee=setting.func.number.addCommas(fee1);
		$('#info_fee_'+obj).val(fee1);
			fee=0;
			init();
	}
}


	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	function adjustWidth(){
		
		$("#header1").width($("#tableGen tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableGen tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableGen tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableGen tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableGen tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableGen tbody tr:eq(0) td:eq(5)").width());
		$("#header7").width($("#tableGen tbody tr:eq(0) td:eq(6)").width());
		$("#header8").width($("#tableGen tbody tr:eq(0) td:eq(7)").width());
		$("#header9").width($("#tableGen tbody tr:eq(0) td:eq(8)").width());
		$("#header10").width($("#tableGen tbody tr:eq(0) td:eq(9)").width());
		$("#header11").width($("#tableGen tbody tr:eq(0) td:eq(10)").width());
		$("#header12").width($("#tableGen tbody tr:eq(0) td:eq(11)").width());
		
		
		
	}
	
	function cekHoliday(){
		
		var jur_date = $('#Vgeneraterepointjur_jur_date').val();
		//alert('jur_date');
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('CekHoliday'); ?>',
				'dataType' : 'json',
				'data'     : {'jur_date' : jur_date,
 
							},
				'success'  : function(data){
						var libur = data.holiday;
					
						if(libur == 1){
							$('#Vgeneraterepointjur_jur_date').val('');
							alert('Tidak boleh hari libur');
						
						}
					
				}
			});
	}
function upper(obj){
	
	var folder_cd=$('#folder_cd_'+obj).val();
	$('#folder_cd_'+obj).val(folder_cd.toUpperCase());
}

format_number();
function format_number(){
	$("#tableGen").children('tbody').children('tr').each(function()
		{
			$(this).children('td.int_amt').children('[type=text]').val(setting.func.number.addCommasDec($(this).children('td.int_amt').children('[type=text]').val()));
			$(this).children('td.int_tax_amt').children('[type=text]').val(setting.func.number.addCommasDec($(this).children('td.int_tax_amt').children('[type=text]').val()));
			 $(this).children('td.int_aft_tax').children('[type=text]').val(setting.func.number.addCommasDec($(this).children('td.int_aft_tax').children('[type=text]').val()));
			
		});
}

</script>