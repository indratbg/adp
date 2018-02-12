<table id='tableVch' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="3%"></th>
			<th width="27%">Journal Ref</th>
			<th width="13%">Voucher Type</th>
			<th width="10%">Date</th>
			<th width="8%">Vch Ref</th>
			<th width="12%">Amount</th>
			<th width="25%"></th>
			<?php if(!$model->isNewRecord): ?>
			<th width="2%">
				<a id="addVch" style="cursor:pointer" title="add" onclick="addRow2()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelVch as $row){ 
	?>
		<tr id="rowVch<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td>
				<?php if($row->old_doc_num != '-')echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Trepovch['.$x.'][save_flg]','onChange'=>'rowControl(this)')); ?>
				<?php if($row->old_doc_num && $row->old_doc_num != '-'): ?>
					<input type="hidden" name="Trepovch[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td>
				<?php if($row->old_doc_num != '-'){ ?>
				<select id="docNum<?php echo $x ?>" name="Trepovch[<?php echo $x ?>][doc_num]" class="span" onChange="assignVchDetail(<?php echo $x ?>)" <?php if($row->save_flg!='Y')echo 'disabled' ?>>
					<?php if($row->old_doc_num){ ?>
					<option value="<?php echo $row->old_doc_num ?>" class="old"  id="<?php echo $row->tal_id ?>"><?php echo $row->old_doc_num ?> - <?php echo $row->old_doc_ref_num ?></option>
					<?php } ?>
					<?php foreach($journalRef as $row1){ ?>
						<option value = "<?php echo $row1->payrec_num ?>" id="<?php echo $row1->tal_id ?>" <?php if($row1->payrec_num == $row->doc_num && $row1->doc_ref_num == $row->doc_ref_num){ ?> selected <?php } ?>>
							<?php echo $row1->payrec_num ?> - <?php echo $row1->doc_ref_num ?>
						</option>
					<?php } ?>
				</select>
				<?php }else{ ?>
					<?php echo $form->textField($row,'doc_num',array('class'=>'span','name'=>'Trepovch['.$x.'][doc_num]','readonly'=>'readonly')); ?>
				<?php } ?>
				
				<input type="hidden" name="Trepovch[<?php echo $x ?>][old_doc_num]" value="<?php echo $row->old_doc_num ?>"/>
				<input type="hidden" name="Trepovch[<?php echo $x ?>][old_doc_ref_num]" value="<?php echo $row->old_doc_ref_num ?>"/>
			</td>
			<td>
				<?php 
					switch($row->payrec_type)
					{
						case 'RD':
							$row->payrec_type = 'Receipt';
							break;
						case 'PD':
							$row->payrec_type = 'Payment';
							break;
						case 'RV':
							$row->payrec_type = 'Receipt to Settle';
							break;
						case 'PV':
							$row->payrec_type = 'Payment to Settle';
							break;
						default:
							$row->payrec_type = 'PB';
							break;
					}
				?>
				<?php echo $form->textField($row,'payrec_type',array('class'=>'span','name'=>'Trepovch['.$x.'][payrec_type]','readonly'=>'readonly', )); ?>
			</td>
			<td><?php echo $form->textField($row,'doc_dt',array('class'=>'span','name'=>'Trepovch['.$x.'][doc_dt]','readonly'=>'readonly')); ?></td>
			<td><?php echo $form->textField($row,'folder_cd',array('class'=>'span','name'=>'Trepovch['.$x.'][folder_cd]','readonly'=>'readonly')); ?></td>
			<td><?php echo $form->textField($row,'amt',array('class'=>'span tnumber','name'=>'Trepovch['.$x.'][amt]','onChange'=>'countTotal(this)','style'=>'text-align:right','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?></td>
			<td><?php echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Trepovch['.$x.'][remarks]','readonly'=>'readonly')); ?></td>
			<?php if(!$model->isNewRecord): ?>
			<td>
				<?php if($row->old_doc_num != '-') {?>
				<a 
					style="cursor:pointer"
					title="<?php if($row->old_doc_num) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_doc_num) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo "deleteRow2($x)"?>">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
				<?php } ?>
			</td>
			<?php endif; ?>
			<input type="hidden" class="docRefNum" name="Trepovch[<?php echo $x ?>][doc_ref_num]" value="<?php echo $row->doc_ref_num ?>"/>
			<input type="hidden" class="talId" name="Trepovch[<?php echo $x ?>][tal_id]" value="<?php echo $row->tal_id ?>"/>
		</tr>
	<?php $x++;} ?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>
				<input type="text" class="span tnumber" id="totalAmount" name="totalAmount" readonly="readonly" value="<?php foreach($modelVch as $row)$total+=$row->amt; echo $total?>" style="text-align:right"/>
			</td>
			<td></td>
		</tr>
	</tfoot>
</table>

<br class="temp"/>
	
	<?php if(!$model->isNewRecord): ?>
		<?php echo $form->label($model, 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
		<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
	<?php endif; ?>
	
<br class="temp"/><br class="temp"/>