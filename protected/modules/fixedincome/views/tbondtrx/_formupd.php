<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tbond-trx-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php foreach($model1 as $m1){
		echo $form->errorSummary($m1);
	}?>
	<?php
		if($modeloutsdone){ 
			foreach($modeloutsdone as $m2){
			echo $form->errorSummary($m2);
		}
	}?>
	<div style="display: none">
		<?php echo $form->radioButtonListInLineRow($model, 'trx_type', array('B'=>'Buy', 'S'=>'Sell'),array('label'=>false,'id'=>'trxtype','readonly'=>'readonly')); ?>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<label class="control-label required">&nbsp;</label>
			<?php echo $form->radioButtonListInLineRow($model, 'trx_type', array('B'=>'Buy', 'S'=>'Sell'),array('label'=>false,'id'=>'trxtype','disabled'=>'disabled','name'=>'trxtype')); ?>
		</div>
		
		<div class="span6">
			<?php echo $form->textFieldRow($model,'trx_ref',array('class'=>'span5','maxlength'=>50,'style'=>'text-transform:uppercase')); ?>
			
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'trx_id',array('class'=>'span5 tnumber','maxlength'=>5,'id'=>'trxid','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'ctp_num',array('class'=>'span5','maxlength'=>10)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'trx_date',array('id'=>'trxdate','readonly'=>'readonly','prepend'=>'<i class="icon-calendar"></i>',
					'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'value_dt',array('id'=>'valuedt','readonly'=>'readonly','prepend'=>'<i class="icon-calendar"></i>',
					'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8')); ?>
		</div>
	</div>
	<!--
	<div style="display:none;">
		<div class="span6">
			<?php //echo $form->datePickerRow($model,'trx_date',array('id'=>'trxdate','prepend'=>'<i class="icon-calendar"></i>',
					//'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','readonly'=>'readonly','options'=>array('format' => 'dd/mm/yyyy',))); ?>
		</div>
		<div class="span6">
			<?php //echo $form->datePickerRow($model,'value_dt',array('id'=>'valuedt','prepend'=>'<i class="icon-calendar"></i>',
					//'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','readonly'=>'readonly','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
	-->
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->dropDownListRow($model,'custodian_cd',Chtml::listData(Bankcustody::model()->findAll("cbest_cd in ('BCA01','BMAN1','KSEI7','GANE1') and 
					approved_sts = 'A' order by cbest_cd"),'cbest_cd', 'CustodianCdAndName'), array('class'=>'span7')); ?>
		</div>
	</div>
	<div class="row-fluid">
		
		<div class="span6">
			<?php echo $form->textFieldRow($model,'settlement_instr',array('class'=>'span3','maxlength'=>5,'id'=>'settlementinstr','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'trx_id_yymm',array('class'=>'span5','maxlength'=>9,'id'=>'trxidyymm')); ?>
		</div>
		
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php //echo $form->radioButtonListInLineRow($model, 'lawan_type', array('B'=>'Bank','S'=>'Broker','I'=>'Internal','R'=>'Reksadana',
					//'C'=>'Custodian','O'=>'Others'),array('id'=>'lawantype')); ?>
			<?php echo $form->dropDownListRow($model,'lawan_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1='LAWAN'"),'prm_cd_2', 'prm_desc'),
					array('prompt'=>'--Choose Type--','class'=>'span5','id'=>'lawantype')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->dropDownListRow($model,'lawan',array(), array('class'=>'span7','id'=>'lawancd','prompt'=>'--Choose Counterpart--')); ?>
		</div>
	</div>
	<!--
	<div class="row-fluid">
		<div class="span12">
			<?php //echo $form->dropDownListRow($model,'purchased_bond',array('--Choose Purchased Bond--'),array('class'=>'span8','id'=>'purchasebond'));?>
		</div>
	</div>
	-->
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->dropDownListRow($model,'bond_cd',Chtml::listData(Bond::model()->findAll("approved_sts <> 'C' AND bond_cd = '$model->bond_cd' order by bond_cd"),
					'bond_cd', 'BondDesc'), array('class'=>'span8','id'=>'bondcd','disabled'=>'disabled','prompt'=>'--Choose Bond--')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'maturity_date',array('id'=>'maturity','readonly'=>'readonly','prepend'=>'<i class="icon-calendar"></i>',
					'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'last_coupon',array('id'=>'couponfrom','readonly'=>'readonly','prepend'=>'<i class="icon-calendar"></i>',
					'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'next_coupon',array('id'=>'couponto','readonly'=>'readonly','prepend'=>'<i class="icon-calendar"></i>',
					'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'int_rate',array('style'=>'text-align:right;','id'=>'couponrate','class'=>'span5 tnumber')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
			<?php echo $form->label($model,'nominal',array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textField($model,'nominal',array('style'=>'text-align:right;','id'=>'nominal','class'=>'span5 tnumber')); ?>
					&emsp;
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'id'=>'mbtn',
						'label'=>'M',
					)); ?>
				</div>
			</div>	
		</div>
		<div class="span6">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
			'id'=>'outsbtn',
			'label'=>'Show List of Outstanding Buy',
			'htmlOptions'=>array('disabled'=>'disabled')
		)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'price',array('style'=>'text-align:right;','id'=>'price','class'=>'span5 tnumber')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'cost',array('style'=>'text-align:right;','id'=>'cost','class'=>'span5 tnumber',
					'readonly'=>'readonly')); ?>
		</div>
	</div>
	<?php if ($modeloutsdone){?>
	<div id="outsdone" class="row-fluid">
		<h4>List of Sold Outstanding Buy</h4>
		<table id="table-outsdone" class="items table table-striped table-bordered table-condensed" style="width: auto;">
			<thead>
				<tr id="rowhead">
					<th>Transaction Date</th>
					<th>ID</th>
					<th>BUY From</th>
					<th>Total Nominal</th>
					<th>Dijual</th>
					<th>Sisa Nominal</th>
					<th>Price</th>
					<th>Reference</th>
				</tr>
			</thead>
		<?php 
			$z = 0;
			foreach($modeloutsdone as $dataouts){?>
			<tr>
				<td><?php echo DateTime::createFromFormat('Y-m-d',$dataouts->trx_date)->format('d/m/Y');?></td>
				<td style="text-align: right;"><?php echo $dataouts->trx_id;?></td>
				<td><?php echo $dataouts->lawan;?></td>
				<td style="text-align: right;"><?php echo number_format(($modelbondbuy[$z]->nominal + $dataouts->sisa_temp),0);?></td>
				<td style="text-align: right;"><?php echo number_format($modelbondbuy[$z]->nominal,0);?></td>
				<td style="text-align: right;"><?php echo number_format($dataouts->sisa_temp,0);?></td>
				<td style="text-align: right;"><?php echo $dataouts->price;?></td>
				<td><?php echo $dataouts->trx_ref;?></td>
			</tr>
		<?php 
			$z++;			 
		}?>
		</table>
	</div>
	<?php }?>
	<div id="dialog" title="List of Outstanding Buy" class="row-fluid" style="display: none; background: #dde9ff;">
	  <table id="table-sellbond" class="items table table-striped table-bordered table-condensed">
	  	<thead>
			<tr id="rowhead\">
				<th>Trx Date</th>
				<th>ID</th>
				<th>BUY From</th>
				<th>&emsp;</th>
				<th>Jual</th>
				<th>Price</th>
				<th>Trx Ref</th>
			</tr>
		</thead>
		<?php if($modeloutsdone){
			$z = 0;
			$totalnominal = 0;
			$totalnominalxprice = 0;
			foreach($modeloutsdone as $dataouts){?>
			<tr>
				<td id="strxdate<?php echo $z;?>"><?php echo DateTime::createFromFormat('Y-m-d',$dataouts->trx_date)->format('d/m/Y');?></td>
					<input type="hidden" id="svaluedt<?php echo $z;?>" value="<?php echo DateTime::createFromFormat('Y-m-d',$dataouts->value_dt)->format('d/m/Y');?>" />
				<td style="text-align: right;"><?php echo $dataouts->trx_id;?></td>
				<td><?php echo $dataouts->lawan;?></td>
				<td style="text-align: center;"><input type="checkbox" value="<?php echo DateTime::createFromFormat('Y-m-d',$dataouts->trx_date)->format('d/m/Y').'-'.$dataouts->trx_seq_no.'#'.$z;?>" 
					name="chkbond" id="chkbond" checked=true onchange="checkBond();"/></td>
				<td style="text-align: center;"><input style="text-align: right;" type="text" onchange="checkBond();" name="sisa_temp<?php echo $z;?>" 
				id="sisa_temp<?php echo $z;?>" value="<?php echo number_format($modelbondbuy[$z]->nominal,0);?>" class="tnumber span12" /><input type="hidden" name="sisa_nominal<?php echo $z;?>"
				id="sisa_nominal<?php echo $z;?>" value="<?php echo number_format($modelbondbuy[$z]->nominal,0);?>" class="tnumber span12" /></td>
				<td id="buyprice<?php echo $z;?>" style="text-align: right;"><?php echo $dataouts->price;?></td>
				<td><?php echo $dataouts->trx_ref;?></td>
			</tr>
		<?php 
			
			$totalnominal = $totalnominal + $modelbondbuy[$z]->nominal;
			$totalnominalxprice = $totalnominalxprice + ($modelbondbuy[$z]->nominal * $dataouts->price);
			$z++;
			}
			$avgprice = $totalnominalxprice / $totalnominal;
			if($modelsell){
				foreach($modelsell as $sell){
			?>
			<tr>
				<td id="strxdate<?php echo $z;?>"><?php echo DateTime::createFromFormat('Y-m-d',$sell->trx_date)->format('d/m/Y');?></td>
					<input type="hidden" id="svaluedt<?php echo $z;?>" value="<?php echo DateTime::createFromFormat('Y-m-d',$sell->value_dt)->format('d/m/Y');?>" />
				<td style="text-align: right;"><?php echo $sell->trx_id;?></td>
				<td><?php echo $sell->lawan;?></td>
				<td style="text-align: center;"><input type="checkbox" value="<?php echo DateTime::createFromFormat('Y-m-d',$sell->trx_date)->format('d/m/Y').'-'.$sell->trx_seq_no.'#'.$z;?>" 
					name="chkbond" id="chkbond" onchange="checkBond();"/></td>
				<td style="text-align: center;"><input readonly="readonly" style="text-align: right;" type="text" onchange="checkBond();" name="sisa_temp<?php echo $z;?>" 
				id="sisa_temp<?php echo $z;?>" value="<?php echo number_format($sell->sisa_temp,0);?>" class="tnumber span12" /><input type="hidden" name="sisa_nominal<?php echo $z;?>"
				id="sisa_nominal<?php echo $z;?>" value="<?php echo number_format($sell->sisa_nominal,0);?>" class="tnumber span12" /></td>
				<td id="buyprice<?php echo $z;?>" style="text-align: right;"><?php echo $sell->price;?></td>
				<td><?php echo $sell->trx_ref;?></td>
			</tr>
			<?php 
				$z++;
				}?>
			<tr id="rowavg">
				<td colspan="2">&emsp;</td>
				<td colspan="2" style="text-align: right;"><strong>Total Nominal</strong></td>
				<td style="text-align: center;"><input style="text-align: right;" readonly="readonly" type="text" name="totalnominal" id="totalnominal" value=<?php echo number_format($totalnominal,0)?> class="tnumber span12" /></td>
				<td style="text-align: right;"><strong>Average Price</strong></td>
				<td style="text-align: center;"><input style="text-align: right;" readonly="readonly" type="text" name="averageprice" id="averageprice" value=<?php echo number_format($avgprice,2)?> class="tnumber span12" /></td>
			</tr>
		<?php 
				}
			}?>
	  </table>
	</div>
	
	<h4>Accrued Interest</h4>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
			<?php echo $form->label($model,'Days / Rounding',array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textField($model,'accrued_days',array('style'=>'text-align:right;','id'=>'accrueddays','maxlength'=>5,'class'=>'span2 tnumber','readonly'=>'readonly')); ?>
					&nbsp;/&nbsp;
					<?php echo $form->textField($model,'accrued_int_round',array('style'=>'text-align:right;','id'=>'accruedintround','class'=>'span3 tnumber')); ?>
				</div>
			</div>	
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12" style="text-align: right;">
			<strong style="font-size: 14px">+</strong>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'calc_accrued_int',array('style'=>'text-align:right;','id'=>'calcaccruedint',
					'class'=>'span5 tnumber','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'accrued_int',array('style'=>'text-align:right;','id'=>'accruedint','class'=>'span5 tnumber',
					'readonly'=>'readonly')); ?>
		</div>
	</div>
	
	<h4>Accrued Interest Tax</h4>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
			<?php echo $form->label($model,'Days / Rounding',array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textField($model,'accrued_tax_days',array('style'=>'text-align:right;','id'=>'accruedtaxdays','class'=>'span2 tnumber','maxlength'=>5,'readonly'=>'readonly')); ?>
					&nbsp;/&nbsp;
					<?php echo $form->textField($model,'accrued_tax_round',array('style'=>'text-align:right;','id'=>'accruedtaxround','class'=>'span3 tnumber')); ?>
				</div>
			</div>	
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12" style="text-align: right;">
			<strong style="font-size: 16px">-</strong>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'calc_interest',array('style'=>'text-align:right;','id'=>'calcinterest',
					'class'=>'span5 tnumber','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($model,'accrued_tax_pcn',array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textField($model,'accrued_tax_pcn',array('style'=>'text-align:right;','id'=>'accruedtaxpcn','class'=>'span2')); ?>
					%
					<?php echo $form->textField($model,'accrued_int_tax',array('style'=>'text-align:right;','id'=>'accruedinttax',
							'class'=>'span5 tnumber','readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12" style="text-align: right;">
			<strong style="font-size: 16px">-</strong>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'capital_gain',array('style'=>'text-align:right;','id'=>'capitalgain','class'=>'span5 tnumber',
					'readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($model,'capital_tax_pcn',array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textField($model,'capital_tax_pcn',array('style'=>'text-align:right;','id'=>'capitaltaxpcn','class'=>'span2')); ?>
					%
					<?php echo $form->textField($model,'capital_tax',array('style'=>'text-align:right;','id'=>'capitaltax','class'=>'span5 tnumber',
							'readonly'=>'readonly')); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<!--<div class="span4">
			<?php //echo $form->textFieldRow($model,'buy_price',array('style'=>'text-align:right;','id'=>'buyprice','class'=>'span4 tnumber',
					//'id'=>'buyprice')); ?>
		</div>-->
		<div class="span6">
			<div class="control-group">
				<label class="control-label">
					Multiple Purchase Price
				</label>
				<div class="controls">
					<?php echo $form->checkBox($model,'multi_buy_price',array('value'=>'Y','id'=>'ismulti','name'=>'ismulti','disabled'=>'disabled')) ?>
					<div style="display:none;"><?php echo $form->textField($model,'multi_buy_price')?></div>
					&emsp;
					<?php /*$this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'id'=>'multipricebtn',
						'label'=>'Input Multiple Purchase Price',
					)); */?>
				</div>
			</div>	
		</div>
	</div>
	<?php if (!$modelmultiprice){?>
	
	<div class="row-fluid" id="purchases">
		<div class="span4">
			<?php echo $form->textFieldRow($model,'buy_price',array('style'=>'text-align:right;','id'=>'buyprice','class'=>'span4 tnumber',
					'id'=>'buyprice')); ?>
		</div>
		<div class="span4">
			<div class="control-group">
				<label class="control-label required" style="width:50px;" for="buy_dt">
					Date
				</label>
				<div class="controls">
					<?php echo $form->datePickerRow($model,'seller_buy_dt',array('id'=>'sellerbuydt','prepend'=>'<i class="icon-calendar"></i>',
					'placeholder'=>'dd/mm/yyyy','class'=>'tdate span7','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
				</div>
			</div>
		</div>
	</div>
	<?php }else{
		  $count = 1;?>
	<h5>Multiple Purchase Price</h5>
	<div id="dialog2" class="row-fluid" style="width: 60%;">
	  <table id="tableMultiprice" class="items table table-striped table-bordered table-condensed">
	  	<thead>
		  	<tr>
		  		<th>Nominal</th>
		  		<th>Purchase Price</th>
		  		<th>Purchase Date</th>
		  	</tr>
		</thead>
		<tbody>
			<?php
				foreach($modelmultiprice as $row){?>
					<tr id="row<?php echo $count;?>">
				  		<td><?php echo number_format($row->nominal,0);?>
				  			<input type="hidden" id="multinominal<?php echo $count;?>" name="Multiprice[<?php echo $count;?>][nominal]" value="<?php echo number_format($row->nominal,0);?>" />
				  		</td>
				  		<td><?php echo $row->buy_price;?>
				  			<input type="hidden" id="multiprice<?php echo $count;?>" name="Multiprice[<?php echo $count;?>][buyprice]" value="<?php echo $row->buy_price;?>" />
				  		</td>
				  		<td><?php echo DateTime::createFromFormat('Y-m-d',$row->buy_dt)->format('d/m/Y');?>
				  			<input type="hidden" id="multisellerbuydt<?php echo $count;?>" name="Multiprice[<?php echo $count;?>][sellerbuydt]" value="<?php echo DateTime::createFromFormat('Y-m-d',$row->buy_dt)->format('d/m/Y');?>" />
				  		</td>
				  	</tr>
				  	
				<?php $count++;}?>
		</tbody>
	  </table>
	</div>
	<?php }?>
	
	<div class="row-fluid">
		<div class="span12" style="text-align: right;">
			<strong style="font-size: 14px">=</strong>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'net_capital_gain',array('style'=>'text-align:right;','id'=>'netcapitalgain',
					'class'=>'span5 tnumber','readonly'=>'readonly')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'net_amount',array('style'=>'text-align:right;','id'=>'netamount','class'=>'span5 tnumber',
					'readonly'=>'readonly')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'ctp_trx_type',Chtml::listData(Parameter::model()->findAll("approved_stat <> 'C' AND 
					prm_cd_1 = 'CTPTRX' order by prm_cd_2"),'prm_cd_2', 'ParameterDesc'), array('class'=>'span8')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'report_type',array('class'=>'span3','readonly'=>'readonly','id'=>'reporttype')); ?>
		</div>
		
	</div>	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'sign_by',Chtml::listData(Parameter::model()->findAll("approved_stat <> 'C' AND 
					prm_cd_1 = 'SIGNBY'"),'prm_cd_2', 'ParameterDesc'), array('class'=>'span8','id'=>'signby')); ?>
		</div>
		<div class="span6" style="display:none;">
			<div class="control-group">
				<label class="control-label">Edit Calculation</label>
				<div class="controls"><input type="checkbox" value="Y" id="editcalc" name="editcalc" /></div>
			</div>
		</div>
	</div>	
	
	<div class="hidden">
		<?php echo $form->textFieldRow($model,'buy_trx_seq',array('id'=>'buytrxseq','class'=>'span5 tnumber','maxlength'=>4)); ?>
		
		<?php echo $form->datePickerRow($model,'buy_value_dt',array('id'=>'buyvaluedt','prepend'=>'<i class="icon-calendar"></i>',
				'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		
		<?php echo $form->datePickerRow($model,'buy_dt',array('id'=>'buydt','prepend'=>'<i class="icon-calendar"></i>',
				'placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		
		<?php echo $form->textFieldRow($model,'net_amount',array('style'=>'text-align:right;','id'=>'oldnetamount','class'=>'span5 tnumber',
					'readonly'=>'readonly','name'=>'oldnetamount')); ?>
	</div>
	
	<input type="hidden" id="checkedbond" name="checkedbond" />
	<input type="hidden" id="checkedsisa" name="checkedsisa" />
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
			'id'=>'calcbtn',
			'label'=>'Calc',
		)); ?>
		&emsp;&emsp;&emsp;
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
			'id'=>'savebtn',
			'label'=>$model->isNewRecord ? 'Save' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<table id="hiddentabledata" style="display: none;"></table>
<script>
	<?php
		if($modeloutsdone){
	?>
			$("#dialog").dialog({modal: false, width:'auto'});
			$("#dialog").show();
			registerFormatField('.tdate','.tnumber');
			registerFormatField('.tdetaildate','.tdetailnumber');
	<?php }?>
	var iseditcalc = 0;	
	var ignorevaluedt = 0;
	
	$("#editcalc").change(function(){
		if ($(this).prop('checked')){
			iseditcalc = 1;
			$("#cost").attr('readonly',false);
			$("#calcaccruedint").attr('readonly',false);
			$("#accruedint").attr('readonly',false);
			$("#calcinterest").attr('readonly',false);
			$("#capitalgain").attr('readonly',false);
			$("#netcapitalgain").attr('readonly',false);
			$("#accruedinttax").attr('readonly',false);
			$("#capitaltax").attr('readonly',false);
			$("#netamount").attr('readonly',false);
			$("#accrueddays").attr('readonly',false);
			$("#accruedtaxdays").attr('readonly',false);
			$("#calcbtn").attr('disabled','disabled');
			
		}else{
			iseditcalc = 0;
			$("#cost").attr('readonly','readonly');
			$("#calcaccruedint").attr('readonly','readonly');
			$("#accruedint").attr('readonly','readonly');
			$("#calcinterest").attr('readonly','readonly');
			$("#capitalgain").attr('readonly','readonly');
			$("#netcapitalgain").attr('readonly','readonly');
			$("#accruedinttax").attr('readonly','readonly');
			$("#capitaltax").attr('readonly','readonly');
			$("#netamount").attr('readonly','readonly');
			$("#accrueddays").attr('readonly','readonly');
			$("#accruedtaxdays").attr('readonly','readonly');
			$("#calcbtn").attr('disabled',false);
		}
	});
	<?php if ($model->trx_type == 'S'){?>
		checkBond();
	<?php }?>
	
	function roundDown(a){
		var num = a;
	    var str = num.toString();
	    var decindex = str.indexOf('.');
	    if(decindex && decindex > 0)
	    	var temp = str.substring(0, decindex);
	    else
	    	var temp = str;
	    return Number(temp);
	}
	
	function checkBond(){ //function for checkboxlist in popup
		var h = '';
		var g = 0;
		var paramsisa = '';
		var totalnominal = 0;
		var totalnominalxprice = 0;
		$('input[name="chkbond"]').serialize();
		$('input[name="chkbond"]').each(function(){
			var startp = this.value.indexOf("#");
			//alert(startp);
			g = this.value.substr(startp+1,3);
			g = $.trim(g);
			if($(this).prop('checked') == false){
				$("#sisa_temp"+g).val($("#sisa_nominal"+g).val());
				$("#sisa_temp"+g).attr('readonly','readonly');
			}else{
				$("#sisa_temp"+g).attr('readonly',false);
			}
		});
		$('input[name="chkbond"]:checked').serialize();
		var top = 1;
		/*
		$('input[name="chkbond"]:checked').each(function(){
			h = h+this.value+' ';
			g = this.value.substr(-1,1);
			paramsisa = paramsisa + $("#sisa_temp"+g).val() + ' ';
			var strxdateval = $("#strxdate"+g).html();
			var svaluedtval = $("#svaluedt"+g).val();
			if(top == 1){
				$("#buydt").val(strxdateval);
				$("#sellerbuydt").val(svaluedtval);
				top = 0;
			}
			var checkednominal = $("#sisa_temp"+g).val();
			var checkedprice = $("#buyprice"+g).html();
			var parsednominal = parseInt(checkednominal.replace(/\,/g, ''));
			var parsedprice = parseFloat(checkedprice);
			totalnominal = totalnominal + parsednominal;
			totalnominalxprice = totalnominalxprice + (parsednominal * parsedprice);
		});
		var avgprice = totalnominalxprice / totalnominal;
		if((totalnominal == 0) && (totalnominalxprice) == 0){
			var averageprice = 0;
		}else{
			var averageprice = roundDown(avgprice*10000)/10000;
		}
		*/
		$('input[name="chkbond"]:checked').each(function(){
			h = h+this.value+' ';
			var startp = this.value.indexOf("#");
			//alert(startp);
			g = this.value.substr(startp+1,3);
			g = $.trim(g);
			paramsisa = paramsisa + $("#sisa_temp"+g).val() + ' ';
			var strxdateval = $("#strxdate"+g).html();
			var svaluedtval = $("#svaluedt"+g).val();
			if(top == 1){
				$("#buydt").val(strxdateval);
				$("#sellerbuydt").val(svaluedtval);
				top = 0;
			}
			var checkednominal = $("#sisa_temp"+g).val();
			var checkedprice = $("#buyprice"+g).html();
			var parsednominal = parseInt(checkednominal.replace(/\,/g, ''));
			var dotindex = checkedprice.indexOf('.')+1;
			if(dotindex > 0){
				var dec = checkedprice.substring(dotindex, checkedprice.length);
				var ndec = dec.length;
				
				var parsedprice = parseInt(checkedprice.replace('.',''));
				
				totalnominal = totalnominal + parsednominal;
				totalnominalxprice = totalnominalxprice + (parsednominal * parsedprice / (Math.pow(10,ndec)));
			}else{
				totalnominal = totalnominal + parsednominal;
				totalnominalxprice = totalnominalxprice + (parsednominal * checkedprice);
			}
			//alert(totalnominalxprice);
		});
		var avgprice = totalnominalxprice / totalnominal;
		//alert(avgprice);
		if((totalnominal == 0) && (totalnominalxprice) == 0){
			var averageprice = 0;
		}else{
			var averageprice = (roundDown(avgprice.toFixed(6)*1000000))/1000000;
		}
		h = $.trim(h);
		paramsisa = $.trim(paramsisa);
		$("#checkedsisa").val(paramsisa);
		$("#checkedbond").val(h);
		$("#totalnominal").val(setting.func.number.addCommas(totalnominal));
		$("#nominal").val(setting.func.number.addCommas(totalnominal));
		if(averageprice){
			$("#averageprice").val(averageprice);
			$("#buyprice").val(averageprice);
		}else{
			$("#averageprice").val(0);
			$("#buyprice").val(0);
		}
		//alert('sisa = '+paramsisa);
		calculateValues();
	}
	
	<?php /*if($model->trx_type == 'B'){
		if($model->sisa_nominal < $model->nominal){?>
			//$("#price").attr('readonly','readonly');
	<?php	
		}
	}*/?>

	$("#trxtype").ready(function(){
		<?php if (empty($model->trx_type)){?>
			$('#Tbondtrx_trx_type_0').attr('checked','checked');
			$('#settlementinstr').val('RVP');
		<?php } if ($model->trx_type == 'S'){?>
			$('#settlementinstr').val('DVP');
			$('#outsbtn').attr('disabled',false);
			$('#mbtn').attr('disabled','disabled');
			$('#nominal').attr('readonly','readonly');
		<?php }?>
	});
	/*
	$("#trxtype").change(function(){
		var trxtypeval = $("#trxtype input[type='radio']:checked").val();
		if (trxtypeval == 'B'){
			$('#settlementinstr').val('RVP');
			$('#table-sellbond').empty();
			$('#outsbtn').attr('disabled','disabled');
			$('#mbtn').attr('disabled',false);
			$(".ui-dialog-titlebar-close").click();
		}else{
			$('#settlementinstr').val('DVP');
			$('#outsbtn').attr('disabled',false);
			$('#mbtn').attr('disabled','disabled');
		}
		if (trxtypeval == 'S'){
			$('#nominal').attr('readonly','readonly');
		}else{
			$('#nominal').attr('readonly',false);
		}
		var bondcdval = $("#bondcd option:selected").val();
		var trxdateval = $("#trxdate").val();
		var valuedtval = $("#valuedt").val();
		//$("#purchasebond").val('');
		$("#table-sellbond").empty();
		if(bondcdval && trxdateval && valuedtval){
			getBond(bondcdval);
		}else{
			//getPurchaseBond();
		}
		calculateValues();
		
	});
	*/
	<?php if ($model->lawan_type){?>
		var lawantypeval = "<?php echo $model->lawan_type;?>";
		filterLawan(lawantypeval);
	<?php }?>
	
	$("#lawantype").change(function(){
		var lawantypeval = $("#lawantype :checked").val();
		filterLawan(lawantypeval);
		calculateValues();
	});
	
	function filterLawan(lawantypeval){ // function for filtering counterpart
		/*
		if (lawantypeval == 'B' || lawantypeval == 'S'){
			$("#reporttype").val('TWO');
		}else{
			$("#reporttype").val('ONE');
		}*/
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxFilterCounterpart'); ?>',
			'dataType' : 'json',
			'data'     : {'lawantypeval' : lawantypeval},
			'success'  : function(data){
				var txtLawan  = '<option value="">--Choose Counterpart--</option>';
				var dataLawan = data.content;
				$.each(dataLawan.lawan, function(i, item) {
					if(dataLawan.lawan[i] != ''){
					    txtLawan  += '<option value="'+dataLawan.lawan[i]+'">'+dataLawan.lawan[i]+' - '+dataLawan.lawan_name[i]+'</option>';
					}
				});
				
				$('#lawancd').html(txtLawan);
				<?php if($model->lawan_type){?>
					$("#lawancd").val("<?php echo $model->lawan;?>");
				<?php }?>
			}
		});
		
	}
	/*
	$('#trxid').change(function(){
		getPurchaseBond();
	})*/
	
	function getPurchaseBond(){		// AS: Show list of outstanding buy on document ready
		var trxidval = $("#trxid").val();
		var trxtypeval = $("#trxtype input[type='radio']:checked").val();
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxPurchaseBond'); ?>',
			'dataType' : 'json',
			'data'     : {'trxidval' : trxidval, 'trxtypeval' : trxtypeval},
			'success'  : function(data){
				var dataSell = data.content_sell;
				$('#trxdate').val(data.trxdate);
				$('#buydt').val(data.trxdate);
				$('#valuedt').val(data.valuedt);
				$('#buyvaluedt').val(data.valuedt);
				//$('#sellerbuydt').val(data.valuedt);
				$('#trxidyymm').val(data.trxidyymm);
				$('#bondcd').val(data.bondcd);
				$('#maturity').val(data.maturitydate);
				$('#couponfrom').val(data.lastcoupon);
				$('#couponto').val(data.nextcoupon);
				$("#couponrate").val(data.interestrate);
				if((data.avaluedt == data.nextcoupon) && data.avaluedt && data.nextcoupon){
					alert('Value Date and Coupon Period To must be different!');
					$('#valuedt').val('');
				}

				if(dataSell){
					$("#table-sellbond").empty();
					$("#table-sellbond").append(
						"<thead>"+
						"<tr id=\"rowhead\">"+
							"<th>Trx Date</th>"+
							"<th>ID</th>"+
							"<th>BUY From</th>"+
							"<th>&emsp;</th>"+
							"<th>Jual</th>"+
							"<th>Price</th>"+
							"<th>Trx Ref</th>"+
						"</tr>"+
						"</thead>");
					//alert(data.content_sell.length);
					var temptrxseqno = '';
					var temptrxdate = '';
					$.each(dataSell.trx_id, function(i, item) {
						if(dataSell.trx_date[i] != ''){
							if((temptrxdate == '') || (temptrxdate != dataSell.trx_date[i])){
								$("#table-sellbond").append(
									"<tr id=\"row"+i+"\">"+
										"<td id=\"strxdate"+i+"\">"+dataSell.trx_date[i]+"</td>"+"<input type=\"hidden\" id=\"svaluedt"+i+"\" value=\""+dataSell.value_dt[i]+"\" />"+
										"<td style=\"text-align: right;\">"+dataSell.trx_id[i]+"</td>"+
										"<td>"+dataSell.lawan[i]+"</td>"+
										"<td style=\"text-align: center;\"><input type=\"checkbox\" value=\""+dataSell.trx_date[i]+"-"+
												dataSell.trx_seq_no[i]+"#"+i+"\" name=\"chkbond\" id=\"chkbond\" onchange=\"checkBond();\"/></td>"+
										"<td style=\"text-align: center;\"><input readonly=\"readonly\" style=\"text-align: right;\" type=\"text\" onchange=\"checkBond();\" name=\"sisa_temp"+
												i+"\" id=\"sisa_temp"+i+"\" value=\""+dataSell.sisa_temp[i]+"\" class=\"tnumber span12\" /><input type=\"hidden\" name=\"sisa_nominal"+
												i+"\" id=\"sisa_nominal"+i+"\" value=\""+dataSell.sisa_nominal[i]+"\" class=\"tnumber span12\" /></td>"+
										"<td id=\"buyprice"+i+"\" style=\"text-align: right;\">"+dataSell.price[i]+"</td>"+
										"<td>"+dataSell.trx_ref[i]+"</td>"+
									"</tr>");
								temptrxseqno = dataSell.trx_seq_no[i];
								temptrxdate = dataSell.trx_date;
							}else{
								if((temptrxseqno == '') || (temptrxseqno != dataSell.trx_seq_no[i])){
									$("#table-sellbond").append(
										"<tr id=\"row"+i+"\">"+
											"<td id=\"strxdate"+i+"\">"+dataSell.trx_date[i]+"</td>"+"<input type=\"hidden\" id=\"svaluedt"+i+"\" value=\""+dataSell.value_dt[i]+"\" />"+
											"<td style=\"text-align: right;\">"+dataSell.trx_id[i]+"</td>"+
											"<td>"+dataSell.lawan[i]+"</td>"+
											"<td style=\"text-align: center;\"><input type=\"checkbox\" value=\""+dataSell.trx_date[i]+"-"+
													dataSell.trx_seq_no[i]+"#"+i+"\" name=\"chkbond\" id=\"chkbond\" onchange=\"checkBond();\"/></td>"+
											"<td style=\"text-align: center;\"><input readonly=\"readonly\" style=\"text-align: right;\" type=\"text\" onchange=\"checkBond();\" name=\"sisa_temp"+
													i+"\" id=\"sisa_temp"+i+"\" value=\""+dataSell.sisa_temp[i]+"\" class=\"tnumber span12\" /><input type=\"hidden\" name=\"sisa_nominal"+
													i+"\" id=\"sisa_nominal"+i+"\" value=\""+dataSell.sisa_nominal[i]+"\" class=\"tnumber span12\" /></td>"+
											"<td id=\"buyprice"+i+"\" style=\"text-align: right;\">"+dataSell.price[i]+"</td>"+
											"<td>"+dataSell.trx_ref[i]+"</td>"+
										"</tr>");
									temptrxseqno = dataSell.trx_seq_no[i];
								}
								temptrxdate = dataSell.trx_date;
							}
						}
					});
					$("#table-sellbond").append(
					"<tr id=\"rowavg\">"+
						"<td colspan=\"2\">&emsp;</td>"+
						"<td colspan=\"2\" style=\"text-align: right;\"><strong>Total Nominal</strong></td>"+
						"<td style=\"text-align: center;\"><input style=\"text-align: right;\" readonly=\"readonly\" type=\"text\" name=\"totalnominal\" id=\"totalnominal\" value=0 class=\"tnumber span12\" /></td>"+
						"<td style=\"text-align: right;\"><strong>Average Price</strong></td>"+
						"<td style=\"text-align: center;\"><input style=\"text-align: right;\" readonly=\"readonly\" type=\"text\" name=\"averageprice\" id=\"averageprice\" value=0 class=\"tnumber span12\" /></td>"+
					"</tr>");
					if(dataSell.trx_date[1]){
						$("#dialog").dialog({modal: false, width:'auto'});
						$("#dialog").show();
					}else{
						$(".ui-dialog-titlebar-close").click();
					}
					registerFormatField('.tdate','.tnumber');
					registerFormatField('.tdetaildate','.tdetailnumber'); 
				}else{
					$(".ui-dialog-titlebar-close").click();
				}
			}
		});
	}
	/*
	$("#purchasebond").change(function(){
		var purchasebondtxt = $(this.options[this.selectedIndex]).html();
		var purchasebondval = $(this.options[this.selectedIndex]).val();
		var trxtypeval = $("#trxtype input[type='radio']:checked").val();
		var rownum = purchasebondval.substring(0,1);
		var htrxdate = $("#htrxdate"+rownum).html();
		var hbondcd = $("#hbondcd"+rownum).html();
		var htrxseqno = $("#htrxseqno"+rownum).html();
		var hvaluedt = $("#hvaluedt"+rownum).html();
		var hprice = $("#hprice"+rownum).html();
		var hnominal = $("#hnominal"+rownum).html();
		$("#bondcd").val(hbondcd);
		$("#buytrxseq").val(htrxseqno);
		$("#buyvaluedt").val(hvaluedt);
		$("#sellerbuydt").val(hvaluedt);
		if(trxtypeval == 'S'){
			$("#buyprice").val(setting.func.number.addCommas(hprice));
			$("#buydt").val(htrxdate);	
		}
		$("#nominal").val(hnominal);
		$("#table-sellbond").empty();
		getBond(hbondcd);
		calculateValues();
	});
	*/
	
	/*
	$("#buydt").change(function(){
		var trxtypeval = $("#trxtype input[type='radio']:checked").val();
		var buydtval = $("#buydt").val();
		if(trxtypeval == 'B'){
			$("#sellerbuydt").val(buydtval);
		}
		calculateValues();
	});
	*/
	$("#bondcd").change(function(){
		var bondcdval = $(this.options[this.selectedIndex]).val();
		//$("#purchasebond").val('');
		$("#table-sellbond").empty();
		getBond(bondcdval);
		calculateValues();
	});
	
	$("#trxdate").change(function(){
		var bondcdval = $("#bondcd option:selected").val();
		var valuedtval = $("#valuedt").val();
		//$("#purchasebond").val('');
		
		if(bondcdval && valuedtval){
			$("#table-sellbond").empty();
			getBond(bondcdval);
		}
		$("#buydt").val($("#trxdate").val());
		$("#buydt").datepicker();
		trxdtvalsplit = $("#trxdate").val().split("/");
		//$('#buydt').datepicker({defaultDate : new Date(trxdtvalsplit[2], trxdtvalsplit[1] - 1, trxdtvalsplit[0])});
		$('#buydt').datepicker("setDate",new Date(trxdtvalsplit[2], trxdtvalsplit[1] - 1, trxdtvalsplit[0]));
		calculateValues();
	});
	
	$("#outsbtn").click(function(){
		var bondcdval = $("#bondcd option:selected").val();
		var valuedtval = $("#valuedt").val();
		
		if(bondcdval && valuedtval){
			if($("#averageprice").val()>0 || $("#buyprice0").html()){
				$("#dialog").dialog({modal: false, width:'auto'});
				$("#dialog").show();
			}else{
				$("#table-sellbond").empty();
				getBond(bondcdval);
			}
		}
	});
	
	function getBond(bondcdval){   // AS: Show list of outstanding buy
		var trxdateval = $("#trxdate").val();
		var valuedtval = $("#valuedt").val();
		//$("valuedt").datepicker({'dateFormat':'dd/mm/yyyy'});
		var typeval = $("#trxtype input[type='radio']:checked").val();
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxBond'); ?>',
			'dataType' : 'json',
			'data'     : {'bondcdval' : bondcdval, 'trxdateval' : trxdateval, 'typeval' : typeval, 'valuedtval' : valuedtval},
			'success'  : function(data){
				var dataBond = data.content;
				var dataSell = data.content_sell;
				if(dataBond.maturity_date != ''){
				    $("#maturity").val(dataBond.maturity_date);
				    $("#couponfrom").val(dataBond.period_from);
				    $("#couponto").val(dataBond.period_to);
				    $("#couponrate").val(dataBond.int_rate);
				}
				if((valuedtval == dataBond.period_to) && valuedtval && dataBond.period_to){
					alert('Value Date and Coupon Period To must be different!');
					$('#valuedt').val('');
				}
				if(dataSell){
					$("#buyvaluedt").val(valuedtval);
					$("#table-sellbond").empty();
					$("#table-sellbond").append(
						"<thead>"+
						"<tr id=\"rowhead\">"+
							"<th>Trx Date</th>"+
							"<th>ID</th>"+
							"<th>BUY From</th>"+
							"<th>&emsp;</th>"+
							"<th>Jual</th>"+
							"<th>Price</th>"+
							"<th>Trx Ref</th>"+
						"</tr>"+
						"</thead>");
					var temptrxseqno = '';
					var temptrxdate = '';
					$.each(dataSell.trx_id, function(i, item) {
						if(dataSell.trx_date[i] != ''){
							if((temptrxdate == '') || (temptrxdate != dataSell.trx_date[i])){
								$("#table-sellbond").append(
									"<tr id=\"row"+i+"\">"+
										"<td id=\"strxdate"+i+"\">"+dataSell.trx_date[i]+"</td>"+"<input type=\"hidden\" id=\"svaluedt"+i+"\" value=\""+dataSell.value_dt[i]+"\" />"+
										"<td style=\"text-align: right;\">"+dataSell.trx_id[i]+"</td>"+
										"<td>"+dataSell.lawan[i]+"</td>"+
										"<td style=\"text-align: center;\"><input type=\"checkbox\" value=\""+dataSell.trx_date[i]+"-"+
												dataSell.trx_seq_no[i]+"#"+i+"\" name=\"chkbond\" id=\"chkbond\" onchange=\"checkBond();\"/></td>"+
										"<td style=\"text-align: center;\"><input readonly=\"readonly\" style=\"text-align: right;\" type=\"text\" onchange=\"checkBond();\" name=\"sisa_temp"+
												i+"\" id=\"sisa_temp"+i+"\" value=\""+dataSell.sisa_temp[i]+"\" class=\"tnumber span12\" /><input type=\"hidden\" name=\"sisa_nominal"+
												i+"\" id=\"sisa_nominal"+i+"\" value=\""+dataSell.sisa_nominal[i]+"\" class=\"tnumber span12\" /></td>"+
										"<td id=\"buyprice"+i+"\" style=\"text-align: right;\">"+dataSell.price[i]+"</td>"+
										"<td>"+dataSell.trx_ref[i]+"</td>"+
									"</tr>");
								temptrxseqno = dataSell.trx_seq_no[i];
								temptrxdate = dataSell.trx_date;
							}else{
								if((temptrxseqno == '') || (temptrxseqno != dataSell.trx_seq_no[i])){
									$("#table-sellbond").append(
										"<tr id=\"row"+i+"\">"+
											"<td id=\"strxdate"+i+"\">"+dataSell.trx_date[i]+"</td>"+"<input type=\"hidden\" id=\"svaluedt"+i+"\" value=\""+dataSell.value_dt[i]+"\" />"+
											"<td style=\"text-align: right;\">"+dataSell.trx_id[i]+"</td>"+
											"<td>"+dataSell.lawan[i]+"</td>"+
											"<td style=\"text-align: center;\"><input type=\"checkbox\" value=\""+dataSell.trx_date[i]+"-"+
													dataSell.trx_seq_no[i]+"#"+i+"\" name=\"chkbond\" id=\"chkbond\" onchange=\"checkBond();\"/></td>"+
											"<td style=\"text-align: center;\"><input readonly=\"readonly\" style=\"text-align: right;\" type=\"text\" onchange=\"checkBond();\" name=\"sisa_temp"+
													i+"\" id=\"sisa_temp"+i+"\" value=\""+dataSell.sisa_temp[i]+"\" class=\"tnumber span12\" /><input type=\"hidden\" name=\"sisa_nominal"+
													i+"\" id=\"sisa_nominal"+i+"\" value=\""+dataSell.sisa_nominal[i]+"\" class=\"tnumber span12\" /></td>"+
											"<td id=\"buyprice"+i+"\" style=\"text-align: right;\">"+dataSell.price[i]+"</td>"+
											"<td>"+dataSell.trx_ref[i]+"</td>"+
										"</tr>");
									temptrxseqno = dataSell.trx_seq_no[i];
								}
								temptrxdate = dataSell.trx_date;
							}
						}
					});
					$("#table-sellbond").append(
					"<tr id=\"rowavg\">"+
						"<td colspan=\"2\">&emsp;</td>"+
						"<td colspan=\"2\" style=\"text-align: right;\"><strong>Total Nominal</strong></td>"+
						"<td style=\"text-align: center;\"><input style=\"text-align: right;\" readonly=\"readonly\" type=\"text\" name=\"totalnominal\" value=0 id=\"totalnominal\" class=\"tnumber span12\" /></td>"+
						"<td style=\"text-align: right;\"><strong>Average Price</strong></td>"+
						"<td style=\"text-align: center;\"><input style=\"text-align: right;\" readonly=\"readonly\" type=\"text\" name=\"averageprice\" value=0 id=\"averageprice\" class=\"tnumber span12\" /></td>"+
					"</tr>");
					
					if(dataSell.trx_date[1]){
						$("#dialog").dialog({modal: false, width:'auto'});
						$("#dialog").show();
					}else{
						$(".ui-dialog-titlebar-close").click();
					}
					registerFormatField('.tdate','.tnumber');
					registerFormatField('.tdetaildate','.tdetailnumber');
				}else{
					$("#table-sellbond").empty();
					$(".ui-dialog-titlebar-close").click();
				}
			}
		});
	}
	
	function getTaxPcn(trxtypeval){
		var lawantypeval = $("#lawantype :selected").val();
		var lawanval = $("#lawancd :selected").val();
		//var trxtypeval = $("#trxtype input[type='radio']:checked").val();
		var trxdateval = $("#trxdate").val();
		var trxidval = $("#trxid").val();
		var valuedtval = $("#valuedt").val();
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxTaxpcn'); ?>',
			'dataType' : 'json',
			'data'     : {'lawanval' : lawanval, 'lawantypeval' : lawantypeval, 'trxdateval' : trxdateval, 'trxidval' : trxidval},
			'success'  : function(data){
				var dataTaxpcn = data.content;
				if(trxtypeval == 'B'){					
					if(dataTaxpcn.accruedtaxpcn){
					    $("#accruedtaxpcn").val(dataTaxpcn.accruedtaxpcn);
					    $("#capitaltaxpcn").val(dataTaxpcn.capitaltaxpcn);
					}else{
						$("#accruedtaxpcn").val('0');
					    $("#capitaltaxpcn").val('0');
					}
					if(data.buyprice){
						$("#buyprice").val(data.buyprice);
						if(trxtypeval == 'B' && lawantypeval == 'I'){
							$("#sellerbuydt").val(valuedtval);
						}else{
							$("#sellerbuydt").val(strxdateval);
						}
					}else{
						$("#buyprice").val('0');
						$("#sellerbuydt").val('');
					}
				}else{
					$("#accruedtaxpcn").val('15');
		    		$("#capitaltaxpcn").val('15');
				}
				if(dataTaxpcn.participant == 'Y'){
					$("#reporttype").val('TWO');
				}else{
					$("#reporttype").val('ONE');
				}
			}
		});
	}
	
	$("#lawancd").change(function(){
		
		var trxtypeval = $("#trxtype input[type='radio']:checked").val();
		var lawancdval = $("#lawancd :selected").val();
		var signbyval = $("#signby :selected").val();
		/*
		if (trxtypeval == 'B'){
			getTaxPcn(trxtypeval);
		}else{
			$("#accruedtaxpcn").val('15');
		    $("#capitaltaxpcn").val('15');
		}*/
		getTaxPcn(trxtypeval);
		if (lawancdval == signbyval){
			$("#signby").val('EF');
		}
	});
	
	$("#signby").change(function(){
		var lawancdval = $("#lawancd :selected").val();
		var signbyval = $("#signby :selected").val();
		
		if (lawancdval == signbyval){
			alert('Signed By must be different from Counterpart!');
			$("#signby").val('EF');
		}
	});
	
	$("#mbtn").click(function(){
		$("#mbtn").click(function(){
		var x = Math.round($("#nominal").val()*1000000000);
		$("#nominal").val(setting.func.number.addCommas(x));
	});
	});
	
	$("#calcbtn").click(function(){
		calculateValues();
		return false;
	});
	
	$("#price").change(function(){
		calculateValues();
	});
	/*
	$("#valuedt").change(function(){
		ignorevaluedt = 0;
		valuedt = $('#valuedt').val();
		couponto = $('#couponto').val();
		if(valuedt != couponto){
			$("#buyvaluedt").val($("#valuedt").val());
			//$("#sellerbuydt").val($("#valuedt").val());
			calculateValues();
		}else{
			alert('Value Date and Coupon Period To must be different!');
			$('#valuedt').val('');
		}
		bondcdval = $("#bondcd :selected").val();
		trxdateval = $("#trxdate").val();
		if(bondcdval && trxdateval){
			$("#table-sellbond").empty();
			getBond(bondcdval);
		}
			
	});
	*/
	
	$("#nominal").change(function(){
		calculateValues();
	});
	$("#couponfrom").change(function(){
		calculateValues();
	});
	$("#accruedintround").change(function(){
		calculateValues();
	});
	$("#accruedtaxpcn").change(function(){
		calculateValues();
	});
	$("#accruedtaxround").change(function(){
		calculateValues();
	});
	$("#capitaltaxpcn").change(function(){
		calculateValues();
	});
	$("#buytrxseq").change(function(){
		calculateValues();
	});
	$("#sellerbuydt").change(function(){
		calculateValues();
	});
	$("#buyvaluedt").change(function(){
		calculateValues();
	});
	$("#buyprice").change(function(){
		calculateValues();
	});
	
	function calculateValues(){
		if ($("#ismulti").prop('checked')){
			var outcost = 0;
			var outaccrueddays = 0;
			var outcalcaccruedint = 0;
			var outaccruedint = 0;
			var outaccruedtaxdays = 0;
			var outcalcinterest = 0;
			var outaccruedinttax = 0;
			var outcapitalgain = 0;
			var outcapitaltax = 0;
			var outnetcapitalgain = 0;
			var outnetamount = 0;
			
			for(r=1;r<=<?php echo sizeof($modelmultiprice)?>;r++){
				if(iseditcalc == 0){
					//alert('mulai');
					var trxtypeval = $("#trxtype input[type='radio']:checked").val();
					var coupontoval = $("#couponto").val();
					var trxdateval = $("#trxdate").val();
					var valuedtval = $("#valuedt").val();
					var trxtypeval = $("#trxtype :checked").val();
					var bondcdval = $("#bondcd :selected").val();
					var lawantypeval = $("#lawantype :selected").val();
					var nominalval = setting.func.number.removeCommas($("#multinominal"+r).val());
					var priceval = $("#price").val();
					var lastcouponval = $("#couponfrom").val();
					var accruedintroundval = $("#accruedintround").val();
					var accruedtaxpcnval = $("#accruedtaxpcn").val();
					var accruedtaxroundval = $("#accruedtaxround").val();
					var capitaltaxpcnval = $("#capitaltaxpcn").val();
					var buydtval = $("#buydt").val();
					var buyseqnoval = $("#buytrxseq").val();
					var sellerbuydtval = $("#multisellerbuydt"+r).val();
					var buyvaluedtval = $("#buyvaluedt").val();
					var avgpriceval = $("#averageprice").val();
					var buypriceval = $("#multiprice"+r).val();
					var parsedvaluedt = $.datepicker.parseDate('dd/mm/yy',valuedtval);
					var parsedcouponto = $.datepicker.parseDate('dd/mm/yy',coupontoval);
					var datediff = (parsedcouponto-parsedvaluedt)/1000/60/60/24;
					
					//if(trxtypeval == 'B') ignorevaluedt = 1;
					//alert(ignorevaluedt);
					if(ignorevaluedt == 0){
						if(valuedtval && coupontoval){
							//alert (a);
							
							if((datediff>=1)&&(datediff<=5)&&(ignorevaluedt==0)){
								$('<div></div>').appendTo('body')
							    .html('<div>Value date '+datediff+' hari sebelum next coupon. Continue?</div>')
							    .dialog({
							        modal: true,
							        zIndex: 10000,
							        autoOpen: true,
							        width: 400,
							        resizable: false,
							        buttons: {
							            Yes: function () {
											ignorevaluedt = 1;
							                $(this).dialog("close");
							            },
							            No: function () {
							            	ignorevaluedt = 0;
							                $(this).dialog("close");
							                
							            }
							        },
							        close: function (event, ui) {
							            $(this).remove();
							        }
							    });
							}else{
								ignorevaluedt = 1;
								calculateValues();
							}
						}
					
					}else{
						//alert(sellerbuydtval+'#'+buyvaluedtval);
						if(
							(trxdateval == '') ||
							(valuedtval == '') ||
							(bondcdval == '') ||
							(lawantypeval == null) ||
							(nominalval <= 0) ||
							(priceval <= 0) ||
							(lastcouponval == '') ||
							(buydtval == '') ||
							(buypriceval == '') ||
							(sellerbuydtval == '') ||
							(buyvaluedtval == '')
						){
							//not doing anything
						}else{
							$.ajax({
					    		'type'     :'POST',
					    		'url'      : '<?php echo $this->createUrl('ajxCalcBond'); ?>',
								'dataType' : 'json',
								'data'     : {'Tbondtrx[trx_date]' : trxdateval,
											  'Tbondtrx[value_dt]' : valuedtval,
											  'Tbondtrx[trx_type]' : trxtypeval,
											  'Tbondtrx[bond_cd]' : bondcdval,
											  'Tbondtrx[lawan_type]' : lawantypeval,
											  'Tbondtrx[nominal]' : nominalval,
											  'Tbondtrx[price]' : priceval,
											  'Tbondtrx[last_coupon]' : lastcouponval,
											  'Tbondtrx[accrued_int_round]' : accruedintroundval,
											  'Tbondtrx[accrued_tax_pcn]' : accruedtaxpcnval,
											  'Tbondtrx[accrued_tax_round]' : accruedtaxroundval,
											  'Tbondtrx[capital_tax_pcn]' : capitaltaxpcnval,
											  'Tbondtrx[buy_dt]' : buydtval,
											  'Tbondtrx[buy_seq_no]' : buyseqnoval,
											  'Tbondtrx[seller_buy_dt]' : sellerbuydtval,
											  'Tbondtrx[buy_value_dt]' : buyvaluedtval,
											  'Tbondtrx[buy_price]' : buypriceval
											},
								'success'  : function(data){
										var calcdata = data.content;
										//$("#cost").val(calcdata.cost);
										outcost += parseInt(setting.func.number.removeCommas(calcdata.cost));
										//$("#accrueddays").val(calcdata.accrued_days);
										outaccrueddays = parseInt(setting.func.number.removeCommas(calcdata.accrued_days));
										//$("#calcaccruedint").val(calcdata.calc_int);
										outcalcaccruedint += parseInt(setting.func.number.removeCommas(calcdata.calc_int));
										//$("#accruedint").val(calcdata.accrued_int);
										outaccruedint += parseInt(setting.func.number.removeCommas(calcdata.accrued_int));
										//$("#accruedtaxdays").val(calcdata.accrued_tax_days);
										outaccruedtaxdays += parseInt(setting.func.number.removeCommas(calcdata.accrued_tax_days));
										//$("#calcinterest").val(calcdata.calc_int_tax);
										outcalcinterest += parseInt(setting.func.number.removeCommas(calcdata.calc_int_tax));
										//$("#accruedinttax").val(calcdata.accrued_int_tax);
										outaccruedinttax += parseInt(setting.func.number.removeCommas(calcdata.accrued_int_tax));
										//$("#capitalgain").val(calcdata.capital_gain);
										outcapitalgain += parseInt(setting.func.number.removeCommas(calcdata.capital_gain));
										//$("#capitaltax").val(calcdata.capital_tax);
										outcapitaltax += parseInt(setting.func.number.removeCommas(calcdata.capital_tax));
										//$("#netcapitalgain").val(calcdata.net_capital_gain);
										outnetcapitalgain += parseInt(setting.func.number.removeCommas(calcdata.net_capital_gain));
										//$("#netamount").val(calcdata.net_amount);
										outnetamount += parseInt(setting.func.number.removeCommas(calcdata.net_amount));
										$("#cost").val(setting.func.number.addCommas(outcost));
										$("#accrueddays").val(setting.func.number.addCommas(outaccrueddays));
										$("#calcaccruedint").val(setting.func.number.addCommas(outcalcaccruedint));
										$("#accruedint").val(setting.func.number.addCommas(outaccruedint));
										$("#accruedtaxdays").val(setting.func.number.addCommas(outaccruedtaxdays));
										$("#calcinterest").val(setting.func.number.addCommas(outcalcinterest));
										$("#accruedinttax").val(setting.func.number.addCommas(outaccruedinttax));
										$("#capitalgain").val(setting.func.number.addCommas(outcapitalgain));
										$("#capitaltax").val(setting.func.number.addCommas(outcapitaltax));
										$("#netcapitalgain").val(setting.func.number.addCommas(outnetcapitalgain));
										$("#netamount").val(setting.func.number.addCommas(outnetamount));
								}
							});
						}
					}
				}
			}
			
		}else{
			if(iseditcalc == 0){
				//alert('mulai');
				var trxtypeval = $("#trxtype input[type='radio']:checked").val();
				var coupontoval = $("#couponto").val();
				var trxdateval = $("#trxdate").val();
				var valuedtval = $("#valuedt").val();
				var trxtypeval = $("#trxtype :checked").val();
				var bondcdval = $("#bondcd :selected").val();
				var lawantypeval = $("#lawantype :selected").val();
				var nominalval = $("#nominal").val();
				var priceval = $("#price").val();
				var lastcouponval = $("#couponfrom").val();
				var accruedintroundval = $("#accruedintround").val();
				var accruedtaxpcnval = $("#accruedtaxpcn").val();
				var accruedtaxroundval = $("#accruedtaxround").val();
				var capitaltaxpcnval = $("#capitaltaxpcn").val();
				var buydtval = $("#buydt").val();
				var buyseqnoval = $("#buytrxseq").val();
				var sellerbuydtval = $("#sellerbuydt").val();
				if(sellerbuydtval){
					sellerbuydtval = sellerbuydtval;
				}else{
					sellerbuydtval = $("#valuedt").val();
				}
				var buyvaluedtval = $("#buyvaluedt").val();
				//var buyvaluedtval = sellerbuydtval;
				var avgpriceval = $("#averageprice").val();
				/*
				var buypriceval = 0;
				if(avgpriceval && (trxtypeval == 'S')){
					buypriceval = avgpriceval;
				}else{
					buypriceval = $("#buyprice").val();
				}
				*/
				var buypriceval = $("#buyprice").val();
				var parsedvaluedt = $.datepicker.parseDate('dd/mm/yy',valuedtval);
				var parsedcouponto = $.datepicker.parseDate('dd/mm/yy',coupontoval);
				var datediff = (parsedcouponto-parsedvaluedt)/1000/60/60/24;
				
				//if(trxtypeval == 'B') ignorevaluedt = 1;
				//alert(ignorevaluedt);
				if(ignorevaluedt == 0){
					if(valuedtval && coupontoval){
						//alert (a);
						if((datediff>=1)&&(datediff<=5)&&(ignorevaluedt==0)){
							$('<div></div>').appendTo('body')
						    .html('<div>Value date '+datediff+' hari sebelum next coupon. Continue?</div>')
						    .dialog({
						        modal: true,
						        zIndex: 10000,
						        autoOpen: true,
						        width: 400,
						        resizable: false,
						        buttons: {
						            Yes: function () {
										ignorevaluedt = 1;
						                $(this).dialog("close");
						            },
						            No: function () {
						            	ignorevaluedt = 0;
						                $(this).dialog("close");
						                
						            }
						        },
						        close: function (event, ui) {
						            $(this).remove();
						        }
						    });
						}else{
							ignorevaluedt = 1;
							calculateValues();
						}
					}
				
				}else{
					//alert(sellerbuydtval+'#'+buyvaluedtval);
					if(
						(trxdateval == '') ||
						(valuedtval == '') ||
						(bondcdval == '') ||
						(lawantypeval == null) ||
						(nominalval <= 0) ||
						(priceval <= 0) ||
						(lastcouponval == '') ||
						(buydtval == '') ||
						(buypriceval == '') ||
						(sellerbuydtval == '') ||
						(buyvaluedtval == '')
					){
						//not doing anything
					}else{
						$.ajax({
				    		'type'     :'POST',
				    		'url'      : '<?php echo $this->createUrl('ajxCalcBond'); ?>',
							'dataType' : 'json',
							'data'     : {'Tbondtrx[trx_date]' : trxdateval,
										  'Tbondtrx[value_dt]' : valuedtval,
										  'Tbondtrx[trx_type]' : trxtypeval,
										  'Tbondtrx[bond_cd]' : bondcdval,
										  'Tbondtrx[lawan_type]' : lawantypeval,
										  'Tbondtrx[nominal]' : nominalval,
										  'Tbondtrx[price]' : priceval,
										  'Tbondtrx[last_coupon]' : lastcouponval,
										  'Tbondtrx[accrued_int_round]' : accruedintroundval,
										  'Tbondtrx[accrued_tax_pcn]' : accruedtaxpcnval,
										  'Tbondtrx[accrued_tax_round]' : accruedtaxroundval,
										  'Tbondtrx[capital_tax_pcn]' : capitaltaxpcnval,
										  'Tbondtrx[buy_dt]' : buydtval,
										  'Tbondtrx[buy_seq_no]' : buyseqnoval,
										  'Tbondtrx[seller_buy_dt]' : sellerbuydtval,
										  'Tbondtrx[buy_value_dt]' : buyvaluedtval,
										  'Tbondtrx[buy_price]' : buypriceval
										},
							'success'  : function(data){
									var calcdata = data.content;
									$("#cost").val(calcdata.cost);
									$("#accrueddays").val(calcdata.accrued_days);
									$("#calcaccruedint").val(calcdata.calc_int);
									$("#accruedint").val(calcdata.accrued_int);
									$("#accruedtaxdays").val(calcdata.accrued_tax_days);
									$("#calcinterest").val(calcdata.calc_int_tax);
									$("#accruedinttax").val(calcdata.accrued_int_tax);
									$("#capitalgain").val(calcdata.capital_gain);
									$("#capitaltax").val(calcdata.capital_tax);
									$("#netcapitalgain").val(calcdata.net_capital_gain);
									$("#netamount").val(calcdata.net_amount);
							}
						});
					}
				}
			}
		}
	}
	
	$("#savebtn").click(function(){
		var oldnetamountval = $("#oldnetamount").val();
		var netamountval = $("#netamount").val();
		//if(oldnetamountval != netamountval){
			//calculateValues();
			//alert('babibubebo');
		//}
		$("#tbond-trx-form").submit();
	});
</script>
