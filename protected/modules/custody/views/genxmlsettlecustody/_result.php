<table id="tableDetail" class="tableDetailList table-bordered table-condensed">
	<thead>
		<tr>
			<th width="11%">Client</th>
			<th width="4%">B/J</th>
			<th width="7%">Stock</th>
			<th width="10%">Price</th>
			<th width="11%">Transaction Quantity</th>
			<th width="14%">Transaction Amount</th>
			<th width="2%">Sum</th>
			<th width="2%">Netg</th>
			<th width="11%">Transfer Quantity</th>
			<th width="14%">Transfer Amount</th>
			<th width="4%">Custodian</th>
			<th width="4%">Instruction</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$x=1;
			$prev_client_cd= '';
			$subTotal = 0;
			
			foreach($modelResult as $row)
			{				
				if($prev_client_cd && $prev_client_cd != $row->client_cd)
				{
		?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right">Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<input type="text" id="subTotal<?php echo $row->client_cd ?>" class="span tnumberdec" value="<?php echo $subTotal ?>" readonly />
			</td>
			<td></td>
			<td></td>
		</tr>
		<?php
					$subTotal = $row->trf_amt;
				}
				else 
				{
					$subTotal += $row->trf_amt;
				}
		?>
		<tr class="<?php echo $row->client_cd.' '.$row->stk_cd ?> ">
			<td class="client"><?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Detail['.$x.'][client_cd]','readonly'=>'readonly')) ?></td>
			<td class="belijual"><?php echo $form->textField($row,'beli_jual',array('class'=>'span','name'=>'Detail['.$x.'][beli_jual]','readonly'=>'readonly')) ?></td>
			<td class="stock"><?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Detail['.$x.'][stk_cd]','readonly'=>'readonly')) ?></td>
			<td class="price"><?php echo $form->textField($row,'price',array('class'=>'span tnumber','name'=>'Detail['.$x.'][price]','readonly'=>'readonly')) ?></td>
			<td class="qty"><?php echo $form->textField($row,'qty',array('class'=>'span tnumber','name'=>'Detail['.$x.'][qty]','readonly'=>'readonly')) ?></td>
			<td class="amount"><?php echo $form->textField($row,'trx_amt',array('class'=>'span tnumberdec','name'=>'Detail['.$x.'][trx_amt]','readonly'=>'readonly')) ?></td>
			<td class="sum" style="text-align:center"><?php echo $form->checkbox($row,'sum_flg',array('value'=>'Y','uncheckValue'=>'N','class'=>'span','name'=>'Detail['.$x.'][sum_flg]','onclick'=>'sum(this)')) ?></td>
			<td class="net" style="text-align:center"><?php echo $form->checkbox($row,'net_flg',array('value'=>'Y','uncheckValue'=>'N','class'=>'span','name'=>'Detail['.$x.'][net_flg]','onclick'=>'net(this)')) ?></td>
			<td class="trfQty"><?php echo $form->textField($row,'trf_qty',array('class'=>'span tnumber','name'=>'Detail['.$x.'][trf_qty]')) ?></td>
			<td class="trfAmount"><?php echo $form->textField($row,'trf_amt',array('class'=>'span tnumberdec','name'=>'Detail['.$x.'][trf_amt]')) ?></td>
			<td class="custodian"><?php echo $form->textField($row,'custodian_cd',array('class'=>'span','name'=>'Detail['.$x.'][custodian_cd]','readonly'=>'readonly')) ?></td>
			<td class="instruction"><?php echo $form->textField($row,'instruction_type',array('class'=>'span','name'=>'Detail['.$x.'][instruction_type]')) ?></td>
			<input type="hidden" name="Detail[<?php echo $x ?>][contr_num]" value="<?php echo $row->contr_num ?>" />
			<input type="hidden" name="Detail[<?php echo $x ?>][trading_ref]" value="<?php echo $row->trading_ref ?>" />
		</tr>
		<?php 
				$prev_client_cd = $row->client_cd;
				$x++;
			}
		?>
		
		<!-- LAST SUBTOTAL -->
		<?php 
			if(count($modelResult))
			{
		?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="text-align:right">Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<input type="text" id="subTotal<?php echo $row->client_cd ?>" class="span tnumberdec" value="<?php echo $subTotal ?>" readonly />
			</td>
			<td></td>
			<td></td>
		</tr>		
		<?php
			}
		?>
	</tbody>
</table>