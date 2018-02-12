<style>
	#tableVchList
	{
		background-color:#C3D9FF;
	}
	#tableVchList thead, #tableVchList tbody, #tableVchList tfoot
	{
		display:block;
	}
	#tableVchList tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tableVchList tfoot
	{
		background-color:#FFFFFF;
		font-style:normal;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<table id="tableVchList" class="table-bordered table-condensed">
	<thead>
		<tr>
			<th width="14%">Date</th>
			<th width="14%">Client Code</th>
			<th width="21%">Amount</th>
			<th width="36%">Description</th>
			<th width="13%">Type</th>
			<th width="2%" style="text-align:center">
				<input type="checkbox"  id="checkAll"/>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1;
			foreach($modelVoucherList as $row){ ?>
		<tr>
			<td class="date">
				<?php echo $form->textField($row,'doc_date',array('class'=>'span tdate','name'=>'Tfundmovement['.$x.'][doc_date]','readonly'=>'readonly')) ?>
			</td>
			<td class="client">
				<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Tfundmovement['.$x.'][client_cd]','readonly'=>'readonly')) ?>
			</td>
			<td class="amount">
				<?php echo $form->textField($row,'trx_amt',array('class'=>'span tnumberdec','name'=>'Tfundmovement['.$x.'][trx_amt]','readonly'=>'readonly')) ?>
			</td>
			<td class="remarks">
				<?php echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Tfundmovement['.$x.'][remarks]','readonly'=>'readonly')) ?>
			</td>
			<td class="type">
				<?php echo $form->textField($row,'trx_type',array('class'=>'span','name'=>'Tfundmovement['.$x.'][trx_type]','readonly'=>'readonly')) ?>
			</td>
			<td class="print">
				<?php echo $form->checkBox($row,'print',array('value'=>'Y','uncheckValue'=>'N','name'=>'Tfundmovement['.$x.'][print]', 'class'=>'printCheck')) ?>
			</td>
			<input class="docNum" type="hidden" name="Tfundmovement[<?php echo $x ?>][doc_num]" value="<?php echo $row->doc_num ?>" />
			<input class="updateDate" type="hidden" name="Tfundmovement[<?php echo $x ?>][update_date]" value="<?php echo $row->update_date ?>" />
			<input class="updateSeq" type="hidden" name="Tfundmovement[<?php echo $x ?>][update_seq]" value="<?php echo $row->update_seq ?>" />
		</tr>
		<?php $x++;} ?>
	</tbody>
</table>

<script>
	$(window).resize(function()
	{
		var body = $("#tableVchList").find('tbody');
		
		if(body.length)
		{
			if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
			{
				$('thead').css('width', '100%').css('width', '-=17px');	
			}
			else
			{
				$('thead').css('width', '100%');	
			}
			
			alignColumn();
		}
	});
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableVchList").find('thead');
		var firstRow = $("#tableVchList").find('tbody tr:first');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width()+'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width()+'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width()+'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width()+'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width()+'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width()+'px');
	}
	
	$("#checkAll").click(function()
	{
		if($(this).is(':checked'))
		{
			$("#tableVchList").children("tbody").children('tr').children('td.print').children("[type=checkbox]").prop('checked',true).change();
		}
		else
		{
			$("#tableVchList").children("tbody").children('tr').children('td.print').children("[type=checkbox]").prop('checked',false).change();
		}
	});
	
	$(".printCheck").click(function()
	{
		checkAll();
	});
</script>