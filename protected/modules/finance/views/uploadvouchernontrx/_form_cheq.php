<?php
		$type = Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'CHEQUE'",'order'=>'prm_desc'));
?>

<table id='tableCheq' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="10%">Type</th>
			<th width="15%">Cheque Number</th>
			<th width="15%">Amount</th>
			<th width="35%">Description</th>
			<th width="10%">Fee</th>
			<th width="10%">Date</th>
			<th width="3%">
				<a title="add" style="cursor: pointer" onclick="addRowCheq()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
	//$modelCheq[0] = new Tcheq;
		foreach($modelcheq as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td class="type">
				<?php echo $form->dropDownList($row,'bg_cq_flg',Parameter::getCombo('CHEQUE', '-Choose-'),array('class'=>'span','name'=>'Tcheq['.$x.'][bg_cq_flg]')); ?>
			</td>
			<td class="chqNum">
				<?php echo $form->textField($row,'chq_num',array('class'=>'span','name'=>'Tcheq['.$x.'][chq_num]')); ?>
			</td>
			<td class="chqAmt">
				<?php echo $form->textField($row,'chq_amt',array('class'=>'span tnumberdec','name'=>'Tcheq['.$x.'][chq_amt]')); ?>
			</td>
			<td class="descrip">
				<?php echo $form->textField($row,'descrip',array('onchange'=>'descrip()','class'=>'span','name'=>'Tcheq['.$x.'][descrip]')); ?>
			</td>
			<td class="deductFee">
				<?php echo $form->textField($row,'deduct_fee',array('class'=>'span tnumber','name'=>'Tcheq['.$x.'][deduct_fee]')); ?>
			</td>
			<td class="chqDt">
				<?php echo $form->textField($row,'chq_dt',array('class'=>'span tdate','name'=>'Tcheq['.$x.'][chq_dt]','placeholder'=>'dd/mm/yyyy')); ?>
			</td>
			<td>
				<a title="delete" style="cursor: pointer;" onclick="deleteRowCheq(this)">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<input type="hidden" id="cheqCount" name="cheqCount"/>

<script>
	var cheqCount = <?php echo count($modelcheq) ?>;
	
	descrip()
	function descrip(){
	$("#tableCheq").children('tbody').children('tr').each(function()
		{
			
				$(this).children('td.descrip').children('[type=text]').val($(this).children('td.descrip').children('[type=text]').val().toUpperCase());
			
		});
	
	}
	
	
	function addRowCheq()
	{
		var transferFee= [];
		getTransferFee(transferFee);
		
		$("#tableCheq").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(cheqCount+1))
    			.append($('<td>')
    				 .attr('class','type')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tcheq['+(cheqCount+1)+'][bg_cq_flg]')
               		 	.append($('<option>')
               		 		.val('')
               		 		.html('-Choose-')
               		 	)
               		 	<?php 
               		 		foreach($type as $row){ 
               		 	?>
               		 	.append($('<option>')
               		 		.val('<?php echo $row->prm_cd_2 ?>')
               		 		.html('<?php echo $row->prm_desc ?>')
               		 	)		
               		 	<?php 
							} 
						?>
               		)
               	).append($('<td>')
               		 .attr('class','chqNum')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcheq['+(cheqCount+1)+'][chq_num]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .attr('class','chqAmt')
               		
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tcheq['+(cheqCount+1)+'][chq_amt]')
               		 	.attr('type','text')
               		 	.css('text-align','right')
               		 	.val($("#currAmt").val())
               		 	.focus(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
               		 		}
               		 	)
               		 	.blur(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.addCommas($(this).val()));
               		 		}
               		 	)
               		)
               	).append($('<td>')
               		 .attr('class','descrip')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcheq['+(cheqCount+1)+'][descrip]')
						.attr('type','text')
						.attr('onchange','descrip()')
               		)
               	).append($('<td>')
               		 .attr('class','deductFee')
               		 
               		 .append($('<input>')
               		  
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tcheq['+(cheqCount+1)+'][deduct_fee]')
               		 	.attr('type','text')
               		 	.val(transferFee['fee'])
               		 	.css('text-align','right')
               		 	.focus(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.removeCommas($(this).val()));
               		 		}
               		 	)
               		 	.blur(
               		 		function()
               		 		{
               		 			$(this).val(setting.func.number.addCommas($(this).val()));
               		 		}
               		 	)
               		 	.blur()
               		)
               		
               	).append($('<td>')
               		 .attr('class','chqDt')
               		 .append($('<input>')
               		 	.attr('class','span tdate')
               		 	.attr('name','Tcheq['+(cheqCount+1)+'][chq_dt]')
               		 	.attr('type','text')
               		 	.attr('placeholder','dd/mm/yyyy')
               		 	.datepicker({format:'dd/mm/yyyy'})
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRowCheq(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		 	.css('cursor','pointer')
               		)
               	)  	
    		);
    	
    	cheqCount++;
    	//reassignId();
    	//$(window).trigger('resize');   
	}
	
	function deleteRowCheq(obj)
	{
		$(obj).closest('tr').remove();
		cheqCount--;
		reassignIdCheq();
		//$(window).trigger('resize');
	}
	
	function reassignIdCheq()
	{
		var x = 1;
		$("#tableCheq").children("tbody").children("tr").each(function()
		{
			$(this).children("td.type").children("select").attr("name","Tcheq["+x+"][bg_cq_flg]");
			$(this).children("td.chqNum").children("[type=text]").attr("name","Tcheq["+x+"][chq_num]");
			$(this).children("td.chqAmt").children("[type=text]").attr("name","Tcheq["+x+"][chq_amt]");
			$(this).children("td.descrip").children("[type=text]").attr("name","Tcheq["+x+"][descrip]");
			$(this).children("td.deductFee").children("[type=text]").attr("name","Tcheq["+x+"][deduct_fee]");
			$(this).children("td.chqDt").children("[type=text]").attr("name","Tcheq["+x+"][chq_dt]");
			x++;
		});
	}
	
	function getTransferFee(transferFee)
	{
		var amt = setting.func.number.removeCommas($("#currAmt").val());
		var brch_cd = $("#branchCode").val();
		var rdi_bank = $("#bankCd").val();
		var to_bank = $("#clientBankCd").val();
		var glAcctCd = $("#glAcctCd").val();
		var slAcctCd = $("#slAcctCd").val();
		var olt = $("#olt").val()=='OLT'?'Y':'N';
		var rdi = $("#rdiPayFlg").is(':checked')?'Y':'N';
		var clientCd = $("#clientCd").val();
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetTransferFee'); ?>',
			'dataType' : 'json',
			'data'     : {
							'amt':amt,
							'brch_cd':brch_cd,
							'rdi_bank':rdi_bank,
							'to_bank':to_bank,
							'glAcctCd':glAcctCd,
							'slAcctCd':slAcctCd,
							'olt':olt,
							'rdi':rdi,
							'clientCd':clientCd
					},
			'async'	   : false,
			'success'  : function(data){
				transferFee['fee'] =  data['transfer_fee'];
			}
		});
	}
</script>