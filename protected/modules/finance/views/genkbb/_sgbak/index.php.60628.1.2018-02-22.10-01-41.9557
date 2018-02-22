<style>
	.radio.inline{margin-top:5px}
	
	.radio.inline label{margin-left: 15px;}
	
	.tnumber, .tnumberdec
	{
		text-align:right
	}
	
	.tabMenu ul
	{
		border-top:2px solid #ddd;
		border-bottom:2px solid #ddd;
		border-left:2px solid #ddd;
		border-radius:5px;
	}	
	.tabMenu li
	{
		border-right:1px solid #ddd;
		border-radius:5px;
	}
	.tabMenu li:not(:first-child)
	{
		border-left:1px solid #ddd;
		border-radius:5px;
	}
	
	#showloading
	{
		display:none;
		/*width:150px;
		height:150px;*/
		position:absolute;
		left:45%;
		top:20%;
	}
	
	.tableDetailList
	{
		background-color:#C3D9FF;
	}
	.tableDetailList thead, .tableDetailList tbody, .tableDetailList tfoot
	{
		display:block;
	}
	.tableDetailList tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.tableDetailList th, .tableDetailList td
	{
		padding:3px;
	}
	.tableDetailList tfoot
	{
		background-color:#FFFFFF;
		font-style:normal;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Generate KBB'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate Interface for Bank RDI', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tpayrech-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php 
		echo $form->errorSummary($model); 
	?>
	
	<div id="showloading" style="display:none;margin: auto; width: auto; text-align: center;">
		Please wait...<br />
		<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'due_date',array('class'=>'control-label')) ?>
			<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
		</div>
		
		<div class="span6">
			<div class="span2">
				<?php echo $form->labelEx($model,'payrec_type',array('class'=>'control-label')) ?>
			</div>
			<?php echo $form->dropDownList($model,'payrec_type',Parameter::getCombo('KBBTYP', '-Choose Type-', null, null, 'cd'),array('class'=>'span4','id'=>'payrecType')) ?>
			<input type="hidden" id="payrecType_hid" value="<?php echo $model->payrec_type ?>" />
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'Bank',array('class'=>'control-label')) ?>
			<?php echo $form->dropDownList($model,'bank_cd',CHtml::listData($bankList, 'bank_cd', 'bank_name'),array('class'=>'span4','id'=>'bankCd')) ?>
		</div>
		
		<div class="span6 checkBox_div">
			<div class="span1">
				<?php echo $form->checkBox($model,'save_excel_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'saveExcelFlg','class'=>'fileTypeCheckBox')) ?>
			</div>
			Save Excel
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->labelEx($model,'branch_code',array('class'=>'control-label')) ?>
			<?php echo $form->checkBox($model,'branch_all_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'branchAllFlg')) ?>
			All
			&emsp;
			<?php echo $form->dropDownList($model,'branch_code',CHtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'KBBGRP' AND prm_desc <> 'XX'",'order'=>'prm_cd_1')), 'prm_desc', 'prm_desc'),array('class'=>'span4','id'=>'branchCode','prompt'=>'-Choose Branch-')) ?>
			<input type="hidden" id="branchCode_hid" value="<?php echo $model->branch_code ?>" />
		</div>
		
		<div class="span6 checkBox_div">
			<div class="span1">
				<?php echo $form->checkBox($model,'save_text_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'saveTextFlg','class'=>'fileTypeCheckBox')) ?>
			</div>
			Save Text
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div id="methodRadio">
				<?php echo $form->radioButtonListInlineRow($model, 'method', array(1=>'Manual', 2=>'Host to Host'), array('id'=>'method','class'=>'method')) ?>
			</div>
		</div>
		
		<div class="span6 checkBox_div">
			<div class="span1">
				<?php echo $form->checkBox($model,'save_csv_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'saveCsvFlg','class'=>'fileTypeCheckBox')) ?>
			</div>
			Save CSV
		</div>
	</div>
	
	<br/>
	
	<div class="row-fluid" id="manual_div">
		<div class="span3">
			
		</div>
		
		<div class="span6" style="text-align:right">
			<div style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnKbb',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'KBB',
					'htmlOptions'=>array('name'=>'submit','value'=>'kbb')
				)); ?>
			</div>
			
			<div class="span1" style="float:left">
				
			</div>
			<!--
			<div style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnUlang',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'KBB Ulang',
					'htmlOptions'=>array('name'=>'submit','value'=>'ulang')
				)); ?>
			</div>
			
			<div class="span1" style="float:left">
				
			</div>
			-->
			<div style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnAuto',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Auto Trf Baru',
					'htmlOptions'=>array('name'=>'submit','value'=>'auto')
				)); ?>
			</div>
			
			<div style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnDownload',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Auto Trf Baru',
					'htmlOptions'=>array('name'=>'submit','value'=>'download','style'=>'display:none')
				)); ?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid" id="h2h_div">
		<div class="span3">
			
		</div>
		
		<div class="span6" style="text-align:right">
			<div style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnH2H',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Retrieve',
					'htmlOptions'=>array('name'=>'submit','value'=>'h2h')
				)); ?>
			</div>
		</div>
	</div>
	
	<br/>
	
	<div class="row-fluid">

		<div class="span4">
