<style>
	#tableFpps
	{
		background-color:#C3D9FF;
	}
	#tableFpps thead, #tableFpps tbody, #tableFpps tfoot
	{
		display:block;
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
			<th width="2%">No</th>
			<th width="4%">Jenis ID</th>
			<th width="11%">No ID</th>
			<th width="15%">Nama 1</th>
			<th width="8%">Nama 2</th>
			<th width="9%">Jumlah Pesan</th>
			<th width="18%">Alamat</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1;
			$total = 0;
			foreach($modelRetrieve as $row){ ?>
		<tr class="first">
			<td class="no">
				<?php echo $form->textField($row,'no',array('class'=>'span','name'=>'FppsList['.$x.'][no]','readonly'=>'readonly')) ?>
				<input type="hidden" name="FppsList[<?php echo $x ?>][nama_peap]" value="<?php echo $row->nama_peap ?>" />
				<input type="hidden" name="FppsList[<?php echo $x ?>][partisipan]" value="<?php echo $row->partisipan ?>" />
				<input type="hidden" name="FppsList[<?php echo $x ?>][status_pesan]" value="<?php echo $row->status_pesan ?>" />
			</td>
			<td class="jenisId">
				<?php echo $form->textField($row,'jenis_id',array('class'=>'span','name'=>'FppsList['.$x.'][jenis_id]','readonly'=>'readonly')) ?>
			</td>
			<td class="noId">
				<?php echo $form->textField($row,'no_id',array('class'=>'span','name'=>'FppsList['.$x.'][no_id]','readonly'=>'readonly')) ?>
			</td>
			<td class="nama1">
				<?php echo $form->textField($row,'nama_1',array('class'=>'span','name'=>'FppsList['.$x.'][nama_1]','readonly'=>'readonly')) ?>
			</td>
			<td class="nama2">
				<?php echo $form->textField($row,'nama_2',array('class'=>'span','name'=>'FppsList['.$x.'][nama_2]','readonly'=>'readonly')) ?>
			</td>
			<td class="jumPesan">
				<?php echo $form->textField($row,'jum_pesan',array('class'=>'span tnumber','name'=>'FppsList['.$x.'][jum_pesan]','readonly'=>'readonly')) ?>
			</td>
			<td class="alamat">
				<?php echo $form->textField($row,'alamat',array('class'=>'span','name'=>'FppsList['.$x.'][alamat]','readonly'=>'readonly')) ?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align:right">Tgl Lahir</td>
			<td>
				<?php echo $form->textField($row,'tanggal_lahir',array('class'=>'span7','name'=>'FppsList['.$x.'][tanggal_lahir]','readonly'=>'readonly')) ?>
				&emsp;
				WN
				<?php echo $form->textField($row,'warganegara',array('class'=>'span2','name'=>'FppsList['.$x.'][warganegara]','readonly'=>'readonly','style'=>'float:right')) ?>
			</td>
			<td>
				Status
				<?php echo $form->textField($row,'status',array('class'=>'span9','name'=>'FppsList['.$x.'][status]','readonly'=>'readonly','style'=>'float:right')) ?>
			</td>
			<td style="text-align:right">Tgl ID Expired</td>
			<td>
				<?php echo $form->textField($row,'tanggal_id_expired',array('class'=>'span','name'=>'FppsList['.$x.'][tanggal_id_expired]','readonly'=>'readonly')) ?>
			</td>
			<td>
				Kecamatan
				<?php echo $form->textField($row,'kecamatan',array('class'=>'span8','name'=>'FppsList['.$x.'][kecamatan]','readonly'=>'readonly','style'=>'float:right')) ?>
			</td>
		</tr>
		<tr>
			<td class="thirdRow"></td>
			<td class="thirdRow"></td>
			<td class="thirdRow" style="text-align:right">Rekening Efek</td>
			<td class="thirdRow">
				<?php echo $form->textField($row,'rekening_efek',array('class'=>'span','name'=>'FppsList['.$x.'][rekening_efek]','readonly'=>'readonly')) ?>
			</td>
			<td class="thirdRow"></td>
			<td class="thirdRow"></td>
			<td class="thirdRow">
				Kota
				<?php echo $form->textField($row,'kota',array('class'=>'span8','name'=>'FppsList['.$x.'][kota]','readonly'=>'readonly','style'=>'float:right')) ?>
			</td>
		</tr>
		<?php 
				$total = $total + $row->jum_pesan;
				$x++;
			} 
		?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4"></td>
			<td style="text-align:right"><b>Total :</b></td>
			<td>
				<input class="span tnumber" type="text" id="totalQty" name="totalQty" readonly value="<?php echo $total ?>" />
			</td>
			<td ></td>
		</tr>
		<tr>
			<td style="visibility:hidden"></td>
			<td style="visibility:hidden"></td>
			<td style="visibility:hidden"></td>
			<td style="visibility:hidden"></td>
			<td style="visibility:hidden"></td>
			<td style="visibility:hidden"></td>
			<td style="visibility:hidden"></td>
		</tr>
	</tfoot>
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
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width()+'px');
		
		var footer = $("#tableFpps").find('tfoot');
		var footerRow = $("#tableFpps").find('tfoot tr:eq(1)');
		
		footerRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		footerRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		footerRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		footerRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		footerRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		footerRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		footerRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
	}
</script>