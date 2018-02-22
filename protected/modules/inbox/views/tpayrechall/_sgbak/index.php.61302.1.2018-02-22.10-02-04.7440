<?php
$this->breadcrumbs=array(
	'Voucher Inbox'=>array('index'),
	'Unprocessed Voucher',
);

$this->menu=array(
	array('label'=>'Unprocessed Voucher Inbox', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Unprocessed','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Processed','url'=>array('indexProcessed'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),	
	array('label'=>'List','url'=>Yii::app()->request->baseUrl.'?r=finance/tpayrech/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tmanyheader-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php AHelper::applyScrollableGridView(true); ?> <!-- add vertical scrollbar to grid view -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/template/_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div class="tableContainer">
	<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
		'id'=>'tmanyheader-grid',
	    'type'=>'striped bordered condensed',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
	    'filterPosition'=>'',
	    
	    'bulkActions' => array(
			'actionButtons' => array(
			/*
				array(
					'buttonType' => 'button',
					'type'  => 'secondary',
					'size'  => 'small',
					'id'	=> 'btnApproveKbbInbox',
					'icon'  => 'ok',
					'label' => 'Approve All KBB',
					'click' => 'js:function(){						
						$.get("'.$this->createUrl('Approveallkbb').'", function(data, status){
					        //alert("Data: " + data + "\nStatus: " + status);
					        window.location.reload();
					    });
					}'
				),
			 *
			 */
				array(
					'buttonType' => 'button',
					'size' => 'small',
					'id'	=>'btnApproveInbox',
					'icon'=> 'ok',
					'label' => 'Approve Checked',
					'click' => 'js:function(checked_element){
							var seq = [];
							var clientCd = [];
							var amount = [];
							var status = [];
							var payrecType = [];
							var currObj;
							
							for(var i=0;i<checked_element.length;i++)
							{
								currObj = $("#"+checked_element[i].id);
								seq[i] = checked_element[i].value;
								status[i] = currObj.parent().siblings(".status").html();
								clientCd[i] = currObj.parent().siblings(".clientCd").html();
								payrecType[i] = currObj.parent().siblings(".payrecNum").html().substr(4,1);
								amount[i] = parseInt(setting.func.number.removeCommas(currObj.parent().siblings(".currAmt").html()));
							}
								
							$.ajax({
								type		: "POST",
								url			: "'.$this->createUrl('ajxCheckAP').'",
								data		: 	{
													seq  		: seq,
													clientCd	: clientCd,
													status		: status,
													payrecType	: payrecType,
													amount		: amount
												},
								dataType	: "json",
								success		: function(data){
									if(data["error_code"] < 0)
									{
										alert("Error Approve: "+ data["error_code"] + ". " + data["error_msg"]);
										$("#btnApproveInbox").css("visibility","visible");
										$("#showloading").hide();	
									}
									else 
									{
										// AS : 22 Nov 2016
										// Added IF below so the confirmation window pops up whenever only 1 item is being approved, otherwise it does not pop up
										if(checked_element.length == 1){
											var x = 0;
											var y = 0;
											var skippedUpdateSeq = [];
											
											$.each(data["update_seq"], function(i, value)
											{
												var cum_bal = data["cum_bal"][x] * -1;
												var fo_balance = data["fo_balance"][x] * -1;
												var amount = parseInt(data["amount"][x]);
												var basic_limit = parseInt(data["basic_limit"][x]);
												var fo_stockvaldisc = parseInt(data["fo_stockvaldisc"][x]);
												var isnotify = data["isnotify"];
												
												if(((cum_bal + fo_balance + amount) > (basic_limit + fo_stockvaldisc)) && isnotify == "Y")
												{
													var confirmText = clientCd[x] + ": Theoritical AR + Today Trading + Payment Amount is greater than Basic Limit + Disc Stock. Do you want to continue?\n\n";
													confirmText += "Theoretical AR \t\t : " + setting.func.number.addCommasDec(cum_bal) + "\n";
													confirmText += "Today Trading \t\t : " + setting.func.number.addCommasDec(fo_balance) + "\n";
													confirmText += "Payment Amount \t : " + setting.func.number.addCommasDec(amount) + "\n";
													confirmText += "Basic Limit \t\t\t : " + setting.func.number.addCommasDec(basic_limit) + "\n";
													confirmText += "Disc Stock \t\t\t : " + setting.func.number.addCommasDec(fo_stockvaldisc);
													
													if(!confirm(confirmText))
													{
														skippedUpdateSeq[y++] = value;
													}
												}
												
												x++;
											});
											
											var url = "'.Yii::app()->createUrl("/inbox/tpayrechall/approveChecked").'";
											var approvedSeqUrl = "";
											
											$.each(checked_element, function(i, value)
											{
												if(skippedUpdateSeq.indexOf(this.value) == -1)
												{
													approvedSeqUrl += "&arrid[]=" + this.value;
												}
											});
											
											if(approvedSeqUrl)
											{
												window.location.href = url + approvedSeqUrl;
											}
											else 
											{
												$("#btnApproveInbox").css("visibility","visible");
												$("#showloading").hide();	
											}
										}else{
											//var url = "'.Yii::app()->createUrl("/inbox/tpayrechall/approveChecked").'";
											//var approvedSeqUrl = "";
											//$.each(checked_element, function(i, value)
											//{
											//	approvedSeqUrl += "&arrid[]=" + this.value;
											//});
											//window.location.href = url + approvedSeqUrl;
											
											var thisForm = $("#voucher-checked-form"),
												hdnField = $("#hdn-voucher-id"),
												index = 0;
		
											$(".cls-clone-result").remove();
											$.each(checked_element, function(i, value)
											{
												if(index > 0) {
													var jNewField = hdnField.clone();
													jNewField.removeAttr("id");
													jNewField.addClass("cls-clone-result");
													jNewField.val(this.value);
													thisForm.append(jNewField);
												} else {
													hdnField.val(this.value);
												}
												index++;
											});
											thisForm.submit();
										}
									}
								}
							});
						}'
				),
				array(
					'buttonType' => 'button',
					'type'  => 'secondary',
					'size'  => 'small',
					'id'	=> 'btnRejectInbox',
					'icon'  => 'remove',
					'label' => 'Reject Checked',
					'click' => 'js:function(checked_element){
							var temp = "&";
							for(var i =0;i<checked_element.length;i++)	
								temp += ("arrid[]="+checked_element[i].value)+"&";
							temp = temp.substring(0,temp.length -1);
							
							showPopupModal("Reject Reason","'.(Yii::app()->getBaseUrl(true).'/index.php?r=inbox/tpayrechall/AjxPopRejectChecked').'"+temp);	
					}'
				)
			
			),
			'checkBoxColumnConfig' => array(
			    'name' => 'id',
			    'value'=> '$data->update_seq'
			),
		),
		'columns'=>array(
			array('name'=>'payrec_num','htmlOptions'=>array('class'=>'payrecNum')),
			'folder_cd',
			array('name'=>'payrec_date','value'=>'Datetime::createFromFormat(\'Y/m/d H:i:s\',$data->payrec_date)->format(\'d/m/y\')'),
			array('name'=>'client_cd','htmlOptions'=>array('class'=>'clientCd')),
			'client_type',
			array('name'=>'curr_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right','class'=>'currAmt')),
			'remarks',
			'user_id',
			array('name'=>'update_date','value'=>'Datetime::createFromFormat(\'Y-m-d H:i:s\',$data->update_date)->format(\'d/m/y H:i:s\')'),
			array('name'=>'status','value'=>'AConstant::$inbox_stat[$data->status]','htmlOptions'=>array('class'=>'status')),
			array(
				'class'	  =>'bootstrap.widgets.TbButtonColumn',
				'template'=>'{view}{approve}{reject}',
				'buttons'=>array(
					'view'=>array(
						'url' =>'Yii::app()->createUrl("/inbox/tpayrechall/view", array("update_date"=>$data->update_date,"update_seq"=>$data->update_seq))',
					),
			        'approve'=>array(
			        	'label'=>'approve', 
			            'icon' =>'ok',                          
			            'url'  =>'Yii::app()->createUrl("/inbox/tpayrechall/approve", array("id" => $data->primaryKey))',				// AH : change
			            'click' => 'js:function(e)
			            {				
							var status = $(this).parent().siblings(".status").html();
							var clientCd = $(this).parent().siblings(".clientCd").html();
							var payrecType = $(this).parent().siblings(".payrecNum").html().substr(4,1);
							var amount = parseInt(setting.func.number.removeCommas($(this).parent().siblings(".currAmt").html()));
							var thisObj = $(this);
							
							if(status == "Insert" && clientCd && payrecType == "P")
							{
								e.preventDefault();
																
								var url = $(this).attr("href");
								var updateSeq = url.substr(url.indexOf("id=") + 3);
								
								$.ajax({
									type		: "POST",
									url			: "'.$this->createUrl('ajxCheckAP').'",
									data		: 	{
														 seq  		: updateSeq,
														 clientCd	: clientCd
													},
									dataType	: "json",
									success		: function(data){
										if(data["error_code"] < 0)
										{
											alert("Error Approve: "+ data["error_code"] + ". " + data["error_msg"]);
										}
										else 
										{
											var cum_bal = data["cum_bal"] * -1;
											var fo_balance = data["fo_balance"] * -1;
											//var amount = data["amount"];
											var basic_limit = parseInt(data["basic_limit"]);
											var fo_stockvaldisc = parseInt(data["fo_stockvaldisc"]);
											var isnotify = data["isnotify"];
																						
											if(((cum_bal + fo_balance + amount) > (basic_limit + fo_stockvaldisc)) && isnotify == "Y")
											{
												var confirmText = clientCd + ": Theoritical AR + Today Trading + Payment Amount is greater than Basic Limit + Disc Stock. Do you want to continue?\n\n";
												confirmText += "Theoretical AR \t\t : " + setting.func.number.addCommasDec(cum_bal) + "\n";
												confirmText += "Today Trading \t\t : " + setting.func.number.addCommasDec(fo_balance) + "\n";
												confirmText += "Payment Amount \t : " + setting.func.number.addCommasDec(amount) + "\n";
												confirmText += "Basic Limit \t\t\t : " + setting.func.number.addCommasDec(basic_limit) + "\n";
												confirmText += "Disc Stock \t\t\t : " + setting.func.number.addCommasDec(fo_stockvaldisc);
												
												if(confirm(confirmText))
												{
													window.location.href = url;
												}
											}
											else 
											{
												window.location.href = url;
											}
										}

										thisObj.css("visibility","visible");
										$("#showloading").hide();
									}
								});
							}
			            }' 
			         ),
			         'reject'=>array(
			         	'label'=>'reject',
			            'icon'=> 'remove',
			            'url' => 'Yii::app()->createUrl("/inbox/tpayrechall/ajxPopReject", array("id" => $data->primaryKey))',			// AH : change
			            'click'=>'js:function(e){
			            	e.preventDefault();
							showPopupModal("Reject Reason",this.href);
			            }'
			         ),
	        	 )
				
			),
		),
	)); ?>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'voucher-checked-form',
	'action'=>Yii::app()->createUrl("/inbox/tpayrechall/approveChecked"),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
<input type="hidden" value="" name="arrid[]" id="hdn-voucher-id" />
<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	$(window).resize(function()
	{
		$(".tableContainer").offset({left:7});
		$(".tableContainer").css('width',($(window).width()-10));
	});
	$(window).resize();	
</script>
