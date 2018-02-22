<style>
	.disabled
	{
	 pointer-events: none;
 	  cursor: default;
 	  opacity: 0.6;
 	   color:#050;
 	   display: none;
	}
</style>
<?php
$this->breadcrumbs = array(
	'CBEST Instruction for OTC SECTR VCA' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'CBEST Instruction for OTC SECTR VCA',
		'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	array(
		'label' => 'List',
		'url' => array('index'),
		'icon' => 'list',
		'itemOptions' => array(
			'class' => 'active',
			'style' => 'float:right'
		)
	),
);
?>

<?php AHelper::showFlash($this)
?>
<!-- show flash -->
<?php AHelper::applyFormatting()
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'geninstructionforotcsectrvca-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>
<?php echo $form->errorSummary($model); ?>
<?php
foreach ($modelDetailOtc as $row)
	echo $form->errorSummary(array($row));
?>
<?php
foreach ($modelDetailSectr as $row)
	echo $form->errorSummary(array($row));
?>
<?php
foreach ($modelDetailVca as $row)
	echo $form->errorSummary(array($row));
?>
<?php $sett_reason = Parameter::model()->findAll(array('select'=>"prm_cd_2,prm_cd_2||' - '||prm_desc prm_desc",'condition'=>"prm_cd_1='SETREA' and approved_stat='A' ",'order'=>'prm_cd_2'));?>
<br/>
<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>
<input type="hidden" name="instructiontype" id="instructiontype"/>
<div class="control-group">
    <div class="span2">
        <label>Date</label>
    </div>
    <div class="span2">
        <?php echo $form->textField($model, 'doc_dt', array(
			'placeholder' => 'dd/mm/yyyy',
			'class' => 'tdate span8',
		));
        ?>
    </div>
</div>

<div class="control-group">
    <div class="span2">
        <label>Settlement Reason</label>
    </div>
    <div class="span2">
        <?php echo $form->dropDownList($model,'sett_reason',CHtml::listData($sett_reason, 'prm_cd_2', 'prm_desc'),array('class'=>'span8','prompt'=>'-Choose-','style'=>'font-family:Courier'));?>
    </div>
</div>

<div class="control-group">
    <div class="span2">
        <label>Movement Type</label>
    </div>
    <div class="span3">
        <input type="radio" name="Geninstructionforitcsectrvca[mvmt_type]" id="type_0" value="0" <?php echo $model->mvmt_type == '0' ? 'checked' : ''; ?>
        >
        &nbsp; OTC
        &nbsp;
        <input type="radio" name="Geninstructionforitcsectrvca[mvmt_type]" id="type_1" value="1"  <?php echo $model->mvmt_type == '1' ? 'checked' : ''; ?>
        >
        &nbsp; SECTR
        &nbsp;
        <input type="radio" name="Geninstructionforitcsectrvca[mvmt_type]" id="type_2" value="2"  <?php echo $model->mvmt_type == '2' ? 'checked' : ''; ?>
        >
        &nbsp; VCA
    </div>
   </div>


 <div class="control-group">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => 'Retrieve',
            'id' => 'btnRetrieve',
            'htmlOptions' => array('class' => 'btn btn-small')
        ));
        ?>
        &nbsp;
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Generate Xml',
                'id' => 'btnGenerate',
                'htmlOptions' => array('class' => 'btn btn-small')
            ));
        ?>
        &nbsp;
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Reselect',
                'id' => 'btnReselect',
                'htmlOptions' => array('class' => 'btn btn-small')
            ));
        ?>
    </div>
    
<br/>

<?php
	if (count($modelDetailOtc) > 0)
		echo $this->renderPartial('_otc', array(
			'modelDetailOtc' => $modelDetailOtc,
			'form' => $form
		));
 ?>
<?php
	if (count($modelDetailSectr) > 0)
		echo $this->renderPartial('_sectr', array(
			'modelDetailSectr' => $modelDetailSectr,
			'form' => $form
		));
 ?>
