<style>
		#tableXml
	{
		background-color:#C3D9FF;
	}
	#tableXml thead, #tableXml tbody
	{
		display:block;
	}
	#tableXml tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>

<label>Total &nbsp;<?php echo $cnt_detail ;?> &nbsp;client(s)</label>

<table id='tableXml'  class='table-bordered table-condensed' style="width: 80%">
	<thead>
		<tr>
			<th width="100px">Date</th>
			<th width="100px">Client Code</th>
			<th width="300px">Name</th>
			<th width="150px">Sub Rekening</th>
			<th width="150px">Amount</th>
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
	
		foreach($modelDetail as $row){
	?>
		<tr id="row<?php echo $x ?>"  class="save">
		<td >
			<?php echo $form->textField($row,'doc_date',array('class'=>'span','name'=>'Genxmlfundtransfertoksei['.$x.'][doc_date]','readonly'=>true));?>
			
		</td>
		<td>
			<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Genxmlfundtransfertoksei['.$x.'][client_cd]','readonly'=>true));?>
		</td>
		<td>
			<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Genxmlfundtransfertoksei['.$x.'][client_name]','readonly'=>true));?>
		</td>
		<td>
			<?php echo $form->textField($row,'subrek',array('class'=>'span','name'=>'Genxmlfundtransfertoksei['.$x.'][subrek]','readonly'=>true));?>
		</td>
		<td>
			<?php  echo $form->textField($row,'trx_amt',array('class'=>'span tnumber','name'=>'Genxmlfundtransfertoksei['.$x.'][trx_amt]','style'=>'text-align:right','readonly'=>true));?>
		</td>
		</tr>
	<?php $x++;} ?>
	</tbody>	
</table>
<script>
		$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	function adjustWidth(){
		var header = $("#tableXml").find('thead');
		var firstRow = $("#tableXml").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',(header.find('th:eq(4)').width())-17 + 'px');
	}
</script>