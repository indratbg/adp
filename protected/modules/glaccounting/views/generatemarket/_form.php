
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
		foreach($model as $row)
			echo $form->errorSummary(array($row)); 
	?>

<input type="hidden" id="rowCount" name="rowCount"/>
<input type="hidden" id="scenario" name="scenario"/>
<div class="control-group">
	<div class="row-fluid">
		<div class="span3">
<?php echo $form->datePickerRow($modelfilter,'end_date',array('class'=>'span2 tdate','placeholder'=>'dd/mm/yyyy','required'=>'required','style'=>'margin-left:-30px;width:100px;'));?>			
		</div>
		<div class="span3" >
<?php echo $form->datePickerRow($modelfilter,'jur_date',array('class'=>'span2 tdate','placeholder'=>'dd/mm/yyyy','required'=>'required','style'=>'margin-left:-40px;width:100px;')); ;?>			
		</div>
		<div class="span1">
			<label>File No.</label>
		</div>
		<div class="span3" >
			
<?php echo $form->textField($modelfilter,'folder_cd',array('value'=>$modelfilter->folder_cd,'class'=>'span2','id'=>'folder_cd','required'=>'required','style'=>'margin-left:10px;width:100px;')); ?>			
		</div>
			<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnFilter','style'=>'margin-left:-90px;'),
			'label'=>'Retrieve',
		)); ?>
	</div>
	</div>

	
</div>

	
<br/>
<div class="row-fluid">
	<div class="span2">
		<label>Total Client :</label>
	</div>
	<div class="span1" style="margin-left:-50px;">
		<label id="jumlah"></label>
	</div>
	<div class="span2">
		<label>Total Fee :</label>
		
	</div>
	<div class="span1" style="margin-left: -60px;">
		<label id="fee"></label>
		<input type="hidden" name="Vgeneratemarket[total_fee]" value="" id="fee2"/>
	</div>
</div>



<table id='tableGen' class='table-bordered table-condensed' style="width: 790px;" >
	<thead>
		<tr>
			<th width="80px">Client Cd</th>
			<th width="300px">Client Name</th>
			<th width="80px">Branch Code</th>
			<th width="150px">Info Fee</th>
			<th>Tidak dijurnal</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
		
	?>
		<tr id="row<?php echo $x ?>">
			<td width="80px">
			
			<?php echo $row->client_cd;?>
			<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][client_cd]" value="<?php echo $row->client_cd;?>"/>
			<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][olt_user_id]" value="<?php echo $row->olt_user_id;?>"/>
			<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][client_type]" value="<?php echo $row->client_type;?>"/>
			<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][user_stat]" value="<?php echo $row->user_stat;?>"/>
			<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][fee_flg]" value="<?php echo $row->fee_flg;?>"/>
			<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][accessflag]" value="<?php echo $row->accessflag;?>"/>
			</td>
			<td width="300px">
			<?php echo $row->client_name ;?>
			<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][client_name]" value="<?php echo $row->client_name;?>"/>
			</td>
			<td width="80px" class="text-center">
				<?php echo $row->branch_code ;?>
				<input type="hidden" name="Vgeneratemarket[<?php echo $x ?>][branch_code]" value="<?php echo $row->branch_code;?>"/>
			</td>
			<td width="150px" class="info_fee">
			
				<?php echo $form->textField($row,'info_fee',array('name'=>'Vgeneratemarket['.$x.'][info_fee]' ,'id'=>'info_fee_'.$x.'','value'=>number_format((float)$row->info_fee,0,'.',','),'class'=>'span','style'=>'text-align:right;','readonly'=>true));?>
				<input type="hidden" id="info_fee_hidden_<?php echo $x;?>" value = "<?php echo $row->info_fee ;?>" />
			</td>
			<td>
				<?php echo $form->checkBox($row,'save_flg',array('id'=>'save_flg_'.$x.'','value' => 'Y','name'=>'Vgeneratemarket['.$x.'][save_flg]','onchange'=>'info_fee('.$x.')','style'=>'margin-left:10px;')); ?>
				
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
$('.tdate').datepicker({format : "dd/mm/yyyy"});
var rowCount=<?php echo count($model) ?>;
var fee=0;
//$('#Vgeneratemarket_end_date').datepicker({format : "dd/mm/yyyy"});
//$('#Vgeneratemarket_jur_date').datepicker({format : "dd/mm/yyyy"});
setTimeout(function(){
		$('.tdate').datepicker('update');
	},
	100
	)
	
	$('#folder_cd').change(function(){	
	var folder_cd = $('#folder_cd').val();
		$('#folder_cd').val(folder_cd.toUpperCase());
	});

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
			var info_fee =  parseInt(setting.func.number.removeCommas($(this).children('td.info_fee').children('[type=text]').val()));
			
			fee +=info_fee;
		});

fee=setting.func.number.addCommas(fee);
$('#fee').html(fee);
$('#fee2').val(setting.func.number.removeCommas(fee));
$('#jumlah').html('<?php echo $x-1;?>');

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





</script>