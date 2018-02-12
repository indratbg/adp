<style>
		#tableOTC
	{
		background-color:#C3D9FF;
	}
	#tableOTC thead, #tableOTC tbody
	{
		display:block;
	}
	#tableOTC tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>

<table id='tableOTC'  class='table-bordered table-condensed' >
	<thead>
		<tr>
			<th width="90px">Client Cd</th>
			<th width="70px">Mutasi</th>
			<th width="50px">Stk Cd</th>
			<th width="100px">Qty</th>
			<th width="60px">Broker</th>
			<th width="30px">xml</th>
			<th width="120px">Amount</th>
			<th width="125px">Subrek</th>
			<th width="200px"></th>
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
	
		foreach($modelDetailOtc as $row){
	?>
		<tr id="row<?php echo $x ?>"  class="save">
		<td >
			<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][client_cd]','readonly'=>true));?>
			<?php echo $form->textField($row,'doc_num',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][doc_num]','style'=>'display:none'));?>
			<?php echo $form->textField($row,'instruction_type',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][instruction_type]','style'=>'display:none'));?>
			<?php echo $form->textField($row,'settle_date',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][settle_date]','style'=>'display:none'));?>
		</td>
		<td>
			<?php echo $form->textField($row,'mutasi',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][mutasi]','readonly'=>true));?>
		</td>
		<td>
			<?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][stk_cd]','readonly'=>true));?>
		</td>
		<td>
			<?php echo $form->textField($row,'qty',array('class'=>'span tnumber','name'=>'Geninstructionforitcsectrvca['.$x.'][qty]','style'=>'text-align:right','readonly'=>true));?>
		</td>
		<td>
			<?php  echo $form->textField($row,'custodian_cd',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][custodian_cd]','readonly'=>true));?>
		</td>
		<td class="save_flg">
			<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','uncheckValue'=>'N','name'=>'Geninstructionforitcsectrvca['.$x.'][save_flg]')); ?>
		</td>
		<td>
			<?php  echo $form->textField($row,'amount',array('class'=>'span tnumber','name'=>'Geninstructionforitcsectrvca['.$x.'][amount]','style'=>'text-align:right','readonly'=>true));?>
		</td>
		<td>
			<?php  echo $form->textField($row,'subrek',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][subrek]','readonly'=>true));?>
		</td>
		<td>
			<?php  echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Geninstructionforitcsectrvca['.$x.'][client_name]','readonly'=>true));?>
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
		var header = $("#tableOTC").find('thead');
		var firstRow = $("#tableOTC").find('tbody tr:eq(0)');
		
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