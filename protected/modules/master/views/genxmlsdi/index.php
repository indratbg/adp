<style>
	.radio.inline{margin-top:5px}
	
	.radio.inline label{margin-left: 15px;}
	
	.tnumber, .tnumberdec
	{
		text-align:right
	}

	#showloading
	{
		display:none;
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
	.tableDetailList tfoot
	{
		background-color:#FFFFFF;
		font-style:normal;
	}
	
	.ui-dialog-titlebar
	{
		height:35px;
	}
	
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
</style>

<?php
$this->breadcrumbs=array(
	'Generate XML for SDI'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Generate Interface for Static Data Investor', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php 
	/*$type = array
			(
				AConstant::XML_SDI_TYPE_PEMBUKAAN => 'Pembukaan Sub Rekening',
				AConstant::XML_SDI_TYPE_PENGKINIAN => 'Pengkinian Data',
				AConstant::XML_SDI_TYPE_BLOCK => 'Block',
				AConstant::XML_SDI_TYPE_UNBLOCK => 'Unblock'
			);*/
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
<?php AHelper::alphanumericValidator() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'genxmlsdi-form',
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
	
	<?php echo $form->radioButtonListInlineRow($model,'mode',array(1=>'Regular', 2=>'IPO (Massal)'),array('class'=>'mode')); ?>
	
	<div class="row-fluid">
		<div class="span6">
			<div id="date_div" >
				<?php echo $form->labelEx($model,'From',array('class'=>'control-label')) ?>
				<?php echo $form->datePickerRow($model,'from_dt',array('id'=>'fromDt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
				<?php echo $form->labelEx($model,'To',array('class'=>'control-label')) ?>
				<?php echo $form->datePickerRow($model,'to_dt',array('id'=>'toDt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
			</div>
			<div id="subrek_div">
				<?php echo $form->textFieldRow($model,'subrek_from',array('class'=>'span4 tvalAlphaNum','maxlength'=>4)) ?>
				<?php echo $form->textFieldRow($model,'subrek_to',array('class'=>'span4 tvalAlphaNum','maxlength'=>4)) ?>
			</div>
		</div>
		
		<div class="span6" id="type_span">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'Type',array('class'=>'control-label')) ?>
				</div>
				<div class="controls">
					<input id="GenXmlSDI_type_0" class="type" type="radio" name="GenXmlSDI[type]" value=<?php echo AConstant::SDI_TYPE_SUBREK ?> style="float:left" <?php if($model->type == AConstant::SDI_TYPE_SUBREK)echo 'checked' ?>>
					<label for="GenXmlSDI_type_0" style="float:left">&emsp;Pembukaan Sub Rekening</label>
				</div>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSDI_type_1" class="type" type="radio" name="GenXmlSDI[type]" value=<?php echo AConstant::SDI_TYPE_PENGKINIANDATA ?> style="float:left" <?php if($model->type == AConstant::SDI_TYPE_PENGKINIANDATA)echo 'checked' ?>>
				<label for="GenXmlSDI_type_1" style="float:left">&emsp;Pengkinian Data</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSDI_type_2" class="type" type="radio" name="GenXmlSDI[type]" value=<?php echo AConstant::SDI_TYPE_BLOCK ?> style="float:left" <?php if($model->type == AConstant::SDI_TYPE_BLOCK)echo 'checked' ?>>
				<label for="GenXmlSDI_type_2" style="float:left">&emsp;Block</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSDI_type_3" class="type" type="radio" name="GenXmlSDI[type]" value=<?php echo AConstant::SDI_TYPE_UNBLOCK ?> style="float:left" <?php if($model->type == AConstant::SDI_TYPE_UNBLOCK)echo 'checked' ?>>
				<label for="GenXmlSDI_type_3" style="float:left">&emsp;Unblock</label>
			</div>
		</div>
	</div>
	
	<input type="hidden" id="scenario" name="scenario" value="<?php echo $scenario ?>"/>
	<input type="hidden" id="cnt001" name="cnt001" />
	<input type="hidden" id="cnt004" name="cnt004" />
	<input type="hidden" id="cnt005" name="cnt005" />
	
	<div class="row-fluid form-actions">
		<div class="span2">
			
		</div>
		<div class="span4" style="text-align:right">
			<div id="retrieve" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnRetrieve',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Retrieve',
					'htmlOptions'=>array('name'=>'submit','value'=>'retrieve')
				)); ?>
			</div>
			
			<div class="span1" style="float:left">
				
			</div>
			
			<div id="submit" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnGenerate',
					'buttonType'=>'button',
					'type'=>'primary',
					'label'=>'Generate XML',
					'htmlOptions'=>array('name'=>'submit','value'=>'generate','disabled'=>!$retrieved)
				)); ?>
			</div>
			
			<div style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnDownload',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Download',
					'htmlOptions'=>array('name'=>'submit','value'=>'download','style'=>'display:none')
				)); ?>
			</div>
		</div>
	</div>
	
	<div id="xml_dialog" style="display:none">
		<?php
			$tabs = array(
				array(
	                'label'   => '001',
	                'content' => $this->renderPartial('xml',array('subrekType'=>'001'),true,false),
				),
				array(
	                'label'   => '004',
	                'content' => $this->renderPartial('xml',array('subrekType'=>'004'),true,false),
				),
				array(
	                'label'   => '005',
	                'content' => $this->renderPartial('xml',array('subrekType'=>'005'),true,false),
				)
			);
		
		$this->widget(
		   'bootstrap.widgets.TbTabs',
		    array(
		        'type' => 'pills', // 'tabs' or 'pills'
		        'tabs' => $tabs,
		        'htmlOptions' => array('id'=>'tabMenu'),
		    )
		);
		
		?>
		
	</div>
	
	<?php echo $this->renderPartial('_form_pengkinian',array('model'=>$model,'modelPengkinian'=>$modelPengkinian,'form'=>$form)); ?>
	
	<?php if($retrieved): ?>

	<?php echo $this->renderPartial('_form_pembukaan',array('model'=>$model,'modelPembukaan'=>$modelPembukaan,'form'=>$form)); ?>
	
	<?php endif; ?>
	
	<div id="downloadFrame">
		<textarea id="xmlSubmit" name="xmlSubmit" style="display:none"></textarea>
		<input type="hidden" id="subrekType" name="subrekType" />
	</div>


