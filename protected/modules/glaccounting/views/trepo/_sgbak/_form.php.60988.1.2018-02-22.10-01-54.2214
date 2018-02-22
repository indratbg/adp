<style>
	#tabMenu ul
	{
		border-top:2px solid #ddd;
		border-bottom:2px solid #ddd;
		border-left:2px solid #ddd;
		border-radius:5px;
	}	
	#tabMenu li
	{
		border-right:1px solid #ddd;
		border-radius:5px;
	}
	#tabMenu li:not(:first-child)
	{
		border-left:1px solid #ddd;
		border-radius:5px;
	}
	

	#tableHist, #tableVch
	{
		background-color:#C3D9FF;
	}
	#tableHist thead, #tableHist tbody, #tableVch thead, #tableVch tbody, #tableVch tfoot
	{
		display:block;
	}
	#tableHist tbody, #tableVch tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tableVch tfoot
	{
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
	
	input[type=checkbox]
	{
		margin-top:8px;
	}
</style>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'trepo-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	$total = 0;
	if($model->isNewRecord)
	{
		$new = 1;
		$oldModel = new Trepo;
		$journalRef = array();
		$s_gl_acct = '';
	}
	else {
		$new = 0;
		$oldModel = Trepo::model()->find("repo_num = '$model->repo_num'");
		$s_gl_acct = $oldModel->repo_type=='REVERSE'?'1415':'2415';
		//$journalRef = Vjournalrefvch::model()->findAll(array('condition'=>"payrec_date >= TRUNC(TO_DATE('$oldModel->repo_date','YYYY-MM-DD HH24:MI:SS')) AND gl_acct_cd = '$s_gl_acct' AND sl_acct_cd LIKE '$oldModel->client_cd%'",'order'=>'payrec_num'));
		//29sep2017 [indra] supaya lebih cepat
        $journalRef = Vjournalrefvch::model()->findAllBySql(Vjournalrefvch::getJournalRefVch($oldModel->repo_date, $s_gl_acct, $oldModel->client_cd));
	}

	$parameter = Parameter::model()->findAll("prm_cd_1 = 'SECUTY'"); 
?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
		foreach($modelHist as $row)
			echo $form->errorSummary(array($row)); 
	?>
	
	<?php 
		foreach($modelVch as $row)
			echo $form->errorSummary(array($row)); 
	?>

	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->dropDownListRow($model,'repo_type',array('REPO'=>'REPO','REVERSE'=>'REVERSE'),array('id'=>'repoType','disabled'=>$voucher?'disabled':'','class'=>'span7')); ?>
		</div>
		<div class="span7">
			<?php echo $form->label($model,'secu_type',array('class'=>'control-label')) ?>
			<select name="Trepo[secu_type]" id="secuType" <?php if($voucher)echo 'disabled' ?> style="width:240px">
				<?php foreach($parameter as $row){ ?>
				<option value = "<?php echo $row->prm_cd_2 ?>" <?php if($row->prm_cd_2 == 'EBE'){ ?> selected="selected" <?php } ?>>
					<?php echo $row->prm_desc ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span5">
		<?php echo $form->label($model,'client_cd',array('class'=>'control-label')) ?>
			
		<?php $this->widget('application.extensions.widget.JuiAutoCompleteStd', array(
								'model'=>$model,
								'attribute'=>'client_cd',
								'ajaxlink'=>array('getClientCd'),
								'htmlOptions'=>array('class'=>'span6','id'=>'clientCode','name'=>'Trepo[client_cd]','disabled'=>$voucher?'disabled':''),
						)); ?>
		</div>
		<div class="span7">
			<?php if($model->isNewRecord): ?>
				<?php echo $form->dropDownListRow($model,'client_type',array(AConstant::CLIENT_TYPE_INDIVIDUAL=>'INDIVIDUAL',AConstant::CLIENT_TYPE_INSTITUTIONAL=>'INSTITUTIONAL'),array('class'=>'span7', 'style'=>"width:240px")); ?>
			<?php else: ?>
				<?php echo $form->textFieldRow($model,'client_type',array('class'=>'span7', 'style'=>"width:240px",'disabled'=>'disabled','value'=>AConstant::$client_type[$model->client_type])); ?>
			<?php endif; ?>
		</div>
	</div>

	
	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->textFieldRow($model,'repo_ref',array('id'=>'repoRef','class'=>'span7','maxlength'=>30,'readonly'=>$perpanjangan||count($modelHist)>=2||$voucher?'readonly':'')); ?>
		</div>
		<div class="span5">
			<?php echo $form->label($model,'Tanggal'.CHtml::$afterRequiredLabel,array('for'=>'repoDate','class'=>'control-label')); ?>
			<?php echo $form->datePickerRow($model,'repo_date',array('id'=>'repoDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','label'=>false,'disabled'=>$perpanjangan||count($modelHist)>=2||$voucher?'disabled':'','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			<input type="hidden" id="repoDateHid" name="repoDateHid" />
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->textFieldRow($model,'extent_num',array('id'=>'extentNum','class'=>'span7','maxlength'=>30,'readonly'=>$perpanjangan||count($modelHist)<2||$voucher?'readonly':'')); ?>
		</div>
		<div class="span5">
			<?php echo $form->label($model,'Tanggal',array('for'=>'extentDate','class'=>'control-label')); ?>
			<?php echo $form->datePickerRow($model,'extent_dt',array('id'=>'extentDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','label'=>false,'disabled'=>$perpanjangan||count($modelHist)<2||$voucher?'disabled':'','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			<input type="hidden" id="extentDateHid" name="extentDateHid" />
		</div>
		<div class="span4" style="width:280px;margin-left:-120px">
			<div class="span4">
				<?php echo $form->label($model,'Jatuh Tempo'.CHtml::$afterRequiredLabel,array('for'=>'dueDate','class'=>'control-label')); ?>
			</div>
			<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span6','label'=>false,'disabled'=>$perpanjangan||$voucher?'disabled':'','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			<input type="hidden" id="dueDateHid" name="dueDateHid" />
		</div>
	</div>

	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->label($model,'Nilai Perjanjian'.CHtml::$afterRequiredLabel,array('for'=>'repoVal','class'=>'control-label')); ?>
			<?php echo $form->textFieldRow($model,'repo_val',array('id'=>'repoVal','class'=>'span7 tnumber','maxlength'=>'21','label'=>false,'style'=>'text-align:right','readonly'=>$perpanjangan||$voucher?'readonly':'')); ?>
		</div>
		<div class="span5">
			<?php echo $form->label($model,'Bunga %'.CHtml::$afterRequiredLabel,array('for'=>'feePer','class'=>'control-label')); ?>
			<?php echo $form->textFieldRow($model,'fee_per',array('id'=>'feePer','class'=>'span4','label'=>false,'maxlength'=>'9','style'=>'text-align:right','readonly'=>$perpanjangan||$voucher?'readonly':'')); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span5">
			<?php echo $form->textFieldRow($model,'return_val',array('id'=>'returnVal','class'=>'span7 tnumber','maxlength'=>'21','style'=>'text-align:right','readonly'=>$perpanjangan||$voucher?'readonly':'')); ?>
		</div>
		<div class="span5">
			<?php echo $form->label($model,'Penghentian Pengakuan',array('class'=>'control-label')); ?>
			<?php echo $form->checkBox($model,'penghentian_pengakuan',array('value'=>'Y','uncheckValue'=>'N')) ?>
		</div>
		<div class="span4" style="width:280px;margin-left:-120px">
			<div class="span4">
				<?php echo $form->label($model,'Serah Saham',array('class'=>'control-label')); ?>
			</div>
			<?php echo $form->checkBox($model,'serah_saham',array('value'=>'Y','uncheckValue'=>'N')) ?>
		</div>
	</div>
	
	<br/>
	
	<?php 
		if(!$model->isNewRecord)
		{
			$tabs;
	
			$tabs = array(
				array(
		                'label'   => 'Perpanjangan',
		                'content' =>  $this->renderPartial('_form_perpanjangan',array('model'=>$model,'modelHist'=>$modelHist,'perpanjangan'=>$perpanjangan,'voucher'=>$voucher,'form'=>$form),true),
		                'active'  => $voucher?false:true,
		                'itemOptions' => array('id'=>'btnPerpanjangan')
		            ),
	             array(
		                'label'   => 'Voucher',
		                'content' =>  $this->renderPartial('_form_voucher',array('model'=>$model,'modelVch'=>$modelVch,'journalRef'=>$journalRef,'total'=>$total,'voucher'=>$voucher,'cancel_reason'=>$cancel_reason,'form'=>$form),true,false),
		                'active'  => $voucher?true:false,
		                'itemOptions' => array('id'=>'btnVoucher')
		            ),
			);
	
			
			$this->widget(
			   'bootstrap.widgets.TbTabs',
			    array(
			        'type' => 'pills', // 'tabs' or 'pills'
			        'tabs' => $tabs,
			        'htmlOptions' => array('id'=>'tabMenu'),
			    )
			);
		}
		else 
			echo $this->renderPartial('_form_perpanjangan',array('model'=>$model,'modelHist'=>$modelHist,'perpanjangan'=>$perpanjangan,'voucher'=>$voucher,'form'=>$form),true); 
	?>
	
	<input type="hidden" id="perpanjanganFlg" name="perpanjanganFlg"/>
	<input type="hidden" id="perpanjanganCnt" name="perpanjanganCnt"/>
	<input type="hidden" id="voucherFlg" name="voucherFlg"/>
	<input type="hidden" id="voucherCnt" name="voucherCnt"/>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnSubmit',
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	var histCount = <?php echo count($modelHist) ?>;
	var vchCount = <?php echo count($modelVch) ?>;
	var authorizedCancel = true;
	var total = 0;
	var journalRef = [];
	var journalRefCnt = <?php echo count($journalRef) ?>;
	
	<?php if($perpanjangan){ ?>
		var perpanjangan = true;
		$("#tableHist tbody tr:eq("+(histCount-1)+") td:eq(0) input").datepicker({format : "dd/mm/yyyy"});
		$("#tableHist tbody tr:eq("+(histCount-1)+") td:eq(1) input").datepicker({format : "dd/mm/yyyy"});
	<?php }else{ ?>	
		var perpanjangan = false;
	<?php } ?>
	
	<?php if($voucher){ ?>	
		var voucher = true;
	<?php }else{ ?>	
		var voucher = false;
	<?php } ?>
	
	$('div#tabMenu').on('shown',function()
	{
		$(window).trigger('resize',[$("#tableHist")]);
		$(window).trigger('resize',[$("#tableVch")]);
	});	

	$("#btnPerpanjangan").click(function()
	{
		if(!$(this).hasClass('active'))
		{
			voucher = false;
			
			resetRepoHist();
			
			$("#repoType").prop('disabled',false);
			$("#clientCode").prop('disabled',false);
			$("#secuType").prop('disabled',false);
			enableRepo();
			
			/*setTimeout(
			  function() 
			  {
			    $(window).trigger('resize',[$("#tableHist")]);
			  }, 0350);*/
		}
	});
	
	$("#btnVoucher").click(function()
	{
		if(!$(this).hasClass('active'))
		{
			voucher = true;
			if(perpanjangan)
			{
				perpanjangan = false;
				$("#row"+histCount).remove();
				histCount--;
			}
			
			resetRepo();
	
			$("#repoType").prop('disabled',true);
			$("#clientCode").prop('disabled',true);
			$("#secuType").prop('disabled',true);
			disableRepo();
			
			/*setTimeout(
			  function() 
			  {
			    $(window).trigger('resize',[$("#tableVch")]);
			  }, 0350);*/
			
		}
	});
	
	$("#btnSubmit").click(function()
	{
		assignHiddenValue();
	});
	
	$(window).resize(function(event, obj=$("#btnPerpanjangan").hasClass('active')||$("#btnPerpanjangan").length==0?$("#tableHist"):$("#tableVch")) {
		var body = obj.find('tbody');
		if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
		{
			$('thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('thead').css('width', '100%');	
		}
		
		alignColumn(obj);
	})
	$(window).trigger('resize',[<?php if($voucher)echo '$("#tableVch")';else echo '$("#tableHist")'?>]);
	
	$(document).ready(function()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCancel'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedCancel = false;
				}
			}
		});
		
		/*----------BEGIN AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
		mapArray();
		
		for(x = 0;x < vchCount;x++)
		{
			filterJournalRef(x);
		}
		
		for(x = 0;x < vchCount;x++)
		{
			disableOption(x);
		}
		/*----------END AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
		
		cancel_reason();
		$("#feePer").change();
	});
	
	$(document).ajaxStop(function () {
      	$("#addVch").attr('onClick','addRow2()');
  	});
	
	function mapArray() //Map PHP array into Javascript array
	{
		var x = 0;
		journalRef = [];
		
		<?php foreach($journalRef as $row){ ?>
			journalRef[x] = [];
			journalRef[x]['payrec_num'] = '<?php echo $row->payrec_num ?>';
			journalRef[x]['doc_ref_num'] = '<?php echo $row->doc_ref_num ?>';
			journalRef[x]['tal_id'] = '<?php echo $row->tal_id ?>';
			x++;
		<?php } ?>
	}
	 
	function filterJournalRef(seq) //Filter the journalRef to exclude the already selected values
	{
		var doc_num, text, text2, doc_ref_num;
		
		doc_num = $('#docNum'+(seq+1));
		text = doc_num.children('option:selected').text();
		text2= text.substring(text.indexOf('-')+2);
		doc_ref_num = text2.trim();
		tal_id = doc_num.children('option:selected').attr('id');
		
		journalRef = $.grep(journalRef, function(value) {
			return value['payrec_num'] != doc_num.val() || value['doc_ref_num'] != doc_ref_num || value['tal_id'] != tal_id;
		});
	}
	
	function disableOption(seq) //Disable options that don't exist in journalRef
	{
		var disabled;
		
		$('#docNum'+(seq+1)).children('option:not(:selected)').not('.old').prop('disabled',true).css({'cursor':'not-allowed','background-color':'#CCCCCC'});
			
		$('#docNum'+(seq+1)).children('option:not(:selected)').not('.old').each(function()
		{
			doc_num = $(this).val();
			text = $(this).text();
			text2 = text.substring(text.indexOf('-')+2);
			doc_ref_num = text2.trim();
			tal_id = $(this).attr('id');
			
			disabled = true;
			
			$.each(journalRef,function(index, value)
			{
				if(!(doc_num != value['payrec_num'] || doc_ref_num != value['doc_ref_num'] || tal_id != value['tal_id']))
				{		
					disabled = false;
					return false;
				}		
			});
			
			if(!disabled)$(this).prop('disabled',false).css({'cursor':'pointer','background-color':'white'});
		}) ;
	}
	
	function alignColumn(obj)//align columns in thead and tbody
	{
		var header = obj.find('thead');
		var firstRow = obj.find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		
		if(obj.attr('id') == 'tableVch')
		{
			var footer = obj.find('tfoot');
			
			var footerCol1 = header.find('th:eq(0)').width() + header.find('th:eq(1)').width() + header.find('th:eq(2)').width() + header.find('th:eq(3)').width() + header.find('th:eq(4)').width();;
			var footerCol2 = header.find('th:eq(5)').width();
			var footerCol3 = header.find('th:eq(6)').width() + header.find('th:eq(7)').width();
			
			footer.find('td:eq(0)').css('width',footerCol1+44 + 'px');
			footer.find('td:eq(1)').css('width',footerCol2 + 'px');
			footer.find('td:eq(2)').css('width',footerCol3 + 'px');
		}
	}
	
	function addComma(obj)
	{
		$(obj).val(setting.func.number.addCommas(setting.func.number.removeCommas($(obj).val())));
	}
	
	function countTotal(obj)
	{
		var x;
		total = 0;
		for(x=0;x<vchCount;x++)
		{
			if($('[name = "Trepovch['+(x+1)+'][amt]"]').val() == '')$('[name = "Trepovch['+(x+1)+'][amt]"]').val(0);
			total += parseInt(setting.func.number.removeCommas($('[name = "Trepovch['+(x+1)+'][amt]"]').val()));
		}
		$("#totalAmount").val(setting.func.number.addCommas(total));
		
		addComma(obj);
	}
	
	function checkAddRow()
	{
		if(!perpanjangan)addRow();
	}
	
	function addRow()
	{
		$("#tableHist").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(histCount+1))
        		.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Trepohist['+(histCount+1)+'][repo_date]')
               		 	.attr('type','text')
               		 	.attr('onChange','assignBottomUp(1)')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
				).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Trepohist['+(histCount+1)+'][due_date]')
               		 	.attr('type','text')
               		 	.attr('onChange','assignBottomUp(2)')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Trepohist['+(histCount+1)+'][repo_ref]')
               		 	.attr('type','text')
               		 	.attr('onChange','assignBottomUp(3)')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Trepohist['+(histCount+1)+'][repo_val]')
               		 	.attr('type','text')
               		 	.attr('onChange','assignBottomUp(4)')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Trepohist['+(histCount+1)+'][return_val]')
               		 	.attr('type','text')
               		 	.attr('onChange','assignBottomUp(5)')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Trepohist['+(histCount+1)+'][interest_rate]')
               		 	.attr('type','text')
               		 	.attr('onChange','assignBottomUp(6)')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Trepohist['+(histCount+1)+'][interest_tax]')
               		 	.attr('type','text')
               		 	.attr('value',0)
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRow('+(histCount+1)+')')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		 	.css('cursor','pointer')
               		)
               	)  	
    		);
    		

    	
    	$("#extentNum").val('');
    	$("#extentDate").val('');
    	$("#dueDate").val('');
    	$("#repoVal").val('');
    	$("#returnVal").val('');
    	$("#feePer").val('');
    	
  		disableRepo();
    	
    	histCount++;
    	perpanjangan = true;
    	
    	$(window).trigger('resize',[$("#tableHist")]);
	}
	
	function addRow2()
	{
		var x = 1;
		
		if(/*journalRefCnt*/ journalRef.length) //Use 'journalRefCnt' to disable automatic journal ref filter
		{
			$("#tableVch").find('tbody')
	    		.prepend($('<tr>')
	    			.attr('id','rowVch0')
	    			.append($('<td>')
						.append($('<input>')
							.attr('name','Trepovch[0][save_flg]')
							.attr('type','checkbox')
							.attr('onChange','rowControl(this)')
							.prop('checked',true)
							.val('Y')
						)
					)
	        		.append($('<td>')
	               		 .append($('<select>')
	               		 	.attr('class','span')
	               		 	.attr('id','docNum0')
	               		 	.attr('name','Trepovch[0][doc_num]')
	               		 	.attr('onChange','assignVchDetail(0)')
	               		 	<?php
	               		 		foreach($journalRef as $row){
	               		 	?>
	           		 		.append($('<option>')
	           		 			.attr('id',<?php echo $row->tal_id ?>)
	           		 			.attr('value','<?php echo $row->payrec_num ?>')
	           		 			.html('<?php echo $row->payrec_num ?> - <?php echo $row->doc_ref_num ?>')
	           		 		)
	               		 	<?php } ?>
	               		)
					).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Trepovch[0][payrec_type]')
	               		 	.attr('type','text')
	               		 	.attr('readonly','readonly')
							.val('<?php 
									if($journalRef)
										switch($journalRef[0]->payrec_type)
										{
											case 'RD':
												echo 'Receipt';
												break;
											case 'PD':
												echo 'Payment';
												break;
											case 'RV':
												echo 'Receipt to Settle';
												break;
											case 'PV':
												echo 'Payment to Settle';
												break;
											default:
												echo 'PB';
												break;
										} 
								?>')
	               		)
	               	).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Trepovch[0][doc_dt]')
	               		 	.attr('type','text')
	               		 	.attr('readonly','readonly')
	               		 	.val('<?php if($journalRef)echo DateTime::createFromFormat('Y-m-d G:i:s',$journalRef[0]->payrec_date)->format('d/m/Y') ?>')
	               		)
	               	).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Trepovch[0][folder_cd]')
	               		 	.attr('type','text')
	               		 	.attr('readonly','readonly')
	               		 	.val('<?php if($journalRef)echo $journalRef[0]->folder_cd?>')
	               		)
	               	).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span tnumber')
	               		 	.attr('name','Trepovch[0][amt]')
	               		 	.attr('type','text')
	               		 	.attr('onChange','countTotal(this)')
	               		 	.css('text-align','right')
	               		 	.val(setting.func.number.addCommas(<?php if($journalRef)echo $journalRef[0]->payrec_amt?>))
	               		)
	               	).append($('<td>')
	               		 .append($('<input>')
	               		 	.attr('class','span')
	               		 	.attr('name','Trepovch[0][remarks]')
	               		 	.attr('type','text')
	               		 	.attr('readonly','readonly')
	               		 	.val('<?php if($journalRef)echo $journalRef[0]->remarks?>')
	               		)
	               	).append($('<td>')
	               		 .append($('<a>')
	               		 	.attr('onClick','deleteRow2(0)')
	               		 	.attr('title','delete')
	               		 	.append($('<img>')
	               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
	               		 	)
							.css('cursor','pointer')
	               		)
	               	).append($('<input>')
	               		.attr('type','hidden')
	               		.attr('class','docRefNum')
	               		.attr('name','Trepovch[0][doc_ref_num]')
	               		.val('<?php if($journalRef)echo $journalRef[0]->doc_ref_num?>')
	               	).append($('<input>')
	               		.attr('type','hidden')
	               		.attr('class','talId')
	               		.attr('name','Trepovch[0][tal_id]')
	               		.val('<?php if($journalRef)echo $journalRef[0]->tal_id?>') 
	               	) 	
	    		);
	    	
	    	total = parseInt(setting.func.number.removeCommas($("#totalAmount").val())) + <?php if($journalRef)echo $journalRef[0]->payrec_amt;else echo 0 ?>;
	    	$("#totalAmount").val(setting.func.number.addCommas(total));
	    	
	    	vchCount++;
	    	
	    	reassignId();
	    	
	    	/*----------BEGIN AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
	    	
	    	var disabled;
			
			$('#docNum1').children('option').prop('disabled',true);
			
			$('#docNum1').children('option').each(function()
			{
				doc_num = $(this).val();
				text = $(this).text();
				text2 = text.substring(text.indexOf('-')+2);
				doc_ref_num = text2.trim();
				tal_id = $(this).attr('id');
				
				disabled = true;
				
				$.each(journalRef,function(index, value)
				{
					if(!(doc_num != value['payrec_num'] || doc_ref_num != value['doc_ref_num'] || tal_id != value['tal_id']))
					{		
						disabled = false;
						return false;
					}		
				});
				
				if(!disabled)$(this).prop('disabled',false)
			}) ;
			
			$('#docNum1').children('option:not(:disabled):first').prop('selected',true).trigger('change');
			
			filterJournalRef(0);
			
			for(x = 0;x < vchCount;x++)
			{
				disableOption(x);
			}
			
			/*----------END AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
			    	
	    	$(window).trigger('resize',[$("#tableVch")]);
    	}
    	else
    		alert("No remaining vouchers available");
	}
	
	function deleteRow(rowSeq)
	{
		var x;
		$("#row"+rowSeq).remove();
		
		histCount--;
		perpanjangan = false;
		
		enableRepo();
		
		if(histCount <= 1)
		{
			$("#extentNum").val('');
    		$("#extentDate").val('');
    	}
    	else
    	{
    		assignBottomUp(3);
    		assignBottomUp(1);
    	}
    	
    	assignBottomUp(2);
    	assignBottomUp(4);
    	assignBottomUp(5);
    	assignBottomUp(6);
    	
    	$(window).trigger('resize',[$("#tableHist")]);
	}
	
	function deleteRow2(rowSeq)
	{
		var x;
		
		total = parseInt(setting.func.number.removeCommas($("#totalAmount").val())) - parseInt(setting.func.number.removeCommas($('[name = "Trepovch['+rowSeq+'][amt]"]').val()));
		
		$("#totalAmount").val(setting.func.number.addCommas(total));
		
		$("#rowVch"+rowSeq).remove();
		
		vchCount--;
		
		reassignId();
		
		/*----------BEGIN AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
		
		mapArray();
		
		for(x = 0;x < vchCount;x++)
		{
			filterJournalRef(x);
		}
		
		for(x = 0;x < vchCount;x++)
		{
			disableOption(x);
		}
		
		/*----------END AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
		
		$(window).trigger('resize',[$("#tableVch")]);
	}
	
	function rowControl(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableVch tbody tr:eq("+x+") td:eq(1) select").attr("disabled",!$(obj).is(':checked')?true:false);
		$("#tableVch tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(7) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function reassignId()
   	{
   		/*for(x=0;x<vchCount;x++)
   		{
			$("#tableVch tbody tr:eq("+x+")").attr("id","rowVch"+(x+1));
			$("#tableVch tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Trepovch["+(x+1)+"][save_flg]");
			$("#tableVch tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Trepovch["+(x+1)+"][save_flg]");
			$("#tableVch tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Trepovch["+(x+1)+"][cancel_flg]");
			$("#tableVch tbody tr:eq("+x+") td:eq(1) select").attr("id","docNum"+(x+1)).attr("name","Trepovch["+(x+1)+"][doc_num]").attr("onChange","assignVchDetail("+(x+1)+")");
			$("#tableVch tbody tr:eq("+x+") td:eq(1) [type=text]").attr("name","Trepovch["+(x+1)+"][doc_num]")
			$("#tableVch tbody tr:eq("+x+") td:eq(1) [type=hidden]:eq(0)").attr("name","Trepovch["+(x+1)+"][old_doc_num]");
			$("#tableVch tbody tr:eq("+x+") td:eq(1) [type=hidden]:eq(1)").attr("name","Trepovch["+(x+1)+"][old_doc_ref_num]");
			$("#tableVch tbody tr:eq("+x+") td:eq(2) [type=text]").attr("name","Trepovch["+(x+1)+"][payrec_type]");
			$("#tableVch tbody tr:eq("+x+") td:eq(3) [type=text]").attr("name","Trepovch["+(x+1)+"][doc_dt]");
			$("#tableVch tbody tr:eq("+x+") td:eq(4) [type=text]").attr("name","Trepovch["+(x+1)+"][folder_cd]");
			$("#tableVch tbody tr:eq("+x+") td:eq(5) [type=text]").attr("name","Trepovch["+(x+1)+"][amt]");
			$("#tableVch tbody tr:eq("+x+") td:eq(6) [type=text]").attr("name","Trepovch["+(x+1)+"][remarks]");
			$("#tableVch tbody tr:eq("+x+") .docRefNum").attr("name","Trepovch["+(x+1)+"][doc_ref_num]");
			$("#tableVch tbody tr:eq("+x+") .talId").attr("name","Trepovch["+(x+1)+"][tal_id]");
		}*/
		var x = 0;
		$("#tableVch").children('tbody').children('tr').each(function()
		{
			$(this).attr("id","rowVch"+(x+1));
			$(this).children("td:eq(0)").children("[type=checkbox]").attr("name","Trepovch["+(x+1)+"][save_flg]");
			$(this).children("td:eq(0)").children("[type=hidden]:eq(0)").attr("name","Trepovch["+(x+1)+"][save_flg]");
			$(this).children("td:eq(0)").children("[type=hidden]:eq(1)").attr("name","Trepovch["+(x+1)+"][cancel_flg]");
			$(this).children("td:eq(1)").children("select").attr("id","docNum"+(x+1)).attr("name","Trepovch["+(x+1)+"][doc_num]").attr("onChange","assignVchDetail("+(x+1)+")");
			$(this).children("td:eq(1)").children("[type=text]").attr("name","Trepovch["+(x+1)+"][doc_num]")
			$(this).children("td:eq(1)").children("[type=hidden]:eq(0)").attr("name","Trepovch["+(x+1)+"][old_doc_num]");
			$(this).children("td:eq(1)").children("[type=hidden]:eq(1)").attr("name","Trepovch["+(x+1)+"][old_doc_ref_num]");
			$(this).children("td:eq(2)").children("[type=text]").attr("name","Trepovch["+(x+1)+"][payrec_type]");
			$(this).children("td:eq(3)").children("[type=text]").attr("name","Trepovch["+(x+1)+"][doc_dt]");
			$(this).children("td:eq(4)").children("[type=text]").attr("name","Trepovch["+(x+1)+"][folder_cd]");
			$(this).children("td:eq(5)").children("[type=text]").attr("name","Trepovch["+(x+1)+"][amt]");
			$(this).children("td:eq(6)").children("[type=text]").attr("name","Trepovch["+(x+1)+"][remarks]");
			$(this).children(".docRefNum").attr("name","Trepovch["+(x+1)+"][doc_ref_num]");
			$(this).children(".talId").attr("name","Trepovch["+(x+1)+"][tal_id]");
			
			x++;
		});
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<vchCount;x++)
   		{
   			if($("[name='Trepovch["+(x+1)+"][cancel_flg]']").val())
				$("#tableVch tbody tr:eq("+x+") td:eq(7) a:eq(0)").attr('onClick',"cancel(this,'"+$("[name='Trepovch["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableVch tbody tr:eq("+x+") td:eq(7) a:eq(0)").attr('onClick',"deleteRow2("+(x+1)+")");
   			}
   		}
   		/*
		for(x=0;x<vchCount;x++)
   		{
   			if($("#tableVch").children('tbody').children("tr:eq("+x+")").children('td:eq(0)').children('input:eq(2)').length)
				$("#tableVch").children("tbody").children("tr:eq("+x+")").children("td:eq(7)").children("a:eq(0)").attr('onClick',"cancel(this,'"+$("#tableVch").children('tbody').children("tr:eq("+x+")").children('td:eq(0)').children('input:eq(2)').val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableVch").children("tbody").children("tr:eq("+x+")").children("td:eq(7)").children("a:eq(0)").attr('onClick',"deleteRow2("+(x+1)+")");
   			}
   		}*/
   	}
	
	function resetRepo()
	{
		$("#repoType").val('<?php echo $oldModel->repo_type ?>');
		$("#clientCode").val('<?php echo $oldModel->client_cd ?>');
		$("#secuType").val('<?php echo $oldModel->secu_type ?>');
		$("#repoRef").val('<?php echo $oldModel->repo_ref ?>');
		$("#repoDate").val('<?php if($oldModel->repo_date)echo DateTime::createFromFormat('Y-m-d G:i:s',$oldModel->repo_date)->format('d/m/Y') ?>');
		$("#extentNum").val('<?php echo $oldModel->extent_num ?>');
		$("#extentDate").val('<?php if($oldModel->extent_dt)echo DateTime::createFromFormat('Y-m-d G:i:s',$oldModel->extent_dt)->format('d/m/Y') ?>');
		$("#dueDate").val('<?php if($oldModel->due_date)echo DateTime::createFromFormat('Y-m-d G:i:s',$oldModel->due_date)->format('d/m/Y') ?>');
		$("#repoVal").val(setting.func.number.addCommas(<?php echo $oldModel->repo_val ?>));
		$("#feePer").val('<?php echo $oldModel->fee_per ?>');
		$("#returnVal").val(setting.func.number.addCommas(<?php echo $oldModel->return_val ?>));
		
		if('<?php echo $oldModel->penghentian_pengakuan ?>' == 'Y')$("#Trepo_penghentian_pengakuan").prop('checked',true);
		else
			$("#Trepo_penghentian_pengakuan").prop('checked',false);
			
		
		if('<?php echo $oldModel->serah_saham ?>' == 'Y')$("#Trepo_serah_saham").prop('checked',true);
		else
			$("#Trepo_serah_saham").prop('checked',false);	
	}
	
	function resetRepoHist()
	{
		if(histCount <= 1)
		{
			$('[name="Trepohist['+histCount+'][repo_date]"]').val($("#repoDate").val());
			$('[name="Trepohist['+histCount+'][repo_ref]"]').val($("#repoRef").val());
    	}
    	else
    	{
    		$('[name="Trepohist['+histCount+'][repo_date]"]').val($("#extentDate").val());
			$('[name="Trepohist['+histCount+'][repo_ref]"]').val($("#extentNum").val());
    	}
    	$('[name="Trepohist['+histCount+'][due_date]"]').val($("#dueDate").val());
		$('[name="Trepohist['+histCount+'][repo_val]"]').val($("#repoVal").val());
		$('[name="Trepohist['+histCount+'][return_val]"]').val($("#returnVal").val());
		$('[name="Trepohist['+histCount+'][interest_rate]"]').val($("#feePer").val());
	}
	
	function disableRepo()
	{
		$("#repoRef").prop('readonly',true);
    	$("#repoDate").prop('disabled',true);
    	$("#extentNum").prop('readonly',true);
    	$("#extentDate").prop('disabled',true);
    	$("#dueDate").prop('disabled',true);
    	$("#repoVal").prop('readonly',true);
    	$("#returnVal").prop('readonly',true);
    	$("#feePer").prop('readonly',true);
	}
	
	function enableRepo()
	{
		if(histCount <= 1)
		{
			$("#repoRef").prop('readonly',false);
    		$("#repoDate").prop('disabled',false);
    	}
    	else
    	{
    		$("#extentNum").prop('readonly',false);
    		$("#extentDate").prop('disabled',false);
    	}
    	$("#dueDate").prop('disabled',false);
    	$("#repoVal").prop('readonly',false);
    	$("#returnVal").prop('readonly',false);
    	$("#feePer").prop('readonly',false);
	}
	
	function assignVchDetail(rowSeq)
	{
		var doc_num = $('#docNum'+rowSeq);
		var text = doc_num.children('option:selected').text();
		var text2= text.substring(text.indexOf('-')+2);
		var doc_ref_num = text2.trim();
		var tal_id = doc_num.children('option:selected').attr('id');
		
		$("#addVch").attr('onClick',''); //Prevent the addition of new row (which call another ajax request) until the current ajax request is done
		
		/*----------BEGIN AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
		
		mapArray();
		
		for(x = 0;x < vchCount;x++)
		{
			filterJournalRef(x);
		}
		
		for(x = 0;x < vchCount;x++)
		{
			disableOption(x);
		}
		
		/*----------END AUTOMATIC JOURNAL REF FILTER (COMMENT TO INCREASE PERFORMANCE)----------*/
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxAssignVchDetail',array('id'=>$oldModel->repo_num)); ?>',
			'dataType' : 'json',
			'data'     : {
							'doc_num' : doc_num.val(),
							'doc_ref_num' : doc_ref_num,
							'tal_id' : tal_id,
							'repo_date': '<?php echo $oldModel->repo_date ?>',
							'client_cd': '<?php echo $oldModel->client_cd ?>',
							's_gl_acct': '<?php echo $s_gl_acct ?>',
							'repo_num' : '<?php echo $oldModel->repo_num ?>',
						}, 
			'success'  : function(data){
				var result = data.content;
				switch(result.payrec_type)
				{
					case 'RD':
						$('[name = "Trepovch['+rowSeq+'][payrec_type]"]').val('Receipt');
						break;
					case 'PD':
						$('[name = "Trepovch['+rowSeq+'][payrec_type]"]').val('Payment');
						break;
					case 'RV':
						$('[name = "Trepovch['+rowSeq+'][payrec_type]"]').val('Receipt to Settle');
						break;
					case 'PV':
						$('[name = "Trepovch['+rowSeq+'][payrec_type]"]').val('Payment to Settle');
						break;
					default:
						$('[name = "Trepovch['+rowSeq+'][payrec_type]"]').val('PB');
						break;
				}
				$('[name = "Trepovch['+rowSeq+'][doc_dt]"]').val(result.payrec_date);
				$('[name = "Trepovch['+rowSeq+'][folder_cd]"]').val(result.folder_cd);
				$('[name = "Trepovch['+rowSeq+'][amt]"]').val(result.amt);
				
				countTotal($('[name = "Trepovch['+rowSeq+'][amt]"]'));
				
				$('[name = "Trepovch['+rowSeq+'][remarks]"]').val(result.remarks);
				$('[name = "Trepovch['+rowSeq+'][doc_ref_num]"]').val(result.doc_ref_num);
				$('[name = "Trepovch['+rowSeq+'][tal_id]"]').val(result.tal_id);
			}
		});
	}
	
	function assignHiddenValue()
	{
		$("#repoDateHid").val($("#repoDate").val());
		$("#extentDateHid").val($("#extentDate").val());
		$("#dueDateHid").val($("#dueDate").val());
		$("#perpanjanganCnt").val(histCount);
		$("#voucherCnt").val(vchCount);
		
		if(perpanjangan)$("#perpanjanganFlg").val(1);
		else
			$("#perpanjanganFlg").val(0);
			
		if(voucher)$("#voucherFlg").val(1);
		else
			$("#voucherFlg").val(0);
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		if(authorizedCancel)
		{
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Trepovch['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableVch tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
		}
		else
			alert('You are not authorized to perform this action');	
	}
	
	function cancel_reason()
	{
		var cancel_reason = false;
		
		for(x=0;x<vchCount;x++)
		{
			if($("#rowVch"+(x+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason)$(".cancel_reason, .temp").show().attr('disabled',false)
		else
			$(".cancel_reason, .temp").hide().attr('disabled',true);
	}
	
	function assignBottomUp(cellId)
	{
		switch(cellId)
		{
			case 1:
				$("#extentDate").val($('[name="Trepohist['+histCount+'][repo_date]"]').val());
				break;
			case 2:
				$("#dueDate").val($('[name="Trepohist['+histCount+'][due_date]"]').val());
				break;
			case 3:
				$("#extentNum").val($('[name="Trepohist['+histCount+'][repo_ref]"]').val());
				break;
			case 4:
				$('[name="Trepohist['+histCount+'][repo_val]"]').val(setting.func.number.addCommas(setting.func.number.removeCommas($('[name="Trepohist['+histCount+'][repo_val]"]').val())));
				$("#repoVal").val($('[name="Trepohist['+histCount+'][repo_val]"]').val());
				break;
			case 5:
				$('[name="Trepohist['+histCount+'][return_val]"]').val(setting.func.number.addCommas(setting.func.number.removeCommas($('[name="Trepohist['+histCount+'][return_val]"]').val())));
				$("#returnVal").val($('[name="Trepohist['+histCount+'][return_val]"]').val());
				break;
			case 6:
				$("#feePer").val($('[name="Trepohist['+histCount+'][interest_rate]"]').val());
				break;
		}
	}
	
	//TOP-DOWN ASSIGN
	$("#repoDate").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][repo_date]"]').val($("#repoDate").val());
	})
	$("#dueDate").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][due_date]"]').val($("#dueDate").val());
	})
	$("#repoRef").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][repo_ref]"]').val($("#repoRef").val());
	})
	$("#repoVal").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][repo_val]"]').val(setting.func.number.addCommas($("#repoVal").val()));
	})
	$("#returnVal").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][return_val]"]').val(setting.func.number.addCommas($("#returnVal").val()));
	})
	$("#feePer").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][interest_rate]"]').val($("#feePer").val());
	})
	$("#repoDate").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][repo_date]"]').val($("#repoDate").val());
	})
	
	$("#extentNum").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][repo_ref]"]').val($("#extentNum").val());
	})
	$("#extentDate").change(function()
	{
		if(<?php echo $new ?> || !perpanjangan)$('[name="Trepohist['+histCount+'][repo_date]"]').val($("#extentDate").val());
	})
	//END TOP-DOWN ASSIGN
	
</script>
