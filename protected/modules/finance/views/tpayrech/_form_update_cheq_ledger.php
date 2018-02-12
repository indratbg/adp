<?php
		$type = Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'CHEQUE'",'order'=>'prm_desc'));
		$calcFeeFlg = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'TRF_FEE' AND param_cd2 = 'CALC'")->dflg1;
?>

<table id='tableCheqLedger' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="2%"></th>
			<th width="10%">Type</th>
			<th width="15%">Cheque Number</th>
			<th width="15%">Amount</th>
			<th width="35%">Description</th>
			<th width="10%">Fee</th>
			<th width="10%">Date</th>
			<th width="3%">
				<a title="add" onclick="addRowCheqLedger()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
	//$modelCheqLedger[0] = new Tcheqledger;
		foreach($modelCheqLedger as $row){ 
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td class="edit">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tcheqledger['.$x.'][save_flg]','onChange'=>'rowControlCheq(this)')); ?>
				<?php if($row->rowid): ?>
					<input type="hidden" name="Tcheqledger[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td class="type">
				<?php echo $form->dropDownList($row,'bg_cq_flg',Parameter::getCombo('CHEQUE', '-Choose-'),array('class'=>'span','name'=>'Tcheqledger['.$x.'][bg_cq_flg]')); ?>
			</td>
			<td class="chqNum">
				<?php echo $form->textField($row,'chq_num',array('class'=>'span','name'=>'Tcheqledger['.$x.'][chq_num]')); ?>
			</td>
			<td class="chqAmt">
				<?php echo $form->textField($row,'chq_amt',array('class'=>'span tnumber','name'=>'Tcheqledger['.$x.'][chq_amt]')); ?>
			</td>
			<td class="descrip">
				<?php echo $form->textField($row,'descrip',array('class'=>'span','name'=>'Tcheqledger['.$x.'][descrip]')); ?>
			</td>
			<td class="deductFee">
				<?php echo $form->textField($row,'deduct_fee',array('class'=>'span tnumber','name'=>'Tcheqledger['.$x.'][deduct_fee]')); ?>
			</td>
			<td class="chqDt">
				<?php echo $form->textField($row,'chq_dt',array('class'=>'span tdate','name'=>'Tcheqledger['.$x.'][chq_dt]')); ?>
			</td>
			<td class="delete">
				<?php if(!$row->rowid): ?>
				<a 
					title="delete" 
					onclick="deleteRowCheqLedger(this)">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
				<?php else: ?>
				<a title="cancel" onclick="cancelCheqLedger(this,'<?php echo $row->cancel_flg ?>',<?php echo $x ?>)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png"></a>
				<?php endif; ?>	
			</td>
			<input type="hidden" name="Tcheqledger[<?php echo $x ?>][rowid]" class="rowid" value="<?php echo $row->rowid ?>" />
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<input type="hidden" id="cheqLedgerCount" name="cheqLedgerCount"/>

<br class="temp_cheq"/>
	
<?php echo $form->label($model, 'Cancel Reason', array('class'=>'control-label cancel_reason_cheq'))?>
<textarea id="cancel_reason_cheq" class="span5 cancel_reason_cheq" name="cancel_reason_cheq" maxlength="200" rows="4" disabled><?php echo $cancel_reason_cheq ?></textarea>

<br class="temp_cheq"/><br class="temp_cheq"/>

<script>
	var cheqLedgerCount = <?php echo count($modelCheqLedger) ?>;
	
	function rowControlCheq(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableCheqLedger tbody tr:eq("+x+") td.type select").attr("disabled",!$(obj).is(':checked')?true:false);
		$("#tableCheqLedger tbody tr:eq("+x+") td.chqNum [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableCheqLedger tbody tr:eq("+x+") td.chqAmt [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableCheqLedger tbody tr:eq("+x+") td.descrip [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableCheqLedger tbody tr:eq("+x+") td.deductFee [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableCheqLedger tbody tr:eq("+x+") td.chqDt [type=text]").attr("disabled",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td.delete a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function addRowCheqLedger()
	{
		$("#tableCheqLedger").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(cheqLedgerCount+1))
    			.append($('<td>')
    				.attr('class','edit')
					.append($('<input>')
						.attr('name','Tcheqledger['+(cheqLedgerCount+1)+'][save_flg]')
						.attr('type','checkbox')
						.attr('onChange','rowControlCheq(this)')
						.prop('checked',true)
						.val('Y')
					)
				)
    			.append($('<td>')
    				 .attr('class','type')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tcheqledger['+(cheqLedgerCount+1)+'][bg_cq_flg]')
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
						.val($("#rdiPayFlg").is(':checked')?'RD':'BG')
               		)
               	).append($('<td>')
               		 .attr('class','chqNum')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcheqledger['+(cheqLedgerCount+1)+'][chq_num]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .attr('class','chqAmt')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tcheqledger['+(cheqLedgerCount+1)+'][chq_amt]')
               		 	.attr('type','text')
               		 	.val(cheqLedgerCount==0?$("#tableDetailLedger").find('tbody tr.bankRow td.amt [type=text]').val():'')
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
               		 	.change(
               		 		function()
               		 		{
               		 			$(this).parent().siblings('td.deductFee').children('[type=text]').val(getTransferFeeDetailLedger($(this))).blur();
               		 		}
               		 	)
               		 	.blur()
               		)
               	).append($('<td>')
               		 .attr('class','descrip')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcheqledger['+(cheqLedgerCount+1)+'][descrip]')
						.attr('type','text')
						.val(cheqLedgerCount==0?$("#payrecFrto").val():'')
               		)
               	).append($('<td>')
               		 .attr('class','deductFee')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tcheqledger['+(cheqLedgerCount+1)+'][deduct_fee]')
               		 	.attr('type','text')
               		 	.val(getTransferFeeDetailLedger($("#tableDetailLedger").find('tbody tr.bankRow td.amt [type=text]')))
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
               		 	.attr('name','Tcheqledger['+(cheqLedgerCount+1)+'][chq_dt]')
               		 	.attr('type','text')
               		 	.val($("#payrecDate").val())
               		 	.datepicker({format:'dd/mm/yyyy'})
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRowCheqLedger(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)  	
    		);
    	
    	cheqLedgerCount++;
    	//reassignId();
    	//$(window).trigger('resize');   
	}
	
	function deleteRowCheqLedger(obj)
	{
		$(obj).closest('tr').remove();
		cheqLedgerCount--;
		reassignIdCheqLedger();
		//$(window).trigger('resize');
	}
	
	function reassignIdCheqLedger()
	{
		var x = 1;
		$("#tableCheqLedger").children("tbody").children("tr").each(function()
		{
			$(this).attr("id","row"+x);	
			$(this).children('td.edit').children('[type=checkbox]').attr("name","Tcheqledger["+x+"][save_flg]");
			$(this).children('td.edit').children('[type=hidden]:eq(0)').attr("name","Tcheqledger["+x+"][save_flg]");
			$(this).children('td.edit').children('[type=hidden]:eq(1)').attr("name","Tcheqledger["+x+"][cancel_flg]");
			$(this).children("td.type").children("select").attr("name","Tcheqledger["+x+"][bg_cq_flg]");
			$(this).children("td.chqNum").children("[type=text]").attr("name","Tcheqledger["+x+"][chq_num]");
			$(this).children("td.chqAmt").children("[type=text]").attr("name","Tcheqledger["+x+"][chq_amt]");
			$(this).children("td.descrip").children("[type=text]").attr("name","Tcheqledger["+x+"][descrip]");
			$(this).children("td.deductFee").children("[type=text]").attr("name","Tcheqledger["+x+"][deduct_fee]");
			$(this).children("td.chqDt").children("[type=text]").attr("name","Tcheqledger["+x+"][chq_dt]");
			x++;
		});
		
		for(x=0;x<cheqLedgerCount;x++)
   		{
   			if($("[name='Tcheqledger["+(x+1)+"][cancel_flg]']").val())
				$("#tableCheqLedger tbody tr:eq("+x+") td.delete a:eq(0)").attr('onClick',"cancelCheqLedger(this,'"+$("[name='Tcheqledger["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableCheqLedger tbody tr:eq("+x+") td.delete a:eq(0)").attr('onClick',"deleteRowCheqLedger(this)");
   			}
   		}
	}
	
	function getTransferFeeDetailLedger(obj)
	{
		//var amt = setting.func.number.removeCommas($("#tableDetailLedger").find('tbody tr.bankRow td.amt [type=text]').val());
		if('<?php echo $calcFeeFlg ?>' == 'Y')
		{
			var amt = setting.func.number.removeCommas($(obj).val());
			var brch_cd = $("#branchCode").val();
			var rdi_bank = $("#bankCd").val();
			var to_bank = $("#clientBankCd").val();
			var glAcctCd = $("#glAcctCd").val();
			var slAcctCd = $("#slAcctCd").val();
			var olt = $("#olt").val()=='OLT'?'Y':'N';
			var rdi = $("#rdiPayFlg").val();
			var clientCd = $("#clientCd").val();
			
			var fee = 0;
			
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
					fee =  data['transfer_fee'];
				},
				'error'    : function(data)
				{
					fee = 0;
				}
			});
			
			return fee;
		}
		else
			return 0;
	}
	
	function cancelCheqLedger(obj, cancel_flg, seq)
	{
		$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
		$('[name="Tcheqledger['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
		$(obj).attr('onClick',cancel_flg=='N'?"cancelCheqLedger(this,'Y',"+seq+")":"cancelCheqLedger(this,'N',"+seq+")");
		
		$("#tableCheqLedger tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
		
		cancel_reason_cheq_ledger();
	}
	
	function cancel_reason_cheq_ledger()
	{
		var cancel_reason = false;
		
		for(x=0;x<cheqLedgerCount;x++)
		{
			if($("#tableCheqLedger").find("#row"+(x+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason)$(".cancel_reason_cheq, .temp_cheq").show().attr('disabled',false)
		else
			$(".cancel_reason_cheq, .temp_cheq").hide().attr('disabled',true);
	}
</script>