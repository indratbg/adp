<style>
	#tableDeposit
	{
		background-color:#C3D9FF;
	}
	#tableDeposit thead, #tableDeposit tbody
	{
		display:block;
	}
	#tableDeposit tbody
	{
		max-height:250px;
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


<?php 
	foreach($model as $row){
		echo $form->errorSummary(array($row));
	}
?>

	
<input type="hidden" id="rowCount" name="rowCount"/>

	<table id='tableDeposit' class='table-bordered table-condensed' >
		<thead>
			<tr>
			<th width="10 px"></th>
			<th width="110 px"></th>
			<th width="100 px">Client Cd</th>
			<th width="100 px">Journal Ref</th>
			<th width="100 px">Mutasi</th>
			<th width="150 px">Tambah</th>
			<th width="150 px">Kurang</th>
			<th width="150 px">No Perjanjian</th>
			<th width="120 px">Type</th>
			<th width="50 px">
					<a style="cursor:pointer;" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($model as $row){ 
		?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
				<td class="saveFlg">
					<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tclientdeposit['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
				<?php if($row->old_client_cd): ?>
					<input type="hidden" name="Tclientdeposit[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php  endif; ?>
				</td>
				
				<td>
				<?php echo $form->textField($row,'trx_date',array('name'=>'Tclientdeposit['.$x.'][trx_date]','class'=>'span tdate','readonly'=>$row->save_flg !='Y'?'readonly':'')) ;?>
				<?php echo $form->textField($row,'old_client_cd',array('name'=>'Tclientdeposit['.$x.'][old_client_cd]','style'=>'display:none;')) ;?>
				<?php echo $form->textField($row,'old_trx_date',array('name'=>'Tclientdeposit['.$x.'][old_trx_date]','style'=>'display:none;')) ;?>
				<?php echo $form->textField($row,'old_doc_num',array('name'=>'Tclientdeposit['.$x.'][old_doc_num]','style'=>'display:none;')) ;?>
				<?php echo $form->textField($row,'doc_num',array('name'=>'Tclientdeposit['.$x.'][doc_num]','style'=>'display:none;')) ;?>
					<?php echo $form->textField($row,'tal_id',array('name'=>'Tclientdeposit['.$x.'][tal_id]','style'=>'display:none;')) ;?>
				
				</td>
				<td>
					<?php echo $form->textField($row,'client_cd',array('onchange'=>"upper_client($x)",'required'=>true,'id'=>"client_cd_$x",'class'=>'span','name'=>'Tclientdeposit['.$x.'][client_cd]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td>
					<?php $folder_cd = new Tclientdeposit;
						$folder_cd->folder_cd = $row->folder_cd;
						$folder_cd->text = 	$row->folder_cd;
						?>
					<?php //echo $form->textField($row,'folder_cd',array('class'=>'span','name'=>'Tclientdeposit['.$x.'][folder_cd]','readonly'=>false)); ?>
					<?php echo $form->dropDownList($row,'folder_cd',CHtml::listData(array_merge(array($folder_cd),$dropdown_folder_cd), 'folder_cd', 'text'),array('onchange'=>"amount($x)",'id'=>"folder_cd_$x",'class'=>'span','name'=>'Tclientdeposit['.$x.'][folder_cd]','readonly'=>$row->save_flg !='Y'?'readonly':'','prompt'=>'-Choose-'));?>
				</td>
				<td>
					<?php //echo $form->textField($row,'mvmt_type',array('class'=>'span','name'=>'Tclientdeposit['.$x.'][mvmt_type]','readonly'=>true)); ?>
					<?php echo $form->dropDownList($row,'mvmt_type',array('+'=>'Tambahkan','-'=>'Kurangi'),array('id'=>"mvmt_type_$x",'class'=>'span','name'=>'Tclientdeposit['.$x.'][mvmt_type]','readonly'=>$row->save_flg !='Y'?'readonly':'','prompt'=>'-Choose-'));?>
				</td>
				<td>
					<?php echo $form->textField($row,'credit',array('style'=>'text-align:right','id'=>"credit_$x",'class'=>'span tnumberdec','name'=>'Tclientdeposit['.$x.'][credit]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'debit',array('style'=>'text-align:right','id'=>"debit_$x",'class'=>'span tnumberdec','name'=>'Tclientdeposit['.$x.'][debit]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'no_perjanjian',array('id'=>"no_perjanjian_$x",'onchange'=>"upper_perjanjian($x)",'class'=>'span','name'=>'Tclientdeposit['.$x.'][no_perjanjian]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				</td>
				<td>
					<?php //echo $form->textField($row,'doc_type',array('id'=>"doc_type_$x",'onchange'=>"upper_doc_type($x)",'class'=>'span','name'=>'Tclientdeposit['.$x.'][doc_type]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
					<?php echo $form->dropDownList($row,'doc_type',AConstant::$doc_type_client_deposit,array('required'=>true,'class'=>'span','name'=>'Tclientdeposit['.$x.'][doc_type]','readonly'=>$row->save_flg !='Y'?'readonly':'','prompt'=>'-Choose-'));?>
				</td>
				
				<td style="cursor:pointer;">
					<a 
						title="<?php   if($row->old_client_cd) echo 'cancel';else echo 'delete'?>" 
						onclick="<?php if($row->old_client_cd) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
						<img style="width:13px;height:13px;" src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
					</a>
					</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>

<br class="temp"/>
<?php if (count($model)>0){?>
		<?php echo $form->label($model[0], 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
		<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>

<?php } ?>
	
	<br class="temp"/><br class="temp"/>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'=>array('id'=>'btnSubmit'),
			'label'=>'Save'
		)); ?>
	</div>

<?php //if(count($model)>0){
	$modeldummy = new Tclientdeposit;
	 echo $form->datePickerRow($modeldummy,'cre_dt',array('label'=>false,'style'=>'display:none;'));
	
//}
?>

<?php $this->endWidget(); ?>



<script>

var date = '<?php echo date('d/m/Y')?>';
//alert(date);

var rowCount = <?php echo count($model) ?>;
var authorizedCancel = true;
	init();
	function init(){
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCancel'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedCancel = false;
				}
			}
		});
			cancel_reason();
		
			$('.tdate').datepicker({format : "dd/mm/yyyy"});;
	}
	
	function addRow()
	{	//var nilai='0.00';
		$("#tableDeposit").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(rowCount+1))
    			.append($('<td>')
				.append($('<input>')
					.attr('name','Tclientdeposit['+(rowCount+1)+'][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
					
				)
				.append($('<input>')
				.attr('name','Tclientdeposit['+(rowCount+1)+'][doc_num]')
				.attr('type','hidden')
				.attr('id','doc_num_'+(rowCount+1))
				)
				.append($('<input>')
				.attr('name','Tclientdeposit['+(rowCount+1)+'][tal_id]')
				.attr('type','hidden')
				.attr('id','tal_id_'+(rowCount+1))
				)
				.css('width','15px')
			)
			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tdate')
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][trx_date]')
               		 	.attr('type','text')	
               		 	.datepicker({format:"dd/mm/yyyy"})
               		 	.val(date)
               		)
              )
              .append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][client_cd]')
               		 	.attr('type','text')
               		 	.attr('id','client_cd_'+(rowCount+1))
               		 	.val($('#client_cd_'+rowCount).val())	
               		 	.attr('required',true)
               		 	.attr('onchange','upper_client('+(rowCount+1)+')')	
               		)
              )
               .append($('<td>')
               	 	.attr('class','dbcr')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('id','folder_cd_'+(rowCount+1))
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][folder_cd]')
               		 	.attr('onchange','amount('+(rowCount+1)+')')
               		 	.append($('<option>')
               		 	.attr('value','')
               		 	.html('-Choose'))
               		 	<?php foreach($dropdown_folder_cd as $row) {?>
               		 	.append($('<option>')
               		 	.attr('value','<?php echo $row->folder_cd ?>')
               		 	.html('<?php echo $row->text ?>'))
               		 <?php } ?>
               		)
               		//.css('width','100px')
               	)
               .append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][mvmt_type]')
               		 	.attr('id','mvmt_type_'+(rowCount+1))
               		 	.append($('<option>')
               		 	.attr('value','')
               		 	.html('-Choose-'))
               		 	.append($('<option>')
               		 	.attr('value','+')
               		 	.html('Tambahkan'))
               		 	.append($('<option>')
               		 	.attr('value','-')
               		 	.html('Kurangi'))
               		 	
               		)
              )
        	.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumberdec')
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][credit]')
               		 	.attr('type','text')
               		 	.css('text-align','right')
               		 	//.val(nilai)
               		 	.attr('id','credit_'+(rowCount+1))
               		 	.focus(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
               		 		}
               		 	)
               		 	.blur(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.addCommasDec($(this).val()));
               		 		}
               		 	)
               		)
               		
               	)
               	.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumberdec')
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][debit]')
               		 	.attr('type','text')
               		 	.css('text-align','right')
               		 	//.val(nilai)
               		 	.attr('id','debit_'+(rowCount+1))
               		 	.focus(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
               		 		}
               		 	)
               		 	.blur(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.addCommasDec($(this).val()));
               		 		}
               		 	)
               		)
               		
               	)
               	 .append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][no_perjanjian]')
               		 	.attr('id','no_perjanjian_'+(rowCount+1))
               		 	.attr('type','text')
               		 	.attr('onchange','upper_perjanjian('+(rowCount+1)+')')	
               		)
              )
               	.append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tclientdeposit['+(rowCount+1)+'][doc_type]')
               		 	.attr('id','doc_type_'+(rowCount+1))
               		 	//.attr('type','text')
               		 	//.attr('onchange','upper_doc_type('+(rowCount+1)+')')
               		 	.append($('<option>')
               		 	.attr('value','')
               		 	.html('-Choose-'))
               		 	<?php foreach(AConstant::$doc_type_client_deposit as $key=>$value ){?>
               		 	.append($('<option>')
               		 	.attr('value','<?php echo $key ?>')
               		 	.html('<?php echo $value ?>'))
               		 	<?php } ?>
               		 	.attr('required',true)
               		)
               	)
               	
               	
               	.append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	.css('width','13px')
               		 	.css('height','13px')
               		 	)
               		)
               		.css('cursor','pointer')
               	)  	
    		);
    	$('#trx_date'+(rowCount+1)).focus();
    	rowCount++;
    	alignColumn();
    	//reassignAttribute();
	}
	
	

