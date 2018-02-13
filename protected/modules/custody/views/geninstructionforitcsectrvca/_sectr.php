<style>
		#tableSectr
	{
		background-color:#C3D9FF;
	}
	#tableSectr thead, #tableSectr tbody
	{
		display:block;
	}
	#tableSectr tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>

<table id='tableSectr'  class='table-bordered table-condensed' >
	<thead>
		<tr>
			<th width="90px"></th>
			<th width="80px">FROM</th>
			<th width="130px">Sub Rek</th>
			<th width="70px">Stock</th>
			<th width="130px">Qty</th>
			<th width="30px">xml</th>
			<th width="80px">TO</th>
			<th width="125px">Sub Rek</th>
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
	
		foreach($modelDetailSectr as $row){
	?>
		<tr id="row<?php echo $x ?>"  class="save">
		<td >
			<?php echo $form->textField($row,'settle_date',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][settle_date]','readonly'=>true));?>
			<?php echo $form->textField($row,'doc_num',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][doc_num]','style'=>'display:none'));?>
		</td>
		<td>
			<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][client_cd]','readonly'=>true));?>
		</td>
		<td>
			<?php echo $form->textField($row,'from_subrek',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][from_subrek]','readonly'=>true));?>
		</td>
		<td>
			<?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][stk_cd]','readonly'=>true));?>
		</td>
		<td>
			<?php  echo $form->textField($row,'qty',array('class'=>'span tnumber','name'=>'Geninstructionforitcsectrvca['.$x.'][qty]','style'=>'text-align:right','readonly'=>true));?>
		</td>
		<td class="save_flg">
			<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','uncheckValue'=>'N','name'=>'Geninstructionforitcsectrvca['.$x.'][save_flg]')); ?>
		</td>
		<td>
			<?php  echo $form->textField($row,'to_client',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][to_client]','readonly'=>true));?>
		</td>
		<td>
			<?php  echo $form->textField($row,'to_subrek',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][to_subrek]','readonly'=>true));?>
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
		var header = $("#tableSectr").find('thead');
		var firstRow = $("#tableSectr").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',(header.find('th:eq(8)').width())-17 + 'px');
	}
</script>