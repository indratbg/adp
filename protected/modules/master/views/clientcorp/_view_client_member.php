<style>
	#memberTable
	{
		width:500px;
	}
</style>

<table id="memberTable" class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>Client Code</th>
			<th>Subrek</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($modelClientMember as $row){ ?>
			<tr>
				<td><?php echo $row->client_cd ?></td>
				<td><?php echo $row->subrek14 ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