$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableDeposit").find('thead');
		var firstRow = $("#tableDeposit").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',(header.find('th:eq(9)').width())-17 + 'px');
		
	}
	
	
	function deleteRow(obj)
	{ 
		$(obj).closest('tr').remove();
		rowCount--;
		alignColumn();
	}

	
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		if(!$(obj).is(':checked') && $("#tableDeposit tbody tr:eq("+x+") td:eq(4) [type=hidden]").val())resetValue(obj,x); // Reset Value when the checkbox is unchecked and the row contains an existing record
		
		$("#tableDeposit tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableDeposit tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableDeposit tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableDeposit tbody tr:eq("+x+") td:eq(3) select").attr("readonly",!$(obj).is(':checked')?true:false);
		//$("#tableDeposit tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableDeposit tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableDeposit tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableDeposit tbody tr:eq("+x+") td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableDeposit tbody tr:eq("+x+") td:eq(8) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(9) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function cancel_reason()
	{
		var cancel_reason = false;
		//alert(rowCount);
		for(x=0;x<rowCount;x++)
		{
			if($("#row"+(x+1)).hasClass('markCancel'))
			{ //alert(rowCount);
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason)$(".cancel_reason, .temp").show().attr('disabled',false)
		else
			$(".cancel_reason, .temp").hide().attr('disabled',true);
	}
	function cancel(obj, cancel_flg, seq)
	{ 
		if(authorizedCancel)
		{
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Tclientdeposit['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableDeposit tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
		}
		else
			alert('You are not authorized to perform this action');	
	}

	$('#btnSubmit').click(function(){
		if(checkSave()==1){
			$('#rowCount').val(rowCount);
		}
		else{
			alert('Tidak ada data yang dipilih');
			return false;
		}
	})
	

	
	function upper_perjanjian(x){
			$('#no_perjanjian_'+x).val($('#no_perjanjian_'+x).val().toUpperCase());
	}
	function upper_client(x){
			$('#client_cd_'+x).val($('#client_cd_'+x).val().toUpperCase());
	}
	function checkSave(){
		
		var x = 0;
		$("#tableDeposit").children('tbody').children('tr').each(function()
		{
			var save = $(this).children('td').children('[type=checkbox]').is(':checked');
			//alert(save);
			if(save){
				x=1;
				return false;
			}
		
		})
		
		return x;
	}
	
	
	function amount(num){
			
			var folder_cd = $('#folder_cd_'+num).val();
		//	var client_cd = $('#client_cd_'+num).val();
				$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->CreateUrl('CheckAmount'); ?>',
				'dataType' : 'json',
				'data'     : {'folder_cd' : folder_cd
 							//  'client_cd' :client_cd	
							},
				'success'  : function(data){
					
					if(data.db_cr_flg=='C'){
					$('#mvmt_type_'+num).val('+');
					$('#credit_'+num).val(data.curr_val);
					$('#debit_'+num).val('0.00');
					}
					else{
						//alert('test')
					$('#mvmt_type_'+num).val('-');	
					$('#debit_'+num).val(data.curr_val);	
					$('#credit_'+num).val('0.00');
					}
					$('#doc_num_'+num).val(data.doc_num);
					$('#tal_id_'+num).val(data.tal_id);
					
				}
			});
			
	}
	
	
</script>