<?php $this->endWidget(); ?>

<script>
	$(document).ready(function()
	{
		$(window).trigger('resize');
		changeRadio(1);
		checkMode();
	});
	
	$(document).ajaxStart(function() {
  		 $('#showloading').show();
	});
	
	$(document).ajaxStop(function() {
   		$('#showloading').hide();
	});
	
	$(window).resize(function()
	{
		var table = $("#tablePembukaan");
		var body = table.children('tbody');

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

			alignColumnPembukaan();
		}
		
		table = $("#tablePengkinian");
		body = table.children('tbody');

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

			alignColumnPengkinian();
		}
	});
	
	/*$("#GenXmlSDI_type_0").click(function()
	{
		changeRadio(1);	
		$(window).resize();
	});

	$("#GenXmlSDI_type_2,#GenXmlSDI_type_3").click(function()
	{
		changeRadio(2);	
		$(window).resize();
	});*/
	
	$(".mode").click(function()
	{
		checkMode();
	});
	
	$("#GenXmlSDI_type_0,#GenXmlSDI_type_1,#GenXmlSDI_type_2,#GenXmlSDI_type_3").click(function()
	{
		changeRadio($(this).val());	
		$(window).resize();
	});
	
	$(".btnDownload_dialog").click(function()
	{
		$("#subrekType").val($(this).val());
		$("#xmlSubmit").html($("#textArea"+$(this).val()).text());
		$("#btnDownload").click();
	});
	
	$("#tabMenu").children("ul").children("li").children("a").click(function()
	{
		var subrekType = $(this).text();
		
		if($("#cnt"+subrekType).val() > 0)$("#btnDownload"+subrekType).click();
	});
	
	$("#btnGenerate").click(function()
	{
		var pembukaanFlg = $("#GenXmlSDI_type_0").is(":checked");
		var tableObj = pembukaanFlg ? $("#tablePembukaan") : $("#tablePengkinian");
		var type = $("#type_span").find("input[type=radio]:checked").val();
		var data = {};
		
		data['001'] = {};
		data['004'] = {};
		data['005'] = {};
		
		$.each(data,function()
		{
			this['client_cd'] = {};
			this['client_type_1'] = {};
			this['subrek'] = {};
		});
		
		var clientCd;
		var clientType;
		var flg001;
		var flg004;
		var flg005;
		
		var cnt001 = 0;
		var cnt004 = 0;
		var cnt005 = 0;
		
		tableObj.children("tbody").children("tr").each(function()
		{
			clientCd = $(this).children("td.clientCd").children("input").val();
			clientType = $(this).children("td.clientType").children("input").val();
			flg001 = $(this).children("td.001").children("input").is(":checked");
			flg004 = $(this).children("td.004").children("input").is(":checked");
			flg005 = $(this).children("td.005").children("input").is(":checked");
			
			if(clientCd)
			{
				if(flg001)
				{
					data['001']['client_cd'][cnt001] = clientCd;
					data['001']['client_type_1'][cnt001] = clientType;
					data['001']['subrek'][cnt001] = pembukaanFlg ? $(this).children("td.subrekCd").children("input").val() : $(this).children("td.subrek001").children("input").val();
					
					cnt001++;
				}
				
				if(flg004)
				{
					data['004']['client_cd'][cnt004] = clientCd;
					data['004']['client_type_1'][cnt004] = clientType;
					data['004']['subrek'][cnt004] = pembukaanFlg ? $(this).children("td.subrekCd").children("input").val() : $(this).children("td.subrek004").children("input").val();
					
					cnt004++;
				}
				
				if(flg005)
				{
					data['005']['client_cd'][cnt005] = clientCd;
					data['005']['client_type_1'][cnt005] = clientType;
					data['005']['subrek'][cnt005] = pembukaanFlg ? $(this).children("td.subrekCd").children("input").val() : $(this).children("td.subrek005").children("input").val();
					
					cnt005++;
				}
			}
		});
		
		$.ajax({
			'type'     	: 'POST',
    		'url'      	: '<?php echo $this->createUrl('ajxPrepareXml'); ?>',
			'dataType' 	: 'json',
			'data'     	: 	{
								'data' : data,
								'type' : type,
								'cnt001' : cnt001,
								'cnt004' : cnt004,
								'cnt005' : cnt005,
							},
			'success'	: function(data){
							if(data)
							{
								if(data['success'])
								{
									$("#xml_dialog").show();
									$(".xmlContent").hide();
									$(".xmlNotice").show();
									
									var content;
									var x;
									
									if(cnt001)
									{
										$("#xmlContent001").show();
										$("#xmlNotice001").hide();
										
										content = '';
										x = 0;
										
										$.each(data['xml001'],function()
										{
											if(x > 0)content += '&#13;&#10;';
											content += this['xml'];
											x++;
										});
										
										$("#textArea001").html(content);
									}
									
									if(cnt004)
									{
										$("#xmlContent004").show();
										$("#xmlNotice004").hide();
																				
										content = '';
										x = 0;
										
										$.each(data['xml004'],function()
										{
											if(x > 0)content += '&#13;&#10;';
											content += this['xml'];
											x++;
										});
										
										$("#textArea004").html(content);
									}
									
									if(cnt005)
									{
										$("#xmlContent005").show();
										$("#xmlNotice005").hide();
																				
										content = '';
										x = 0;
										
										$.each(data['xml005'],function()
										{
											if(x > 0)content += '&#13;&#10;';
											content += this['xml'];
											x++;
										});
										
										$("#textArea005").html(content);
									}
									
									$("#cnt001").val(cnt001);
									$("#cnt004").val(cnt004);
									$("#cnt005").val(cnt005);
									
									if(cnt001)$("#tabMenu").children("ul").children("li:eq(0)").children("a").click();
									else if(cnt004)$("#tabMenu").children("ul").children("li:eq(1)").children("a").click();
									else if(cnt005)$("#tabMenu").children("ul").children("li:eq(2)").children("a").click();
									
									$("#xml_dialog").dialog({title:'XML',width:'auto',position: { my: "bottom", at: "bottom", of: window }});
								}
								else
								{
									alert('Error ' + data['error_code'] + " "  + data['error_msg']);
								}
							}					
						}
		});
	});
	
	function changeRadio(type)
	{
		if(type == <?php echo AConstant::SDI_TYPE_SUBREK ?>)
		{
			$("#btnRetrieve").prop('disabled',false);
			<?php if(!$retrieved) {?>$("#btnGenerate").prop('disabled',true);<?php } ?>
			$("#tablePengkinian").hide();
			$("#tablePembukaan").show();
		}
		else
		{
			$("#btnRetrieve").prop('disabled',true);
			$("#btnGenerate").prop('disabled',false);
			$("#tablePembukaan").hide();
			$("#tablePengkinian").show();
			
			if(type == <?php echo AConstant::SDI_TYPE_PENGKINIANDATA ?>)
			{
				$("#tablePengkinian").find(".004,.005").children("input[type=checkbox]").hide().prop('checked',false);
			}
			else
			{
				$("#tablePengkinian").find(".004,.005").children("input[type=checkbox]").show();
			}
		}
	}
	
	function checkMode()
	{
		if($(".mode:checked").val()==1)
		{
			$("#date_div").show();
			$("#subrek_div").hide();
			$("#type_span").show();
		}
		else
		{
			$("#date_div").hide();
			$("#subrek_div").show();
			$("#GenXmlSDI_type_0").click();
			$("#type_span").hide();
		}
	}
</script>