<?php 
	if($retrieved && count($modelDetailList) > 1): 
?>	
			<label class="control-label">Group</label>	 
			<select class="span6" id="detailBranchGroup">
	<?php 
		foreach($branchGroupList as $key=>$row): 
	?>
				<option value=<?php echo $key ?>><?php echo $row['branch_group'] ?></option>
	<?php 
		endforeach; 
	?>
			</select>	
			
			<input type="hidden" id="detailBranchGroupTxt" name="detailBranchGroupTxt" />	 
<?php 
	endif; 
?>
		</div>
		
<?php
	if($retrieved):
		if($model->method == 1): // MANUAL
			if($modelDetailList && (count($modelDetailList) > 1 || count($modelDetailList[0]) > 1)):
?>
		<div class="span8">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnDownloadNext',
				'label'=>'Download Next File',
			)); ?>
			
			&emsp;
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnDownloadThis',
				'label'=>'Download Current File',
			)); ?>
		</div>
<?php
			endif;
			
		else: // HOST TO HOST
?>
		<div class="span8">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnSaveThisH2H',
				'label'=>'Transfer to BCA',
			)); ?>
			
			&emsp;
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnSaveAllH2H',
				'label'=>'Tranfer All to BCA',
			)); ?>
		</div>
		
<?php
		endif;
	endif;
?>
		
	</div>

	<br/>

<?php 	
	if($retrieved)
	{
?>
	<div id="detail_div">
<?php 
		$id = 0;
		
		if($model->bank_cd == 'BCA02')
		{
			$file = $model->payrec_type == AConstant::KBB_TYPE_TO_CLIENT|| $model->payrec_type == AConstant::KBB_TYPE_TO_CLIENT_FUND?'list_auto_trf':'list';
		}
		else if($model->bank_cd == 'BNGA3')
		{
			if($model->payrec_type == AConstant::KBB_TYPE_AP)$file = 'list_cimb_ap';
			else if($model->payrec_type == AConstant::KBB_TYPE_AR)$file = 'list_cimb_ar';
			else
				$file = 'list';
		}
		else
		{
			$file = 'list';
		}

		
		foreach($modelDetailList as $row)
		{
			$class = $id == 0 ? 'active' : '';
			
			if(count($row) == 1)
			{
				echo "<div id ='tabGroup".$id."' class='tabMenu ".$class."'>";
				echo "	<div class='tab-content'>";
				echo "		<div class='active'>";
				echo 			$this->renderPartial($file,array('model'=>$model,'modelDetailList'=>$row[0],'scenario'=>$scenario,'active'=>count($modelDetailList==1)?true:false,'form'=>$form));
				echo "		</div>";
				echo "	</div>";
				echo "</div>";
			}
			else 
			{
				$tabs = array();
				$x = 0;
				foreach($row as $key=>$innerRow)
				{
					$tabs = array_merge($tabs,
						array(
							array(
				                'label'   => $key,
				                'content' => $this->renderPartial($file,array('model'=>$model,'modelDetailList'=>$innerRow,'scenario'=>$scenario,'active'=>count($modelDetailList==1) && $x==0?true:false,'form'=>$form),true,false),
				                'active'  => $x==0?true:false
							)
						)
					);
					
					$x++;
				}
				
				$this->widget(
				   'bootstrap.widgets.TbTabs',
				    array(
				        'type' => 'pills', // 'tabs' or 'pills'
				        'tabs' => $tabs,
				        'htmlOptions' => array('class'=>'tabMenu '.$class, 'id'=>'tabGroup'.$id),
				    )
				);
			}

			$id++;
		}
?>
	</div>
	
	<div id="downloadFrame">
		<input type="hidden" id="downloadSeq" name="downloadSeq" />
		<input type="hidden" id="textFileName" name="textFileName" />
		<input type="hidden" id="excelFileName" name="excelFileName" />
		<input type="hidden" id="csvFileName" name="csvFileName" />
		<input type="hidden" id="fileType" name="fileType" />
		<input type="hidden" id="activeTab" name="activeTab" />
	</div>
<?php
	}