<?php
	if (count($modelDetailVca) > 0)
		echo $this->renderPartial('_vca', array(
			'modelDetailVca' => $modelDetailVca,
			'form' => $form
		));
 ?>

<div id="xml_dialog" style="display:none">
    <?php
	$tabs = array(
		array(
			'label' => 'DFOP',
			'content' => $this->renderPartial('xml', array('instructiontype' => 'dfop'), true, false),
		),
		array(
			'label' => 'RFOP',
			'content' => $this->renderPartial('xml', array('instructiontype' => 'rfop'), true, false),
		),
		array(
			'label' => 'SECTRS',
			'content' => $this->renderPartial('xml', array('instructiontype' => 'sectrs'), true, false),
		),
		array(
			'label' => 'DVP',
			'content' => $this->renderPartial('xml', array('instructiontype' => 'dvp'), true, false),
		),
		array(
			'label' => 'RVP',
			'content' => $this->renderPartial('xml', array('instructiontype' => 'rvp'), true, false),
		),
		array(
			'label' => 'VCA',
			'content' => $this->renderPartial('xml', array('instructiontype' => 'exe'), true, false),
		)
	);

	$this->widget('bootstrap.widgets.TbTabs', array(
		'type' => 'pills', // 'tabs' or 'pills'
		'tabs' => $tabs,
		'htmlOptions' => array('id' => 'tabMenu'),
	));
    ?>

</div>

<?php echo $form->datePickerRow($model, 'dummy_date', array(
		'label' => false,
		'style' => 'display:none'
	));
?>


	
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Please Wait...',
            'modal'=>true,
            'autoOpen'=>false,// default is true
            'closeOnEscape'=>false,
            'resizable'=>false,
            'draggable'=>false,
            'height'=>120,
            'open'=>// supply a callback function to handle the open event
                    'js:function(){ // in this function hide the close button
                         $(".ui-dialog-titlebar-close").hide();
						 //$(".ui-dialog-content").hide();
						
                    }'
         ))
);

	$this->widget('bootstrap.widgets.TbProgress',
    array('percent' => 100, // the progress
        	'striped' => true,
        	'animated' => true,
    )
);
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>

