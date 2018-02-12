<table id='tableAutho<?php if(!isset($listTmanyClientAuthoDetail))echo 'Curr' ?>' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="5%">No Urut</th>
			<th width="14%">Authorized Person Name</th>
			<th width="7%">ID Type</th>
			<th width="15%">ID Number</th>
			<th width="10%">Expiry Date</th>
			<th width="9%"></th>
			<th width="19%"></th>
			<th width="11%">Birth Date</th>
			<?php if(isset($listTmanyClientAuthoDetail)): ?>
				<th width="10%">Status</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelClientAuthoDetail as $row){ 
	?>
		<tr>
			<td rowspan="3"  style="text-align:center">
				<?php echo $row->seqno ?>
				<input class="rowidAutho" type="hidden" value="<?php echo $row->rowid ?>"/>
			</td>
			<td><?php echo $row->first_name ?></td>
			<td><b>KTP</b></td>
			<td><?php echo $row->ktp_no; ?></td>
			<td><?php echo Yii::app()->format->formatDate($row->ktp_expiry) ?></td>
			<td><b>Job Position</b></td>
			<td><?php echo $row->position ?></td>
			<td rowspan="3" ><?php echo Yii::app()->format->formatDate($row->birth_dt) ?></td>
			<?php if(isset($listTmanyClientAuthoDetail)): ?>
			<td rowspan="3"  style="text-align:center">
				<?php echo AConstant::$inbox_stat[$listTmanyClientAuthoDetail[$x-1][0]->upd_status] ?>
			</td>
			<?php endif; ?>
		</tr>
		<tr>
			<td><?php echo $row->middle_name ?></td>
			<td><b>Passport</b></td>
			<td><?php echo $row->passport_no ?></td>
			<td><?php echo Yii::app()->format->formatDate($row->passport_expiry) ?></td>	
			<td><b>NPWP No</b></td>
			<td><?php echo $row->npwp_no ?></td>
		</tr>
		<tr>
			<td><?php echo $row->last_name ?></td>
			<td><b>KITAS/SKD</b></td>
			<td><?php echo $row->kitas_no ?></td>
			<td>
				<?php echo Yii::app()->format->formatDate($row->kitas_expiry) ?>
			</td>	
			<td><b>NPWP Date</b></td>
			<td>
				<?php echo Yii::app()->format->formatDate($row->npwp_date) ?>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>