?>

<?php $this->endWidget(); ?>

<script>
	var downloadSeq = 0;
	var downloadNextTabFlg = false;
	var saveAllFlg = false;
	var fileTypeArr = [];
	var method; // 1 = Manual, 2 = Host to Host

	$(document).ready(function()
	{
		method = $(".method:checked").val();
		
		checkBranchFlg();
		checkType();
		updateFileTypeArr();
		changeButtonLabel();
		changeButtonVisibility();
		changeButtonGroupVisibility();
		changeRadioVisibility();
		changeCheckBoxVisibility();
		
		$(window).trigger('resize');
		
		if(<?php if(count($modelDetailList) > 1)echo 1;else echo 0 ?>)
		{
			changeDetailVisibility();
			copyBranchText();
		}
		
		if(<?php if($retrieved)echo 1;else echo 0 ?>)
		{
			setTimeout(function()
			{
				if(method == 1)download(0);
			},
			500);
		}
		
		
	});
	
	$(document).ajaxStart(function() {
  		 $('#showloading').show();
	});
	
	$(document).ajaxStop(function() {
   		$('#showloading').hide();
	});
	
	$(window).resize(function()
	{
		var table = $("#detail_div").children(".tabMenu.active").children("div.tab-content").children("div.active").children("div.tableContainer").children("table.active");
		var body = table.children('tbody');
		
		//$(".tabMenu").offset({left:7});
		//$(".tabMenu").css('width',($(window).width()-10));

		if(body.length)
		{
			if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
			{
				table.children('thead').css('width', '100%').css('width', '-=17px');	
			}
			else
			{
				table.children('thead').css('width', '100%');	
			}
			
			alignColumn();
		}
	});

	function checkBranchFlg()
	{
		if($("#branchAllFlg").is(":checked"))
		{
			//$("#branchCode").hide().removeAttr('required');
			$("#branchCode").removeAttr('required');
			$("#branchCode").val('');
		}
		else
		{
			//$("#branchCode").show().attr('required',true);
			$("#branchCode").attr('required',true);
		}
	}
	
	function checkBranchCode()
	{
		if($("#branchCode").val())
		{
			$("#branchAllFlg").prop("checked",false);
			$("#branchCode").attr('required',true);
		}
		else
		{
			$("#branchAllFlg").prop("checked",true);
			$("#branchCode").removeAttr('required');
		}
	}
	
	function checkType()
	{
		if($("#payrecType").val())
		{
			if($("#payrecType").val() == '<?php echo AConstant::KBB_TYPE_TO_CLIENT ?>' || $("#payrecType").val() == '<?php echo AConstant::KBB_TYPE_TO_CLIENT_FUND ?>')
			{
				$("#btnAuto").prop('disabled',false);
				$("#btnKbb, #btnUlang").prop('disabled',true);
			}
			else
			{
				$("#btnAuto").prop('disabled',true);
				$("#btnKbb, #btnUlang").prop('disabled',false);
			}
		}
		else
		{
			$("#btnKbb, #btnUlang, #btnAuto").prop('disabled',true);
		}
	}
	
	function changeDetailVisibility()
	{
		var id = $("#detailBranchGroup").val();
		
		$("#detail_div").children(".tabMenu").each(function()
		{
			if($(this).attr("id") == "tabGroup"+id)
			{
				$(this).show();
				$(this).addClass('active');
				$(this).children("div.tab-content").children("div.active").children("div.tableContainer").children("table.detailGroup").addClass('active');
			}
			else
			{
				$(this).hide();
				$(this).removeClass('active');
				$(this).children("div.tab-content").children("div.active").children("div.tableContainer").children("table.detailGroup").removeClass('active');
			}
		});
		
		$(window).trigger('resize');
	}
	
	function download(seq) // seq => 0++ for manual, -1 for host to host
	{
		$("#payrecType").val($("#payrecType_hid").val());
		
		if(seq < fileTypeArr.length)
		{
			if(seq==0)downloadSeq++;
			$("#downloadSeq").val(downloadSeq);
			
			var activeClass = 'active';
			
			if(saveAllFlg)activeClass = 'immediate';
			
			var activeDiv = $("#detail_div").children("div.tabMenu.active").children("div.tab-content").children("div."+activeClass);
			var table = activeDiv.children("div.tableContainer").children("table."+activeClass);
			var record = {};
			var totalAmount = setting.func.number.removeCommas(table.children("tfoot").children("tr").children("td#totalTransAmount").children('[type=text]').val());
			var x = 0;		
			var branchGroupIndex = $("#detailBranchGroup").length ? parseInt($("#detailBranchGroup").val())+1 : 1;
			var payrecType = $("#payrecType").val();
			var bank = $("#bankCd").val();
			var fileType = '';
			var activeTab = $("#detail_div").children("div.tabMenu.active").children("ul").children("li.active").children("a").text();
			var branchGroup = $("#detailBranchGroup").length ? $("#detailBranchGroup").children("option:selected").text() : $("#branchCode_hid").val();
			
			if(saveAllFlg)
			{
				activeDiv.removeClass('immediate');
				table.removeClass('immediate');
			}
			
			if(method == 1)
			{
				if(fileTypeArr[seq].id == 'saveExcelFlg')
				{
					fileType = 'xls';
				}
				else if(fileTypeArr[seq].id == 'saveTextFlg')
				{
					fileType = 'txt';
				}
				else
				{
					fileType = 'csv';
				}
			}
			
			if(bank == 'BCA02')
			{
				if(<?php if($model->payrec_type == AConstant::KBB_TYPE_TO_CLIENT || $model->payrec_type == AConstant::KBB_TYPE_TO_CLIENT_FUND)echo 0; else echo 1; ?>)
				{
					table.children('tbody').children('tr').each(function()
					{
						record[x] = {};
						
						record[x]['client_name'] = $(this).children('td.acctName').children('[type=text]').val();
						record[x]['trans_date'] = $(this).children('td.transDate').children('[type=text]').val();
						record[x]['trans_amount'] = setting.func.number.removeCommas($(this).children('td.transAmount').children('[type=text]').val());
						record[x]['bank_acct_num'] = $(this).children('td.bankAcctNum').children('[type=text]').val();
						record[x]['bank_cd'] = $(this).children('td.bankCd').children('[type=text]').val();
						record[x]['bi_code'] = $(this).children('td.biCode').children('[type=text]').val();
						record[x]['bank_branch_name'] = $(this).children('td.bankBranchName').children('[type=text]').val();
						record[x]['remark1'] = $(this).children('td.remark1').children('[type=text]').val();
						record[x]['remark2'] = $(this).children('td.remark2').children('[type=text]').val();
						record[x]['jenis'] = $(this).children('td.jenis').children('[type=text]').val();
						record[x]['trf_id'] = $(this).children('input.trfId').val();
						record[x]['customer_type'] = $(this).children('input.customerType').val();
						record[x]['customer_residence'] = $(this).children('input.customerResidence').val();
						record[x]['payrec_num'] = $(this).children('input.payrecNum').val();
						
						x++;
					});
				}
				else
				{			
					table.children('tbody').children('tr').each(function()
					{
						record[x] = {};
						
						record[x]['doc_num'] = $(this).children('td.docNum').children('[type=text]').val();
						record[x]['from_acct'] = $(this).children('td.fromAcct').children('[type=text]').val();
						record[x]['to_acct'] = $(this).children('td.toAcct').children('[type=text]').val();
						record[x]['trans_amount'] = setting.func.number.removeCommas($(this).children('td.transAmount').children('[type=text]').val());
						record[x]['remark1'] = $(this).children('td.remark1').children('[type=text]').val();
						record[x]['remark2'] = $(this).children('td.remark2').children('[type=text]').val();
						record[x]['bi_code'] = $(this).children('td.biCode').children('[type=text]').val();
						record[x]['bank_cd'] = $(this).children('td.bankCd').children('[type=text]').val();
						record[x]['bank_branch_name'] = $(this).children('td.bankBranchName').children('[type=text]').val();
						record[x]['receiver_name'] = $(this).children('td.receiverName').children('[type=text]').val();
						record[x]['trans_date'] = $(this).children('td.transDate').children('[type=text]').val();
						record[x]['jenis'] = $(this).children('td.jenis').children('[type=text]').val();
						record[x]['trf_id'] = $(this).children('input.trfId').val();
						record[x]['customer_type'] = $(this).children('input.customerType').val();
						record[x]['customer_residence'] = $(this).children('input.customerResidence').val();
						
						x++;
					});
					
					if(x > 0)
					{
						record[0]['trf_type'] = $("#detail_div").children("div.tabMenu.active").children("ul").children("li.active").children("a").text();
						
						if(record[0]['trf_type'] != 'BCA')
						{
							var valid = true;
							
							table.children('tbody').children('tr').each(function()
							{
								if($(this).children('td.bankCd').children('[type=text]').val() == '')
								{
									alert("Bank Name Cannot be empty");
									valid = false;
									return false;
								}
							});
							
							if(!valid)
							{
								return false;
							}
						}
					}
				}
			}
			else if(bank == 'BNGA3')
			{
				if(<?php if($model->payrec_type == AConstant::KBB_TYPE_AP)echo 1;else echo 0 ?>)
				{	
					table.children('tbody').children('tr').each(function()
					{
						record[x] = {};
						
						record[x]['bank_acct_cd'] = $(this).children('td.bankAcctCd').children('[type=text]').val();
						record[x]['bank_name'] = $(this).children('td.bankName').children('[type=text]').val();
						record[x]['bank_acct_cd_csv'] = $(this).children('input.bankAcctCdCsv').val();
						record[x]['bank_name_csv'] = $(this).children('input.bankNameCsv').val();
						record[x]['currency'] = $(this).children('td.currency').children('[type=text]').val();
						record[x]['curr_amt'] = setting.func.number.removeCommas($(this).children('td.amount').children('[type=text]').val());
						record[x]['descrip'] = $(this).children('td.description').children('[type=text]').val();
						record[x]['cnt'] = $(this).children('td.count').children('[type=text]').val();
						record[x]['tanggal'] = $(this).children('td.tanggal').children('[type=text]').val();
						record[x]['e_mail'] = $(this).children('td.email').children('[type=text]').val();
						
						
						x++;
					});
				}
				else if(<?php if($model->payrec_type == AConstant::KBB_TYPE_AR)echo 1;else echo 0 ?>)
				{
					table.children('tbody').children('tr').each(function()
					{
						record[x] = {};
						
						record[x]['bank_acct_cd'] = $(this).children('td.bankAcctCd').children('[type=text]').val();
						record[x]['bank_acct_fmt'] = $(this).children('td.bankAcctFmt').children('[type=text]').val();
						record[x]['acct_name'] = $(this).children('td.acctName').children('[type=text]').val();
						record[x]['bank_acct_fmt_csv'] = $(this).children('input.bankAcctFmtCsv').val();
						record[x]['bank_acct_cd_csv'] = $(this).children('input.bankAcctCdCsv').val();
						record[x]['acct_name_csv'] = $(this).children('input.acctNameCsv').val();
						record[x]['curr_amt'] = setting.func.number.removeCommas($(this).children('td.amount').children('[type=text]').val());
						record[x]['descrip'] = $(this).children('td.description').children('[type=text]').val();
						record[x]['trx_type'] = $(this).children('td.trxType').children('[type=text]').val();
						record[x]['e_mail'] = $(this).children('td.email').children('[type=text]').val();
						
						x++;
					});
				}
			}
	
			$.ajax({
				'type'     	: 'POST',
	    		'url'      	: '<?php echo $this->createUrl('ajxPrepareFile'); ?>',
				'dataType' 	: 'json',
				'data'     	: 	{
									'record' : record,
									'totalAmount' : totalAmount,
									'totalRecord' : x,
									'payrecType' : payrecType,
									'activeTab' : activeTab,
									'bank' : bank,
									'method' : method,
									'fileType' : fileType,
									'branchGroupIndex' : branchGroupIndex,
									'branchGroup' : branchGroup
								},
				'async'		: method==1?true:false,
				'success'	: function(data){
								if(data)
								{
									if(method == 1)
									{
										// Manual
										
										if(data['fileType'] == 'txt')
											$("#textFileName").val(data['textFileName']);
										else if(data['fileType'] == 'xls')
											$("#excelFileName").val(data['excelFileName']);
										else if(data['fileType'] == 'csv')
											$("#csvFileName").val(data['csvFileName']);
											
										if(data['fileType'])
										{
											$("#fileType").val(fileType);
											$("#activeTab").val(activeTab);
											$("#btnDownload").click();
											
											setTimeout(function()
											{
												download(++seq);
											},
											3500);
										}
									}
									else
									{
										// Host to Host
										
										if(data['successUpload'])alert('Save Successful. Transfer ID: ' + record[0]['trf_id']);
										else
										{
											alert('Save Failed. ' + data['errorMessage']);
										}
									}
								}						
							},
		      'statusCode': {
                            500: function() 
                                {
                                    alert("Transfer ke BCA gagal, Hardisk penuh, silahkan hubungi IT administrator");
                                }
	                       }
			});
		}
	}
	
	function downloadNextTab() // Download next tab detail
	{
		var nextTab = $("div.tabMenu.active").children("ul").children("li.active").next();
		
		if(nextTab.length)
		{
			downloadNextTabFlg = true;
			nextTab.children('a').click();
		}
		else
		{
			downloadNextDetail();
		}
	}
	
	function downloadNextDetail() // Download next branch group detail
	{
		if($("#detailBranchGroup").length)
		{
			if( $("#detailBranchGroup").val() < $("#detailBranchGroup").children('option').length - 1 )	
			{
				$("#detailBranchGroup").val(parseInt($("#detailBranchGroup").val()) + 1).change();
				download(0);
			}
			else
			{
				alert("No File remaining");
			}
		}
		else
		{
			alert("No File remaining");
		}
	}
	
	function updateFileTypeArr()
	{
		fileTypeArr = $(".fileTypeCheckBox:checked").toArray();
	}
	
	function copyBranchText()
	{
		$("#detailBranchGroupTxt").val($("#detailBranchGroup").children("option:selected").text());
	}
	
	function changeButtonLabel()
	{
		if($("#bankCd").val() == 'BCA02')$("#btnKbb").html('KBB');
		else
			$("#btnKbb").html('Generate');
	}
	
	function changeButtonVisibility()
	{
		if($("#payrecType").children("option[value=<?php echo AConstant::KBB_TYPE_TO_CLIENT ?>]").length)
		{
		    $("#btnAuto").show();
		}
		else if($("#payrecType").children("option[value=<?php echo AConstant::KBB_TYPE_TO_CLIENT_FUND ?>]").length)
        {
            $("#btnAuto").show();
        }
		else
		{
			$("#btnAuto").hide();
		}
	}
	
	function changeButtonGroupVisibility()
	{
		if($(".method:checked").val() == 1)
		{
			$("#manual_div").show();
			$("#h2h_div").hide();
		}
		else
		{
			$("#manual_div").hide();
			$("#h2h_div").show();
		}
	}
	
	function changeRadioVisibility()
	{
		if($("#bankCd").val() == 'BCA02' && '<?php echo $method_flg;?>' =='Y')
		{
			$("#methodRadio").show();
		}
		else
		{
			$("#GenKBB_method_0").prop('checked',true).change();
			$("#methodRadio").hide();
		}	
	}
	
	function changeCheckBoxVisibility()
	{
		if($(".method:checked").val() == 1)$(".checkBox_div").show();
		else
			$(".checkBox_div").hide();
	}
	
	function saveAll()
	{
		viewFirstDetailGroup();
		
		var detailGroupSeq = 0;
		saveAllFlg = true;
	
		$("#detail_div").children(".tabMenu").each(function()
		{
			var currTabGroupArr = $(this);
			
			viewFirstDetailTab(detailGroupSeq);
			
			$(this).children(".tab-content").children("div").each(function()
			{
				download(-1);

				var nextTab = currTabGroupArr.children("ul").children("li.active").next();
				
				if(nextTab.length)
				{					
					nextTab.children("a").click();
					setActiveTableImmediate(nextTab.index());
				}
			});
			
			if($("#detailBranchGroup").length && (detailGroupSeq + 1) < $("#detailBranchGroup").children("option").length)
			{
				$("#detailBranchGroup").val(detailGroupSeq + 1).change();
			}
			
			detailGroupSeq++;			
		});
		
		saveAllFlg = false;
	}
	
	function viewFirstDetailGroup()
	{
		if($("#detailBranchGroup").length)
		{
			$("#detailBranchGroup").val(0).change();
		}
	}
	
	function viewFirstDetailTab(index)
	{
		var firstTab = $("#tabGroup"+index).children("ul").children("li:eq(0)");
		
		if(firstTab.length/* && !firstTab.hasClass("active")*/)
		{
			firstTab.children("a").click();
		}
		
		setActiveTableImmediate(0);
	}
	
	function setActiveTable() // To be executed after the whole tab content is fully shown
	{
		$("div.tabMenu.active").children("div.tab-content").children("div").each(function()
		{
			if($(this).hasClass('active'))
			{
				$(this).children("div.tableContainer").children("table.detailGroup").addClass('active');
			}
			else
			{
				$(this).children("div.tableContainer").children("table.detailGroup").removeClass('active');
			}
		});
	}
	
	function setActiveTableImmediate(seq) // To be executed immediately after a tab is clicked
	{
		$("div.tabMenu.active").children("div.tab-content").children("div").each(function()
		{
			if($(this).index() == seq)
			{
				$(this).addClass('immediate');
				$(this).children("div.tableContainer").children("table.detailGroup").addClass('immediate');
			}
			else
			{
				$(this).removeClass('immediate');
				$(this).children("div.tableContainer").children("table.detailGroup").removeClass('immediate');
			}
		});
	}
	
	/*$("#btnDownload").click(function()
	{
		$(window).on('blur',function()
		{
			$(window).on('focus',function()
			{
				$(window).off('blur focus');
				
				setTimeout
				(
					function()
					{
						if(!document.hasFocus())
						{
							alert(1);
							downloadWait = true;
							
							$(window).on('focus',function()
							{
								$(window).off('focus');
								downloadWait = false;
								downloadNextDetail();
							});
						}
						
						if(!downloadWait)
						{
							downloadNextDetail();
						}
					},
					1000
				)
				
				downloadNextDetail();
			});
		});
			
	});*/
	
	$(".method").change(function()
	{
		changeCheckBoxVisibility();
		changeButtonGroupVisibility();
	});
	
	$(".fileTypeCheckBox").change(function()
	{
		updateFileTypeArr();
	});
	
	$("#bankCd").change(function()
	{
		changeButtonLabel();
		changeRadioVisibility();
	});
	
	$("#branchAllFlg").change(function()
	{
		checkBranchFlg();
	});
	
	$("#branchCode").change(function()
	{
		checkBranchCode();
	});
	
	$("#payrecType").change(function()
	{
		checkType();
	});
	
	$("#detailBranchGroup").change(function()
	{
		changeDetailVisibility();
		copyBranchText();
	});
	
	/*$("div.tabMenu > ul > li").click(function()
	{
		var index = $(this).index();
		
		$("div.tabMenu.active").children("div.tab-content").children("div").each(function()
		{
			if($(this).index() == index)
			{
				$(this).children("div.tableContainer").children("table.detailGroup").addClass('active');
			}
			else
			{
				$(this).children("div.tableContainer").children("table.detailGroup").removeClass('active');
			}
		});
	});*/
	
	$('div.tabMenu').on('shown',function()
	{
		setActiveTable();	
		alignColumn();

		if(downloadNextTabFlg)
		{
			download(0);
			downloadNextTabFlg = false;
		}
	});
	
	$("#btnDownloadNext").click(function()
	{
		if($("div.tabMenu.active").children("ul").length)
		{
			downloadNextTab();
		}
		else
		{
			downloadNextDetail();
		}
	});
	
	$("#btnDownloadThis").click(function()
	{
		download(0);
	});
	
	$("#btnSaveThisH2H").click(function()
	{
		if(confirm('Are you sure want to tranfer ?'))
		{
			download(-1);
		}
		else
		{
			return false;
		}
	});
	
	$("#btnSaveAllH2H").click(function()
	{
		
		if(confirm('Are you sure want to tranfer all?'))
		{
			saveAll();
		}
		else
		{
			return false;
		}
	});
</script>