var opt = {
        autoOpen: false,
        modal: true,
       // width: 550,
        height:120,
        title: 'Please Wait...'
};

	$(document).ajaxStart(function()
	{
	//	$('#mywaitdialog').dialog('open');
		$('#mywaitdialog').dialog(opt).dialog('open');
	});

	$(document).ajaxStop(function()
	{
		//$('#showloading').hide();
		$('#mywaitdialog').dialog('close');
	});

	var rowCount=0;
	var xml_flg='<?php echo $xml_flg?>';
	
	if($('#type_0').is(':checked'))
	{
		rowCount =  '<?php echo count($modelDetailOtc); ?>';
	}
	else if($('#type_1').is(':checked'))
	{
		rowCount =  '<?php echo count($modelDetailSectr); ?>';
	}
	else
	{
		rowCount =  '<?php echo count($modelDetailVca); ?>';	
	}
	
	init();
	function init()
	{
	$('.tdate').datepicker({'format':'dd/mm/yyyy'});
	if(rowCount==0)
	{
		$('#btnGenerate').prop('disabled',true);
	}
	
	}
	$('#btnRetrieve').click(function(){
	$('#scenario').val('retrieve');
	});
	$('#btnGenerate').click(function(){
	$('#scenario').val('generate');
	$('#rowCount').val(rowCount);
	$('#mywaitdialog').dialog('open');
	});
	$('#btnReselect').click(function(){
	$('#scenario').val('reselect');
	
	});
	
	if(xml_flg)
	{
		$('#xml_dialog').show();
		getXML();
		$("#xml_dialog").dialog({title:'XML',width:'80%',minHeight:300,position: { my: "bottom", at: "bottom", of: window }});
		var obj = $("#tabMenu").children("ul");
		
		if($('#type_0').is(':checked'))
		{
			obj.children("li:eq(0)").children("a").removeClass('disabled');
			obj.children("li:eq(1)").children("a").removeClass('disabled');
			obj.children("li:eq(2)").children("a").addClass('disabled');
			obj.children("li:eq(3)").children("a").removeClass('disabled');
			obj.children("li:eq(4)").children("a").removeClass('disabled');
			obj.children("li:eq(5)").children("a").addClass('disabled');
			obj.children("li:eq(0)").children("a").click();	
			
		}
		else if($('#type_1').is(':checked'))
		{
			obj.children("li:eq(0)").children("a").addClass('disabled');
			obj.children("li:eq(1)").children("a").addClass('disabled');
			obj.children("li:eq(2)").children("a").removeClass('disabled');
			obj.children("li:eq(3)").children("a").addClass('disabled');
			obj.children("li:eq(4)").children("a").addClass('disabled');
			obj.children("li:eq(5)").children("a").addClass('disabled');
			obj.children("li:eq(2)").children("a").click();	
		}
		else
		{
			obj.children("li:eq(0)").children("a").addClass('disabled');
			obj.children("li:eq(1)").children("a").addClass('disabled');
			obj.children("li:eq(2)").children("a").addClass('disabled');
			obj.children("li:eq(3)").children("a").addClass('disabled');
			obj.children("li:eq(4)").children("a").addClass('disabled');
			obj.children("li:eq(5)").children("a").removeClass('disabled');
			obj.children("li:eq(5)").children("a").click();
		}
	}
	
	function getXML()
	{
		var obj = $("#tabMenu").children("ul");
		var instructiontype ='dfop';
		//prepareXML(instructiontype);
		
		obj.children("li:eq(0)").children("a").click(function(){
				instructiontype ='dfop';
				prepareXML(instructiontype);
				
		});
		obj.children("li:eq(1)").children("a").click(function(){
				instructiontype ='rfop';
				prepareXML(instructiontype);
		});
		obj.children("li:eq(2)").children("a").click(function(){
				instructiontype ='sectrs';
				prepareXML(instructiontype);
		})
		obj.children("li:eq(3)").children("a").click(function(){
				instructiontype ='dvp';
				prepareXML(instructiontype);
		})
		obj.children("li:eq(4)").children("a").click(function(){
				instructiontype ='rvp';
				prepareXML(instructiontype);
		})
		obj.children("li:eq(5)").children("a").click(function(){
				instructiontype ='exe';
				prepareXML(instructiontype);
		});
		

	}
	
	
	function prepareXML(instructiontype)
	{
		var settle_date = $('#Geninstructionforitcsectrvca_doc_dt').val();
		var menu_name ='';
		var obj = $("#tabMenu").children("ul");
		
		if($('#type_0').is(':checked'))
		{
			menu_name ='OTC';
			
		}
		else if($('#type_1').is(':checked'))
		{
			menu_name ='SECTRS';	
		}
		else
		{
			menu_name ='VCA';
		}
			$.ajax({
			'type'     	: 'POST',
    		'url'      	: '<?php echo $this->createUrl('ajxPrepareXml'); ?>',
			'dataType' 	: 'json',
			'data'     	: 	{
								'instructiontype':instructiontype,
								'settle_date':settle_date,
								'menu_name':menu_name
							},
			'success'	: function(data)
						{
							content = '';
							x = 0;
							
							$.each(data['xml'],function()
							{
								if(x > 0)content += '&#13;&#10;';
								content += this['xml'];
								x++;
							});
							
							if(data.count==2 || data.count==0)
							{
								$('#xmlContent'+instructiontype).hide();
							}
							else
							{
								$('#xmlNotice'+instructiontype).hide();
								$('#textArea'+instructiontype).html(content)
								$('#btnDownload'+instructiontype).attr('href',data.url);
								$('#btnDownload'+instructiontype).click();
							//$("#tabMenu").children("ul").children("li:eq(2)").addClass("active");
							}
							
						}
		
			});
	}
	
</script>