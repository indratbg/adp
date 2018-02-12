<style>
	#tableAutho
	{
		background-color:#C3D9FF;
	}
	#tableAutho thead, #tableAutho tbody
	{
		display:block;
	}
	#tableAutho tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	
	.thirdRow
	{
		border-bottom: 1px solid #e5e5e5;
	}
</style>

<?php

?>

<input type='hidden' id="authoCount" name="authoCount"/>

<table id='tableAutho' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="3%"></th>
			<th width="4%">No Urut</th>
			<th width="17%">Authorized Person Name</th>
			<th width="10%">ID Type</th>
			<th width="18%">ID Number</th>
			<th width="10%">Expiry Date</th>
			<th width="9%"></th>
			<th width="19%"></th>
			<th width="10%" style="text-align:center">
				<a title="add" onclick="addRowAutho()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelClientAutho as $row){ 
	?>

		<tr class="row<?php echo $x ?> <?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td rowspan="3" class="thirdRow">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Clientautho['.$x.'][save_flg]','onChange'=>'rowControlAutho(this)')); ?>
				<?php if($row->old_seqno): ?>
					<input type="hidden" name="Clientautho[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td rowspan="3" class="thirdRow">
				<?php echo $form->textField($row,'seqno',array('class'=>'span','name'=>'Clientautho['.$x.'][seqno]','maxlength'=>2,'readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Clientautho[<?php echo $x ?>][old_seqno]" value="<?php echo $row->old_seqno ?>" />
			</td>
			<td><?php echo $form->textField($row,'first_name',array('class'=>'span','maxlength'=>40,'name'=>'Clientautho['.$x.'][first_name]','placeholder'=>'First Name','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td>KTP <input type="button" class="ktpLifeTime span8" value="Lifetime" onclick="ktpLifeTime(this)"/></td>
			<td><?php echo $form->textField($row,'ktp_no',array('class'=>'span','maxlength'=>30,'name'=>'Clientautho['.$x.'][ktp_no]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td>
				<?php echo $form->textField($row,'ktp_expiry',array('class'=>'span tdate authoDate','name'=>'Clientautho['.$x.'][ktp_expiry]','disabled'=>$row->save_flg!='Y'?'disabled':'')); ?>
				<input type="hidden" name="Clientautho[<?php echo $x ?>][old_ktp_expiry]" value="<?php echo $row->old_ktp_expiry ?>" />
			</td>
			<td>Job Position</td>
			<td><?php echo $form->textField($row,'position',array('class'=>'span','maxlength'=>40,'name'=>'Clientautho['.$x.'][position]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td rowspan="2"  style="text-align:center">
				<?php if(!$row->old_seqno): ?>
				<a 
					title="delete" 
					onclick="deleteRowAutho(this)">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
				<?php else: ?>
				<a title="cancel" onclick="cancelAutho(this,'<?php echo $row->cancel_flg ?>',<?php echo $x ?>)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png"></a>
				<?php endif; ?>	
			</td>
		</tr>
		<tr class="row<?php echo $x ?> <?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td><?php echo $form->textField($row,'middle_name',array('class'=>'span','maxlength'=>40,'name'=>'Clientautho['.$x.'][middle_name]','placeholder'=>'Middle Name','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td>Passport</td>
			<td><?php echo $form->textField($row,'passport_no',array('class'=>'span','maxlength'=>30,'name'=>'Clientautho['.$x.'][passport_no]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td>
				<?php echo $form->textField($row,'passport_expiry',array('class'=>'span tdate authoDate','name'=>'Clientautho['.$x.'][passport_expiry]','disabled'=>$row->save_flg!='Y'?'disabled':'')); ?>
				<input type="hidden" name="Clientautho[<?php echo $x ?>][old_passport_expiry]" value="<?php echo $row->old_passport_expiry ?>" />
			</td>	
			<td>NPWP No</td>
			<td><?php echo $form->textField($row,'npwp_no',array('class'=>'span','maxlength'=>30,'name'=>'Clientautho['.$x.'][npwp_no]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
		</tr>
		<tr class="row<?php echo $x ?> <?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td class="thirdRow"><?php echo $form->textField($row,'last_name',array('class'=>'span','maxlength'=>40,'name'=>'Clientautho['.$x.'][last_name]','placeholder'=>'Last Name','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td class="thirdRow">KITAS/SKD</td>
			<td class="thirdRow"><?php echo $form->textField($row,'kitas_no',array('class'=>'span','maxlength'=>30,'name'=>'Clientautho['.$x.'][kitas_no]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td class="thirdRow">
				<?php echo $form->textField($row,'kitas_expiry',array('class'=>'span tdate authoDate','name'=>'Clientautho['.$x.'][kitas_expiry]','disabled'=>$row->save_flg!='Y'?'disabled':'')); ?>
				<input type="hidden" name="Clientautho[<?php echo $x ?>][old_kitas_expiry]" value="<?php echo $row->old_kitas_expiry ?>" />
			</td>	
			<td class="thirdRow">NPWP Date</td>
			<td class="thirdRow">
				<?php echo $form->textField($row,'npwp_date',array('class'=>'span7 tdate authoDate','name'=>'Clientautho['.$x.'][npwp_date]','disabled'=>$row->save_flg!='Y'?'disabled':'')); ?>
				<input type="hidden" name="Clientautho[<?php echo $x ?>][old_npwp_date]" value="<?php echo $row->old_npwp_date ?>" />
				&nbsp; Birth Date
			</td>
			<td class="thirdRow">
				<?php echo $form->textField($row,'birth_dt',array('class'=>'span tdate authoDate','name'=>'Clientautho['.$x.'][birth_dt]','disabled'=>$row->save_flg!='Y'?'disabled':'')); ?>
				<input type="hidden" name="Clientautho[<?php echo $x ?>][old_birth_dt]" value="<?php echo $row->old_birth_dt ?>" />
			</td>
		</tr>

	<?php $x++;} ?>
	</tbody>
</table>

<br class="temp_autho"/>
	
<?php echo $form->label($model, 'Cancel Reason', array('class'=>'control-label cancel_reason_autho'))?>
<textarea id="cancel_reason_autho" class="span5 cancel_reason_autho" name="cancel_reason_autho" maxlength="200" rows="4" disabled><?php echo $cancel_reason_autho ?></textarea>

<br class="temp_autho"/><br class="temp_autho"/>

<script>
	$("#tabMenu li:eq(1)").click(function()
	{	
		//Wait several miliseconds before aligning the columns to get the correct width of thead columns. 
		//Wrong width is retrieved if function alignColumn() is called right after the tab is clicked. This might be caused by bootstrap's tab widget.
		
		setTimeout(
		  function() 
		  {
		    alignColumnAutho();
		  }, 0350);
	});
	
	function ktpLifeTime(obj)
	{
		var ktpExpiry = $(obj).parent().next().next().children('[type=text]');

		if($(obj).closest('tr').children('td:first').children('[type=checkbox]').is(':checked'))ktpExpiry.val('01/01/5000');
	}
	
	function rowControlAutho(obj)
	{
		var row1 = $(obj).closest('tr');
		var row2 = row1.next();
		var row3 = row2.next();
		
		row1.find("td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		row1.find("td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		row1.find("td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		row1.find("td:eq(5) [type=text]").attr("disabled",!$(obj).is(':checked')?true:false);
		row1.find("td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		row2.find("td:eq(0) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		row2.find("td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		row2.find("td:eq(3) [type=text]").attr("disabled",!$(obj).is(':checked')?true:false);
		row2.find("td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		row3.find("td:eq(0) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		row3.find("td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		row3.find("td:eq(3) [type=text]").attr("disabled",!$(obj).is(':checked')?true:false);
		row3.find("td:eq(5) [type=text]").attr("disabled",!$(obj).is(':checked')?true:false);
		row3.find("td:eq(6) [type=text]").attr("disabled",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && row1.hasClass('markCancel'))row1.find('td:eq(8) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}

	function addRowAutho()
	{
		$("#tableAutho").find('tbody')
    		.prepend($('<tr>')
    			.attr('class','row1')
    			.append($('<td>')
    				.addClass("thirdRow")
    				.attr('rowspan','3')
					.append($('<input>')
						.attr('name','Clientautho[1][save_flg]')
						.attr('type','checkbox')
						.attr('onChange','rowControlAutho(this)')
						.prop('checked',true)
						.val('Y')
					)
				).append($('<td>')
					.addClass("thirdRow")
					.attr('rowspan','3')
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][seqno]')
						.attr('type','text')
						.attr('maxlength','2')
               		)
				).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][first_name]')
               		 	.attr('type','text')
               		 	.attr('maxlength','40')
               		 	.attr('placeholder','First Name')
               		)
               	).append($('<td>')
               		 .html('KTP ')
               		 .append($('<input>')
               		 	.attr('type','button')
               		 	.attr('class','span8 ktpLifeTime')
               		 	.click(function()
               		 	{
               		 		ktpLifeTime(this);
               		 	})
               		 	.val('Lifetime')
               		 )
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][ktp_no]')
               		 	.attr('type','text')
               		 	.attr('maxlength','30')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][ktp_expiry]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .html('Job Position')
               	)
               	.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][position]')
               		 	.attr('type','text')
               		 	.attr('maxlength','40')
               		)
               	).append($('<td>')
               		.attr('rowspan','2')
               		.append($('<a>')
               		 	.attr('onClick','deleteRowAutho(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               		.css('text-align','center')
               	)  	
    		);
    		
    		($('<tr>').insertAfter($("#tableAutho").find('tbody tr:first'))
    			.attr('class','row1')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][middle_name]')
               		 	.attr('type','text')
               		 	.attr('maxlength','40')
               		 	.attr('placeholder','Middle Name')
               		)
               	).append($('<td>')
               		 .html('Passport')
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][passport_no]')
               		 	.attr('type','text')
               		 	.attr('maxlength','30')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][passport_expiry]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .html('NPWP No')
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][npwp_no]')
               		 	.attr('type','text')
               		 	.attr('maxlength','30')
               		)
               	)
            );
            
            ($('<tr>').insertAfter($("#tableAutho").find('tbody tr:eq(1)'))
            	.attr('class','row1')
    			.append($('<td>')
    				.addClass("thirdRow")
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][last_name]')
               		 	.attr('type','text')
               		 	.attr('maxlength','40')
               		 	.attr('placeholder','Last Name')
               		)
               	).append($('<td>')
               		.addClass("thirdRow")
               		.html('KITAS/SKD')
               	).append($('<td>')
               		.addClass("thirdRow")
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][kitas_no]')
               		 	.attr('type','text')
               		 	.attr('maxlength','30')
               		)
               	).append($('<td>')
               		.addClass("thirdRow")
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][kitas_expiry]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		.addClass("thirdRow")
               		.html('NPWP Date')
               	).append($('<td>')
               		.addClass("thirdRow")
               		.append($('<input>')
               		 	.attr('class','span7')
               		 	.attr('name','Clientautho[1][npwp_date]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               		.append('&nbsp;&nbsp;&nbsp; Birth Date')
               	).append($('<td>')
               		.addClass("thirdRow")
               		.append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Clientautho[1][birth_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	)
            );
    	
    	authoCount += 3;
    	reassignIdAutho();
    	$(window).trigger('resize');
	}
	
	function deleteRowAutho(obj)
	{
		var row1 = $(obj).closest('tr');
		var row2 = row1.next();
		var row3 = row2.next();
		
		row1.remove();
		row2.remove();
		row3.remove();
		
		authoCount -= 3;
		reassignIdAutho();
		$(window).trigger('resize');
	}
	
	function cancelAutho(obj, cancel_flg, seq)
	{
		var row1 = $(obj).closest('tr');
		var row2 = row1.next();
		var row3 = row2.next();
		
		if(cancel_flg == 'N')
		{
			row1.addClass('markCancel'); 
			row2.addClass('markCancel'); 
			row3.addClass('markCancel'); 
		}
		else
		{
			row1.removeClass('markCancel'); 
			row2.removeClass('markCancel'); 
			row3.removeClass('markCancel'); 
		}
		
		$('[name="Clientautho['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
		$(obj).attr('onClick',cancel_flg=='N'?"cancelAutho(this,'Y',"+seq+")":"cancelAutho(this,'N',"+seq+")");
		
		row1.find("td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
		
		cancel_reason_autho();
	}
	
	function cancel_reason_autho()
	{
		var cancel_reason = false;
		
		for(x=0,y=0;x<authoCount;x+=3,y++)
		{
			if($(".row"+(y+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason && <?php if($model->isNewRecord)echo '1';else echo '0'; ?>)$(".cancel_reason_autho, .temp_autho").show().attr('disabled',false) 
		else
			$(".cancel_reason_autho, .temp_autho").hide().attr('disabled',true);
	}
	
	function reassignIdAutho()
   	{
   		var row1, row2, row3;
   		var x,y;
   		
   		for(x=0,y=0;x<authoCount;x+=3,y++)
   		{
   			row1 = $("#tableAutho tbody tr:eq("+x+")");
   			row2 = $("#tableAutho tbody tr:eq("+(x+1)+")");
   			row3 = $("#tableAutho tbody tr:eq("+(x+2)+")");
   			
   			if(row1.hasClass('markCancel'))
   			{
	   			row1.attr('class','row'+(y+1)+' markCancel');
	   			row2.attr('class','row'+(y+1)+' markCancel');
	   			row3.attr('class','row'+(y+1)+' markCancel');
   			}
   			else
   			{
   				row1.attr('class','row'+(y+1));
   				row2.attr('class','row'+(y+1));
   				row3.attr('class','row'+(y+1));
   			}
   			
			row1.find("td:eq(0) [type=checkbox]").attr("name","Clientautho["+(y+1)+"][save_flg]");
			row1.find("td:eq(0) [type=hidden]:eq(0)").attr("name","Clientautho["+(y+1)+"][save_flg]");
			row1.find("td:eq(0) [type=hidden]:eq(1)").attr("name","Clientautho["+(y+1)+"][cancel_flg]");
			row1.find("td:eq(1) [type=text]").attr("name","Clientautho["+(y+1)+"][seqno]");
			row1.find("td:eq(1) [type=hidden]").attr("name","Clientautho["+(y+1)+"][old_seqno]");
			row1.find("td:eq(2) [type=text]").attr("name","Clientautho["+(y+1)+"][first_name]");
			row1.find("td:eq(4) [type=text]").attr("name","Clientautho["+(y+1)+"][ktp_no]");
			row1.find("td:eq(5) [type=text]").attr("name","Clientautho["+(y+1)+"][ktp_expiry]");
			row1.find("td:eq(5) [type=hidden]").attr("name","Clientautho["+(y+1)+"][old_ktp_expiry]");
			row1.find("td:eq(7) [type=text]").attr("name","Clientautho["+(y+1)+"][position]");
			
			row2.find("td:eq(0) [type=text]").attr("name","Clientautho["+(y+1)+"][middle_name]");
			row2.find("td:eq(2) [type=text]").attr("name","Clientautho["+(y+1)+"][passport_no]");
			row2.find("td:eq(3) [type=text]").attr("name","Clientautho["+(y+1)+"][passport_expiry]");
			row1.find("td:eq(3) [type=hidden]").attr("name","Clientautho["+(y+1)+"][old_passport_expiry]");
			row2.find("td:eq(5) [type=text]").attr("name","Clientautho["+(y+1)+"][npwp_no]");
			
			row3.find("td:eq(0) [type=text]").attr("name","Clientautho["+(y+1)+"][last_name]");
			row3.find("td:eq(2) [type=text]").attr("name","Clientautho["+(y+1)+"][kitas_no]");
			row3.find("td:eq(3) [type=text]").attr("name","Clientautho["+(y+1)+"][kitas_expiry]");
			row1.find("td:eq(3) [type=hidden]").attr("name","Clientautho["+(y+1)+"][old_kitas_expiry]");
			row3.find("td:eq(5) [type=text]").attr("name","Clientautho["+(y+1)+"][npwp_date]");
			row1.find("td:eq(5) [type=hidden]").attr("name","Clientautho["+(y+1)+"][old_npwp_date]");
			row3.find("td:eq(6) [type=text]").attr("name","Clientautho["+(y+1)+"][birth_dt]");
			row1.find("td:eq(6) [type=hidden]").attr("name","Clientautho["+(y+1)+"][old_birth_dt]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0,y=0;x<authoCount;x+=3,y++)
   		{
   			if($("[name='Clientautho["+(y+1)+"][cancel_flg]']").val())
				$("#tableAutho tbody tr:eq("+x+") td:eq(8) a:eq(0)").attr('onClick',"cancelAutho(this,'"+$("[name='Clientautho["+(y+1)+"][cancel_flg]']").val()+"',"+(y+1)+")")		
   			else
   			{
   				$("#tableAutho tbody tr:eq("+x+") td:eq(8) a:eq(0)").attr('onClick',"deleteRowAutho(this)");
   			}
   		}
   	}
   	
   	function alignColumnAutho()//align columns in thead and tbody
	{
		var header = $("#tableAutho").find('thead');
		var firstRow = $("#tableAutho").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
	}
</script>