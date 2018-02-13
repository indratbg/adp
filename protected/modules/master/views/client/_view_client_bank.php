<table id='tableBank<?php if(!isset($listTmanyClientBankDetail))echo 'Curr' ?>' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="20%">Bank</th>
			<th width="15%">Account No.</th>
			<th width="10%">Branch</th>
			<th width="15%">Bank Phone Number</th>
			<th width="17%">Account Name</th>
			<th width="12%">Account Type</th>
			<th width="4%">Currency</th>
			<th width="2%">Default</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelClientBankDetail as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td>
				<?php echo Ipbank::model()->find("approved_stat = 'A' AND bank_cd = '$row->bank_cd'")->DropDownName ?>
				<input class="rowid" type="hidden" value="<?php echo $row->rowid ?>"/>
			</td>
			<td><?php echo $row->bank_acct_num ?></td>
			<td><?php echo $row->bank_branch; ?></td>
			<td><?php echo $row->bank_phone_num ?></td>
			<td><?php echo $row->acct_name ?></td>
			<td><?php echo $row->bank_acct_type ?></td>
			<td><?php echo $row->bank_acct_currency ?></td>
			<td><?php if($row->default_flg == 'Y')echo 'Default' ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>