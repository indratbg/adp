<style>
	#tableFpps
	{
		background-color:#C3D9FF;
	}
	#tableFpps tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tableFpps tfoot
	{
		background-color:#FFFFFF;
		font-style:normal;
	}
	#tableFpps th, #tableFpps td
	{
		padding:3px;
	}
	.thirdRow
	{
		border-bottom: 1px solid #e5e5e5;
	}
</style>

<table id="tableFpps" class="table-bordered table-condensed">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<th width="15%">FPPS Number <button onclick="genfppsnum(); return false;" title="Generate"><i class="icon-repeat" style="cursor: pointer;"></button></i></th>
			<th width="20%">Subrek</th>
			<th width="30%">Name</th>
			<th width="15%">Fixed Qty</th>
			<th width="15%">Pooling Qty</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1;
			$total = 0;
			foreach($modelRetrieve as $row){ ?>
		<tr class="first">
			<td class="no">
				<?php echo $form->textField($row,'no',array('class'=>'span','name'=>'FppsList['.$x.'][no]','readonly'=>'readonly','value'=>$x)) ?>
				<input type="hidden" name="FppsList[<?php echo $x ?>][client_cd]" value="<?php echo $row->client_cd ?>" />
				<input type="hidden" name="FppsList[<?php echo $x ?>][stk_cd]" value="<?php echo $row->stk_cd ?>" />
				<input type="hidden" name="FppsList[<?php echo $x ?>][cre_dt]" value="<?php echo $row->cre_dt ?>" />
			</td>
			<td class="jenisId">
				<?php echo $form->textField($row,'fpps_num',array('class'=>'span','name'=>'FppsList['.$x.'][fpps_num]','id'=>'fppsnum'.$x)) ?>
			</td>
			<td class="noId">
				<?php echo $form->textField($row,'subrek',array('class'=>'span','name'=>'FppsList['.$x.'][subrek]','readonly'=>'readonly')) ?>
			</td>
			<td class="nama1">
				<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'FppsList['.$x.'][client_name]','readonly'=>'readonly')) ?>
			</td>
			<td class="nama2">
				<?php echo $form->textField($row,'fixed_qty',array('class'=>'span tnumber','name'=>'FppsList['.$x.'][fixed_qty]','readonly'=>'readonly')) ?>
			</td>
			<td class="jumPesan">
				<?php echo $form->textField($row,'pool_qty',array('class'=>'span tnumber','name'=>'FppsList['.$x.'][pool_qty]','readonly'=>'readonly')) ?>
			</td>
		</tr>
		<?php
			$x++;
			} 
		?>
	</tbody>
</table>

<script>
	$(window).resize(function()
	{
		var body = $("#tableFpps").find('tbody');
		
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
		var header = $("#tableFpps").find('thead');
		var firstRow = $("#tableFpps").find('tbody tr:first');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width()+'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width()+'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width()+'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width()+'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width()+'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width()+'px');
	}
	
	function genfppsnum(){
		var firstfpps = $("#fppsnum1").val();
		var maxfpps = <?php echo $x;?>;
		if(firstfpps){
			for(i=1;i<=maxfpps;i++){
				var nextfpps = parseInt(firstfpps) + i;
				$("#fppsnum"+(i+1)).val(pad(nextfpps,6));
			}
		}
	}
	
	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}
</script>