<style>
	#tableBank
	{
		background-color:#C3D9FF;
	}
	#tableBank thead, #tableBank tbody
	{
		display:block;
	}
	#tableBank tbody
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

<?php
	if(!Yii::app()->user->isGuest)$arrUsergroupId  = Yii::app()->user->usergroup_id;
	else {
		$arrUsergroupId = array();
	}
	
	if(in_array(AConstant::SUPERADMIN_GROUP,$arrUsergroupId))$authorized = TRUE;
	else {
		$authorized = FALSE;
	}

	$bankList = Ipbank::model()->findAll(array('select'=>"bank_cd, bank_cd||' - '||bank_name bank_name",'condition'=>"approved_stat='A' and bank_stat='A'",'order'=>'bank_cd'));
	//$branchList = Branch::model()->findAll(array('order'=>'brch_cd'));
?>

<input type='hidden' id="rowCount" name="rowCount"/>

<table id='tableBank' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="3%"></th>
			<th width="20%">Bank</th>
			<th width="15%">Account No.</th>
			<th width="10%">Branch</th>
			<th width="15%">Bank Phone Number</th>
			<th width="17%">Account Name</th>
			<th width="12%">Account Type</th>
			<th width="4%">Currency</th>
			<th width="2%">Default</th>
			<th width="2%">
				<a title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelClientBank as $row){ 
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td>
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Clientbank['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
				<?php if($row->old_bank_acct_num): ?>
					<input type="hidden" name="Clientbank[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td>
				<?php echo $form->dropDownList($row,'bank_cd',CHtml::listData($bankList,'bank_cd','bank_name'),array('class'=>'span','name'=>'Clientbank['.$x.'][bank_cd]','disabled'=>$row->save_flg!='Y'?'disabled':'','prompt'=>'-Choose-')); ?>
				<input type="hidden" name="Clientbank[<?php echo $x ?>][old_bank_cd]" value="<?php echo $row->old_bank_cd ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'bank_acct_num',array('class'=>'span','maxlength'=>20,'name'=>'Clientbank['.$x.'][bank_acct_num]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Clientbank[<?php echo $x ?>][old_bank_acct_num]" value="<?php echo $row->old_bank_acct_num ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'bank_branch',array('class'=>'span','name'=>'Clientbank['.$x.'][bank_branch]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Clientbank[<?php echo $x ?>][old_bank_branch]" value="<?php echo $row->old_bank_branch ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'bank_phone_num',array('class'=>'span','name'=>'Clientbank['.$x.'][bank_phone_num]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Clientbank[<?php echo $x ?>][old_bank_phone_num]" value="<?php echo $row->old_bank_phone_num ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'acct_name',array('class'=>'span','maxlength'=>50,'name'=>'Clientbank['.$x.'][acct_name]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Clientbank[<?php echo $x ?>][old_acct_name]" value="<?php echo $row->old_acct_name ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'bank_acct_type',array('class'=>'span','name'=>'Clientbank['.$x.'][bank_acct_type]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Clientbank[<?php echo $x ?>][old_bank_acct_type]" value="<?php echo $row->old_bank_acct_type ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'bank_acct_currency',array('class'=>'span','maxlength'=>3,'name'=>'Clientbank['.$x.'][bank_acct_currency]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Clientbank[<?php echo $x ?>][old_bank_acct_currency]" value="<?php echo $row->old_bank_acct_currency ?>" />
			</td>
			<td style="text-align:center"><input type="radio" id="default<?php echo $x ?>" name="default" value="<?php echo $x ?>" onClick="setCheckBox(this)" <?php if($row->default_flg == 'Y'){ ?>checked="checked"<?php } ?>/></td>
			<td>
				<?php if(!$row->old_bank_acct_num): ?>
				<a 
					title="delete" 
					onclick="deleteRow(this)">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
				<?php else: ?>
				<a title="cancel" onclick="cancel(this,'<?php echo $row->cancel_flg ?>',<?php echo $x ?>)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png"></a>
				<?php endif; ?>	
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<br class="temp"/>
	
<?php echo $form->label($model, 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>

<br class="temp"/><br class="temp"/>

<script>
	var rowCount = <?php echo count($modelClientBank) ?>;
	
	$(window).resize(function() {
		var body = $("#tableBank").find('tbody');
		if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
		{
			$('thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('thead').css('width', '100%');	
		}
		
		alignColumn();
	})
	$(window).trigger('resize');
	
	$("#tabMenu li:eq(4)").click(function()
	{	
		//Wait several miliseconds before aligning the columns to get the correct width of thead columns. 
		//Wrong width is retrieved if function alignColumn() is called right after the tab is clicked. This might be caused by bootstrap's tab widget.
		
		setTimeout(
		  function() 
		  {
		    alignColumn();
		  }, 0350);
	});
	
	cancel_reason();
	
	function setCheckBox(obj)
	{
		var currRow = $(obj).closest('tr');
		
		if(currRow.hasClass('markCancel'))currRow.find('td:eq(9) a').trigger('click');//Unmark the row for cancellation if the default radio button is clicked
		else if(!currRow.find('td:eq(0) [type=checkbox]').is(':checked') && !currRow.find('td:eq(2) [type=hidden]').val())currRow.find('td:eq(0) [type=checkbox]').prop('checked',true).trigger('change');//Check the checkbox if the default radio button is clicked and the row contains a new record
	}
	
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		if(!$(obj).is(':checked') && $("#tableBank tbody tr:eq("+x+") td:eq(2) [type=hidden]").val())resetValue(x); // Reset Value when the checkbox is unchecked and the row contains an existing record

		$("#tableBank tbody tr:eq("+x+") td:eq(1) select").attr("disabled",!$(obj).is(':checked')?true:false);
		$("#tableBank tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBank tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBank tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBank tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBank tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableBank tbody tr:eq("+x+") td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		if(!$(obj).is(':checked') && !$("#tableBank tbody tr:eq("+x+") td:eq(2) [type=hidden]").val())$("#tableBank tbody tr:eq("+x+") td:eq(8) [type=radio]").prop("checked",false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(9) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function resetValue(x)
	{
		$("#tableBank tbody tr:eq("+x+") td:eq(1) select").val($("#tableBank tbody tr:eq("+x+") td:eq(1) [type=hidden]").val());
		$("#tableBank tbody tr:eq("+x+") td:eq(2) [type=text]").val($("#tableBank tbody tr:eq("+x+") td:eq(2) [type=hidden]").val());
		$("#tableBank tbody tr:eq("+x+") td:eq(3) [type=text]").val($("#tableBank tbody tr:eq("+x+") td:eq(3) [type=hidden]").val());
		$("#tableBank tbody tr:eq("+x+") td:eq(4) [type=text]").val($("#tableBank tbody tr:eq("+x+") td:eq(4) [type=hidden]").val());
		$("#tableBank tbody tr:eq("+x+") td:eq(5) [type=text]").val($("#tableBank tbody tr:eq("+x+") td:eq(5) [type=hidden]").val());
		$("#tableBank tbody tr:eq("+x+") td:eq(6) [type=text]").val($("#tableBank tbody tr:eq("+x+") td:eq(6) [type=hidden]").val());
		$("#tableBank tbody tr:eq("+x+") td:eq(7) [type=text]").val($("#tableBank tbody tr:eq("+x+") td:eq(7) [type=hidden]").val());
	}

	function addRow()
	{
		$("#tableBank").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row1')
    			.append($('<td>')
					.append($('<input>')
						.attr('name','Clientbank[1][save_flg]')
						.attr('type','checkbox')
						.attr('onChange','rowControl(this)')
						.prop('checked',true)
						.val('Y')
					)
				).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Clientbank[1][bank_cd]')
               		 	.append($('<option>')
               		 		.val('')
               		 		.html('-Choose Bank-')
               		 	)
						<?php
						foreach($bankList as $row){
						?>
						.append($('<option>')
							.val('<?php echo $row->bank_cd ?>')
							.html('<?php echo $row->bank_name ?>')
						)
						<?php } ?>
               		)
				).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientbank[1][bank_acct_num]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientbank[1][bank_branch]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientbank[1][bank_phone_num]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientbank[1][acct_name]')
               		 	.attr('type','text')
               		 	.val($("#Cif_cif_name").val())
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientbank[1][bank_acct_type]')
               		 	.attr('type','text')
               		)
               	)
               	.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientbank[1][bank_acct_currency]')
               		 	.attr('type','text')
               		 	.attr('maxlength',3)
               		 	.val('IDR')
               		)
               	).append($('<td>')
               		.append($('<input>')
               			.attr('class','span')
               			.attr('name','default')
               			.attr('id','default1')
               			.attr('type','radio')
               			.attr('onClick','setCheckBox(this)')
               			.prop('checked',rowCount==0?true:false)
               			.val(1)
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)  	
    		);
    	
    	rowCount++;
    	reassignId();
    	$(window).trigger('resize');
	}
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignId();
		$(window).trigger('resize');
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
		$('[name="Clientbank['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
		$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
		
		$("#tableBank tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
		
		if(cancel_flg == 'N')$("#default"+seq).prop('checked',false); //uncheck the default radio button if the row is marked for cancellation
		
		cancel_reason();
	}
	
	function cancel_reason()
	{
		var cancel_reason = false;
		
		for(x=0;x<rowCount;x++)
		{
			if($("#row"+(x+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason && <?php if($model->isNewRecord)echo '1';else echo '0'; ?>)$(".cancel_reason, .temp").show().attr('disabled',false) //Since cancel reason is merged with modify reason when performing update
		else
			$(".cancel_reason, .temp").hide().attr('disabled',true);
	}
	
	function reassignId()
   	{
   		for(x=0;x<rowCount;x++)
   		{
			$("#tableBank tbody tr:eq("+x+")").attr("id","row"+(x+1));	
			$("#tableBank tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Clientbank["+(x+1)+"][save_flg]");
			$("#tableBank tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Clientbank["+(x+1)+"][save_flg]");
			$("#tableBank tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Clientbank["+(x+1)+"][cancel_flg]");
			$("#tableBank tbody tr:eq("+x+") td:eq(1) select").attr("name","Clientbank["+(x+1)+"][bank_cd]");
			$("#tableBank tbody tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Clientbank["+(x+1)+"][old_bank_cd]");
			$("#tableBank tbody tr:eq("+x+") td:eq(2) [type=text]").attr("name","Clientbank["+(x+1)+"][bank_acct_num]");
			$("#tableBank tbody tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Clientbank["+(x+1)+"][old_bank_acct_num]");
			$("#tableBank tbody tr:eq("+x+") td:eq(3) [type=text]").attr("name","Clientbank["+(x+1)+"][bank_branch]");
			$("#tableBank tbody tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Clientbank["+(x+1)+"][old_bank_branch]");
			$("#tableBank tbody tr:eq("+x+") td:eq(4) [type=text]").attr("name","Clientbank["+(x+1)+"][bank_phone_num]");
			$("#tableBank tbody tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Clientbank["+(x+1)+"][old_bank_phone_num]");
			$("#tableBank tbody tr:eq("+x+") td:eq(5) [type=text]").attr("name","Clientbank["+(x+1)+"][acct_name]");
			$("#tableBank tbody tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Clientbank["+(x+1)+"][old_acct_name]");
			$("#tableBank tbody tr:eq("+x+") td:eq(6) [type=text]").attr("name","Clientbank["+(x+1)+"][bank_acct_type]");
			$("#tableBank tbody tr:eq("+x+") td:eq(6) [type=hidden]").attr("name","Clientbank["+(x+1)+"][old_bank_acct_type]");
			$("#tableBank tbody tr:eq("+x+") td:eq(7) [type=text]").attr("name","Clientbank["+(x+1)+"][bank_acct_currency]");
			$("#tableBank tbody tr:eq("+x+") td:eq(7) [type=hidden]").attr("name","Clientbank["+(x+1)+"][old_bank_acct_currency]");
			$("#tableBank tbody tr:eq("+x+") td:eq(8) [type=radio]").attr("id","default"+(x+1)).val(x+1);
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Clientbank["+(x+1)+"][cancel_flg]']").val())
				$("#tableBank tbody tr:eq("+x+") td:eq(9) a:eq(0)").attr('onClick',"cancel(this,'"+$("[name='Clientbank["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableBank tbody tr:eq("+x+") td:eq(9) a:eq(0)").attr('onClick',"deleteRow(this)");
   			}
   		}
   	}
   	
   	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableBank").find('thead');
		var firstRow = $("#tableBank").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
	}
</script>