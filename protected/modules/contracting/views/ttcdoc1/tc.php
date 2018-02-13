<?php if ($model){?>
	<div>
		<div style="float: left; width: 50%">
			<p><img src="<?php echo Yii::app()->request->baseUrl ?>/images/yj.jpg" width="220px" ></p>
			<?php echo $model[0]->brch_addr_1;?><br/><?php echo $model[0]->brch_addr_2;?><br/>
			<?php echo $model[0]->brch_addr_3;?><br/>
			Phone : <?php echo $model[0]->brch_phone?>&emsp;Fax : <?php echo $model[0]->brch_fax;?><br />
			<br />
			ATT :&emsp;<?php echo $model[0]->contact_pers;?><br />
			&emsp;&emsp;&nbsp;&nbsp;&emsp;<?php echo $model[0]->def_addr_1;?><br />
			&emsp;&emsp;&nbsp;&nbsp;&emsp;<?php echo $model[0]->def_addr_2;?><br />
			&emsp;&emsp;&nbsp;&nbsp;&emsp;<?php echo $model[0]->def_addr_3;?><br />
			ZIP &nbsp;:&emsp;<?php echo $model[0]->post_cd;?><br />
		</div>
		<div style="float: right; width: 50%;">
			<table class="table-condensed" style="border: 2px solid;">
				<tr style="background: #ededed;"><td style="text-align: center; font-size: 24px; padding: 5px; font-weight: bold;">Trade Confirmation</td></tr>
				<tr style="border-top: 2px solid;"><td style="text-align: center; padding: 5px;"><strong><?php echo $model[0]->brch_name;?> Branch</strong></td></tr>
			</table>
			No. <?php echo $model[0]->tc_id?$model[0]->tc_id : '{tc_id}';?><br />
			<?php echo ucwords(strtolower($model[0]->client_title)).'. '.$model[0]->client_name; ?><br />
			Date &emsp;&emsp;&emsp; :&emsp;<?php echo DateTime::createFromFormat('Y-m-d h:i:s',$model[0]->contr_dt)->format('d/m/Y');?><br />
			Client Code :&emsp;<?php echo $model[0]->client_cd;?><br />
			Phone &emsp;&emsp;&nbsp;&nbsp;:&emsp;<?php echo ($model[0]->phone_num && (trim($model[0]->phone_num) != 'NA'))?$model[0]->phone_num : '';?><?php echo $model[0]->phone2_1?', '.$model[0]->phone2_1 : '';?><?php echo $model[0]->hand_phone1?', '.$model[0]->hand_phone1 : '';?><br />
			<?php if($model[0]->fax_num){?>Fax &emsp;&emsp;&emsp; :&emsp;<?php echo $model[0]->fax_num;?><br /><?php }?>
			<?php if($model[0]->e_mail1){?>
			<font style="color: blue">via e-mail</font><br />
			E-mail &emsp;&emsp;&nbsp;&nbsp;:&emsp;<?php echo $model[0]->e_mail1;?><br />
			<?php }?>
		</div>
	</div>
	<br style="clear: both;" />
	<div>
			As instructed, we have executed the following transaction(s) for your account:
			<table class="table-condensed">
				<tr style="background: #d2d4e9;">
					<td><strong>Share</strong></td>
					<td><strong>L/F</strong></td>
					<td style="text-align: right;"><strong>Lot</strong></td>
					<td style="text-align: right;"><strong>Quantity</strong></td>
					<td style="text-align: right;"><strong>Price</strong></td>
					<td colspan="2" style="text-align: right;"><strong>Amount Buy</strong></td>
					<td colspan="2" style="text-align: right;"><strong>Amount Sell</strong></td>
				</tr>
				
				<?php foreach ($model as $row){?>
					<tr>
						<td><?php echo $row->stk_cd?></td>
						<td><?php echo $row->status?></td>
						<td style="text-align: right;"><?php echo number_format($row->lot_size)?></td>
						<td style="text-align: right;"><?php echo number_format($row->qty)?></td>
						<td style="text-align: right;"><?php echo number_format($row->price)?></td>
						<td style="width: 5%"></td>
						<td style="text-align: right; width: 16%"><?php echo number_format($row->b_val)?></td>
						<td style="width: 5%"></td>
						<td style="text-align: right; width: 16%"><?php echo number_format($row->j_val)?></td>
					</tr>
				<?php }?>
				<tr style="background: #ededed;">
					<td colspan="5">Total Value</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_val)?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_val)?></td>
				</tr>
				<tr>
					<td colspan="5">Commission <?php echo $model[0]->brok_perc/100?>%</td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_comm)?></td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_comm)?></td>
				</tr>
				<tr>
					<td colspan="5">VAT</td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_vat)?></td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_vat)?></td>
				</tr>
				<tr>
					<td colspan="5">Levy</td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_levy)?></td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_levy)?></td>
				</tr>
				<?php if ($model[0]->sum_j_pph != 0){?>
				<tr>
					<td colspan="5">Sales Tax <?php echo $model[0]->pph_perc/100?>%</td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_pph)?></td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_pph)?></td>
				</tr>
				<?php }?>
				<?php if (($model[0]->sum_b_whpph23 != 0) || ($model[0]->sum_j_whpph23 != 0)){?>
				<tr>
					<td colspan="5">Witholding Tax PPh 23 <?php echo $model[0]->whpph23_perc?>%</td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_whpph23)?></td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_whpph23)?></td>
				</tr>
				<?php }?>
				<tr style="background: #ededed;">
					<td colspan="5">Total Net</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_amt)?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_amt)?></td>
				</tr>
				<?php if ($model[0]->sum_b_amt > $model[0]->sum_j_amt){?>
				<tr style="border-bottom: solid 1px;">
					<td colspan="5">Debt</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_b_amt - $model[0]->sum_j_amt)?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo '0'?></td>
				</tr>	
				<?php }else{?>
				<tr style="border-bottom: solid 1px;">
					<td colspan="5">Credit</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo '0'?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo number_format($model[0]->sum_j_amt - $model[0]->sum_b_amt)?></td>
				</tr>
				<?php }?>
				<?php if (($model[0]->sum_b_t3 + $model[0]->sum_j_t3) > 0){?>
				<tr>
					<td colspan="5">Settlement Date T+<?php echo $model[0]->max_3plus;?>&emsp;<?php echo DateTime::createFromFormat('Y-m-d h:i:s',$model[0]->due_t3)->format('d/m/Y')?> (<?php echo substr($model[0]->mrkt_t3,0,2)?>)</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_b_t3 > $model[0]->sum_j_t3)?number_format($model[0]->sum_b_t3 - $model[0]->sum_j_t3) : '0' ?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_j_t3 > $model[0]->sum_b_t3)?number_format($model[0]->sum_j_t3 - $model[0]->sum_b_t3) : '0' ?></td>
				</tr>
				<?php }?>
				<?php if (($model[0]->sum_b_t2 + $model[0]->sum_j_t2) > 0){?>
				<tr>
					<td colspan="5">Settlement Date T+2&emsp;<?php echo DateTime::createFromFormat('Y-m-d h:i:s',$model[0]->due_t2)->format('d/m/Y')?> (<?php echo substr($model[0]->mrkt_t2,0,2)?>)</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_b_t2 > $model[0]->sum_j_t2)?number_format($model[0]->sum_b_t2 - $model[0]->sum_j_t2) : '0' ?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_j_t2 > $model[0]->sum_b_t2)?number_format($model[0]->sum_j_t2 - $model[0]->sum_b_t2) : '0' ?></td>
				</tr>
				<?php }?>
				<?php if (($model[0]->sum_b_t1 + $model[0]->sum_j_t1) > 0){?>
				<tr>
					<td colspan="5">Settlement Date T+1&emsp;<?php echo DateTime::createFromFormat('Y-m-d h:i:s',$model[0]->due_t1)->format('d/m/Y')?> (<?php echo substr($model[0]->mrkt_t1,0,2)?>)</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_b_t1 > $model[0]->sum_j_t1)?number_format($model[0]->sum_b_t1 - $model[0]->sum_j_t1) : '0' ?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_j_t1 > $model[0]->sum_b_t1)?number_format($model[0]->sum_j_t1 - $model[0]->sum_b_t1) : '0' ?></td>
				</tr>
				<?php }?>
				<?php if (($model[0]->sum_b_t0 + $model[0]->sum_j_t0) > 0){?>
				<tr>
					<td colspan="5">Settlement Date T+0&emsp;<?php echo DateTime::createFromFormat('Y-m-d h:i:s',$model[0]->contr_dt)->format('d/m/Y')?> (<?php echo substr($model[0]->mrkt_t0,0,2)?>)</td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_b_t0 > $model[0]->sum_j_t0)?number_format($model[0]->sum_b_t0 - $model[0]->sum_j_t0) : '0' ?></td>
					<td style="text-align: right;">Rp</td>
					<td style="text-align: right;"><?php echo ($model[0]->sum_j_t0 > $model[0]->sum_b_t0)?number_format($model[0]->sum_j_t0 - $model[0]->sum_b_t0) : '0' ?></td>
				</tr>
				<?php }?>
				<tr style="border-top: solid 1px;"><td colspan="9"></td></tr>
				
			</table>
	</div>
	<div>
			Any discrepancy should be reported within 1 (one) business day after the above transaction date,<br />
			or we will consider the above information correct. Thank you for your attention.<br />
			<br />
			Especially for customer's account at <?php echo $model[0]->bank_rdi;?> :<br />
			* The latest payment of buying transaction from customer on
			<?php echo (($model[0]->sum_b_t3 + $model[0]->sum_j_t3) > 0)?'T+3 ('.substr($model[0]->mrkt_t3,0,2).')' : '';?>
			<?php echo (($model[0]->sum_b_t2 + $model[0]->sum_j_t2) > 0)?'T+2 ('.substr($model[0]->mrkt_t2,0,2).')' : '';?>
			<?php echo (($model[0]->sum_b_t1 + $model[0]->sum_j_t1) > 0)?'T+1 ('.substr($model[0]->mrkt_t1,0,2).')' : '';?>
			<?php echo (($model[0]->sum_b_t0 + $model[0]->sum_j_t0) > 0)?'T+0 ('.substr($model[0]->mrkt_t0,0,2).')' : '';?>
			at 11.30 am (in good fund)<br />
			* The latest payment of selling transaction to customer on
			<?php echo (($model[0]->sum_b_t3 + $model[0]->sum_j_t3) > 0)?'T+3 ('.substr($model[0]->mrkt_t3,0,2).')' : '';?>
			<?php echo (($model[0]->sum_b_t2 + $model[0]->sum_j_t2) > 0)?'T+2 ('.substr($model[0]->mrkt_t2,0,2).')' : '';?>
			<?php echo (($model[0]->sum_b_t1 + $model[0]->sum_j_t1) > 0)?'T+1 ('.substr($model[0]->mrkt_t1,0,2).')' : '';?>
			<?php echo (($model[0]->sum_b_t0 + $model[0]->sum_j_t0) > 0)?'T+0 ('.substr($model[0]->mrkt_t0,0,2).')' : '';?>
			at 5 pm
	</div>
	<div style="clear: both; "><br /></div>
	<div>
		<div style="text-align: center; float: left; width: 55%;">
			<?php if($model[0]->bank_rdi_acct){?>
				<?php if($model[0]->sum_b_amt > $model[0]->sum_j_amt){?>
						<font style="text-decoration: underline;">Please transfer the fund to Investor Account (in good fund at 11:30 AM) :</font><br />	
				<?php }?>
				<?php if($model[0]->sum_j_amt > $model[0]->sum_b_amt){?>
						<font style="text-decoration: underline;">We will transfer to your Investor Account :</font><br />
				<?php }?>
				<?php echo $model[0]->rdi_name;?><br />
				<?php echo $model[0]->bank_rdi;?> : <?php echo $model[0]->bank_rdi_acct;?>
			<?php }else{?>
				<font style="text-decoration: underline;">The following is our payment bank details :</font><br />
				<?php echo $model[0]->nama_prsh;?><br />
				<?php echo $model[0]->bank_name;?> A/C : <?php echo $model[0]->brch_acct_num;?>
			<?php }?>
		</div>
		<div style="text-align: center; float: right; width: 45%;">
			<?php if($model[0]->bank_rdi_acct){?>	
				<?php if($model[0]->sum_j_amt > $model[0]->sum_b_amt){?>
						<font style="text-decoration: underline;">Your Bank Account :</font><br />
						<?php echo $model[0]->client_bank_name;?><br />
						<?php echo $model[0]->client_bank;?> A/C : <?php echo $model[0]->client_bank_acct;?>
				<?php }?>
			<?php }?>
		</div>
	</div>
	<div style="clear: both; "><br /></div>
	<div>
		<div style="float: left; width: 60%;">
			Equity Sales,<br />
			<?php echo $model[0]->rem_name;?><br />
			<br /><br />
			NPWP : <?php echo $model[0]->no_ijin1;?><br />
			PKP &emsp;: <?php echo $model[0]->no_ijin1;?><br /><br />
			This is a computer generated advise. No signature is required.
		</div>
		<div style="float: right; width: 40%;">
			Confirmed by,<br />
			<?php echo $model[0]->nama_prsh;?>
		</div>
	</div>
	<div style="clear: both; "><br /></div>
<?php }else{?>
	<h1>Data Not Found!</h1>
<?php }?>