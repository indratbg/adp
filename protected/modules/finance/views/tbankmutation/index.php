
<style>
	#Tvd55-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableTbankmutation
	{
		background-color:#C3D9FF;
		width:100%;
	}
	
    #tableTbankmutation thead, #tableTbankmutation tbody {

	width: 1300px !important;
	}
	#tableTbankmutation thead, #tableTbankmutation tbody
	{
		display:block;
	}
	
	#tableTbankmutation tbody
	{
		
		max-height:280px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php

$this->breadcrumbs=array(
	'Upload Rekening Dana Mutation'=>array('index'),
	'List',
);

$this->menu=array(
	//array('label'=>'Tvd55', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Upload Rekening Dana Mutation', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
		
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tbankmutation-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
 ?>
<?php 
	if($model){
		foreach($model as $row)
			echo $form->errorSummary(array($row));
	} 
?>
	
			<?php echo $form->errorSummary($modeldummy); ?>
			<?php echo $form->errorSummary($modelReport); ?>
			<?php echo $form->errorSummary($modelInterest); ?>
			<?php echo $form->errorSummary($modelUploadFail); ?>
			
<?php
$branch=Branch::model()->findAllBySql("select brch_cd, brch_name, brch_cd as dataval
									from mst_branch,
									(select count(1) cnt
									from mst_parameter
									where prm_cd_1 = 'KBBGRP') a
									where a.cnt = 0
									union
									select prm_cd_2, prm_desc, prm_desc
									from mst_parameter
									where prm_cd_1 = 'KBBGRP'
									order by 1");

?>

<br/>
<input type="hidden" id="rowCount" name="rowCount"/>
<input type="hidden" id="scenario" name="scenario"/>
<input type="hidden" id="authorizedBackDated" name="authorizedBackDated" />		
		
<div id="progressbar"> 
<?php

$this->widget('bootstrap.widgets.TbProgress',
    array('percent' => 100, // the progress
        	'striped' => true,
        	'animated' => true,
    )
);
?>
</div>
<div class="control-group">
	<div class="row-fluid">
		<div class="span1">
			<label>From</label>
		</div>
		<div class="span1">
			<?php echo $form->textField($modeldummy,'from_dt',array('label'=>false,'class'=>'span tdate','placeholder'=>'dd/mm/yyyy','style'=>'width:80px;height:15px;margin-left:-40px;'));?>
		</div>
			<div class="span1" style="margin-left:-15px;">
					<label>To</label>
			</div>
<div class="span1" >
	<?php echo $form->textField($modeldummy,'to_dt',array('label'=>false,'class'=>'span tdate','placeholder'=>'dd/mm/yyyy','style'=>'width:80px;height:15px;margin-left:-60px;'));?>
</div>
<div class="span1" style="margin-left:-30px;">
	<label>Type</label>
</div>
<div class="span1">
	<?php echo $form->dropDownList($modeldummy,'type_mutasi',CHtml::listData(Parameter::model()->findAll("prm_cd_1='MUTASI' AND APPROVED_STAT='A'"), 'prm_cd_2', 'prm_desc'),array('class'=>'span','style'=>'width:130px;margin-left:-50px;','prompt'=>'-ALL-'));?>
</div>
<div class="span1" style="margin-left:30px;">
	<label>Branch</label>
</div>
<div class="span1">
		<?php echo $form->dropDownList($modeldummy,'branch',CHtml::listData($branch,'dataval','brch_name'),array('class'=>'span','style'=>'width:120px;margin-left:-35px;','prompt'=>'-All-'));?>
</div>
<div class="span1" style="margin-left:30px;">
	<label>Bank RDI</label>
</div>
<div class="span1">
		<?php echo $form->dropDownList($modeldummy,'bank_rdi',CHtml::listData(Fundbank::model()->findAll("default_flg='Y'"), 'bank_cd', 'bank_name'),array('class'=>'span','style'=>'width:120px;margin-left:-20px;','prompt'=>'-Select-'));?>
</div>


		<div class="span1">
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnRetrieve',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'RETRIEVE',
		'htmlOptions' => array('style'=>'margin-left:3em;','class'=>'btn-small'),
	)); ?>
			
		</div>
		
	</div>

</div>

<div class="control-group">
	<div class="row-fluid">
		
		<div class="span1">
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnJournal',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'JOURNAL',
		'htmlOptions' => array('style'=>'margin-left:0px','class'=>'btn-small'),
	)); ?>
		</div>
		<div class="span1">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnPrint',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'PRINT',
		'htmlOptions' => array('style'=>'margin-left:10px','class'=>'btn-small'),
	)); ?>
		</div>
		
		<div class="span1">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnImport',
		'buttonType' => 'submit',
		'type'=>'default',
		'label'=>'IMPORT',
		'htmlOptions' => array('style'=>'margin-left:0em; ;width:80px;','class'=>'btn-small')
	)); ?>
	
		</div>
		<div class="span5">
				<?php echo CHtml::activeFileField($modeldummy, 'file_upload'); ?>
		</div>

	
	</div>
</div>

<br />
<div style="background-color: #white; border: 0px solid 00000; overflow: auto; height: 410px;padding-bottom: -20px; width: 100%;margin-top: -20px;">
	<br/>
	
<table id='tableTbankmutation'  class='table-bordered table-condensed' >
	<thead>
		<tr>
			<th id="header1">Tanggal Efektif</th>
			<th id="header2">Tanggal Timestamp</th>
			<th id="header3">From Bank</th>
			<th id="header4">Instruction From</th>
			<th id="header5">RDN</th>
			<th id="header6">Brch</th>
			<th id="header7">Client Cd</th>
			<th id="header8">Client Name</th>
			<!--<th id="header8">Beginning Balance</th>-->
			<th id="header9">Transaction Value</th>
			<th id="header10" style="font-size: 7pt;"><input type="checkbox" id="checkBoxAll" value="1" onClick= "changeAll()"/></th>
			<th id="header11">Remark</th>
			<th id="header12">Input Remark</th>
			
			<!--<th id="header13"></th>-->
			
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
	
		foreach($model as $row){
	?>
		<tr id="row<?php echo $x ?>">
		<td width="100px">
			<?php echo $form->textField($row,'tanggalefektif',array('readonly'=>$checkAll?true:false,'class'=>'span tdate','name'=>'Tbankmutation['.$x.'][tanggalefektif]'));?>
		</td>
		<td width="120px">
			<?php echo $form->textField($row,'typetext',array('class'=>'span','id'=>'Tbankmutation_'.$x.'_typetext','name'=>'Tbankmutation['.$x.'][typetext]','maxlength'=>26,'style'=>'display:none;'));?>
			<?php echo $form->textField($row,'bankid',array('class'=>'span','name'=>'Tbankmutation['.$x.'][bankid]','style'=>'font-size:8pt;height:20px;','maxlength'=>5,'style'=>'display:none;'));?>
			
		
				<?php echo $form->textField($row,'typemutasi',array('class'=>'span','name'=>'Tbankmutation['.$x.'][typemutasi]','maxlength'=>5,'style'=>'display:none;'));?>
				<?php echo $form->textField($row,'bankreference',array('class'=>'span','name'=>'Tbankmutation['.$x.'][bankreference]','maxlength'=>5,'style'=>'display:none;'));?>
					<?php echo $form->textField($row,'remark',array('class'=>'span','name'=>'Tbankmutation['.$x.'][remark]','maxlength'=>255,'style'=>'display:none;'));?>
			<?php //echo $form->textField($row,'tanggalefektif',array('class'=>'span','name'=>'Tbankmutation['.$x.'][tanggalefektif]','maxlength'=>255,'style'=>'display:none;'));?>
			<?php echo $form->textField($row,'transactiontype',array('class'=>'span','name'=>'Tbankmutation['.$x.'][transactiontype]','maxlength'=>255,'style'=>'display:none;'));?>
			
			<?php  echo $form->textField($row,'tanggaltimestamp',array('placeholder'=>'dd/mm/yyyy H:i','class'=>'span','name'=>'Tbankmutation['.$x.'][tanggaltimestamp]','style'=>'font-size:8pt;height:20px;','readonly'=>true));?>
			<?php echo $form->textField($row,'tgl_time',array('class'=>'span','name'=>'Tbankmutation['.$x.'][tgl_time]','maxlength'=>255,'style'=>'display:none;'));?>	
		</td>
		<td width="60px">
				<?php echo $form->textField($row,'frombank',array('class'=>'span','name'=>'Tbankmutation['.$x.'][frombank]','maxlength'=>5,'readonly'=>true));?>
		</td>
		<td width="100px">
			<?php echo $form->textField($row,'instructionfrom',array('class'=>'span','name'=>'Tbankmutation['.$x.'][instructionfrom]','style'=>'font-size:8pt;height:20px;','maxlength'=>15,'readonly'=>true));?>
		</td>
		<td width="120px">
			<?php  echo $form->textField($row,'rdn',array('class'=>'span','name'=>'Tbankmutation['.$x.'][rdn]','style'=>'font-size:8pt;height:20px;','maxlength'=>25,'readonly'=>true));?>
		</td>
		<td width="40px">
			<?php  echo $form->textField($row,'branch_code',array('class'=>'span','name'=>'Tbankmutation['.$x.'][branch_code]','style'=>'font-size:8pt;height:20px;','readonly'=>true));?>
		</td>
		<td width="90px">
			<?php  echo $form->textField($row,'client_cd',array('class'=>'span','id'=>'Tbankmutation_'.$x.'_client_cd','name'=>'Tbankmutation['.$x.'][client_cd]','style'=>'font-size:8pt;height:20px;','readonly'=>$row->frombank=='CIMB'?false:true));?>
		</td>
		<td width="200px">
			<?php  echo $form->textField($row,'namanasabah',array('class'=>'span','name'=>'Tbankmutation['.$x.'][namanasabah]','maxlength'=>25,'style'=>'font-size:8pt;height:20px;','readonly'=>true));?>
		</td>
		<!--<td width="120px">
			<?php echo $form->textField($row,'beginningbalance',array('class'=>'span tnumber','value'=>trim($row->beginningbalance),'name'=>'Tbankmutation['.$x.'][beginningbalance]','style'=>'font-size:8pt;height:20px;text-align:right','maxlength'=>18,'readonly'=>true));?>
		</td>-->
		<td width="120px">
			<?php echo $form->textField($row,'transactionvalue',array('class'=>'span tnumber','value'=>trim($row->transactionvalue),'name'=>'Tbankmutation['.$x.'][transactionvalue]','style'=>'font-size:8pt;height:20px;text-align:right','maxlength'=>18,'readonly'=>true));?>
		</td>
		<td width="20px">
			<?php echo $form->checkBox($row,'save_flg',array('disabled'=>$row->acct_stat =='C'?true:false,'onchange'=>"save_check($x)",'id'=>"save_flg_$x",'class'=>'checkBoxDetail','value' => 'Y','name'=>'Tbankmutation['.$x.'][save_flg]')); ?>
			
			<?php echo $form->textField($row,'safe_flg',array('id'=>"safe_flg_$x",'class'=>'checkBoxDetail2','name'=>'Tbankmutation['.$x.'][safe_flg]','style'=>'display:none;'));?>
		</td>
		<td width="200px">
			<?php echo $form->textField($row,'remark',array('class'=>'span','name'=>'Tbankmutation['.$x.'][remark]','style'=>'font-size:8pt;height:20px;','maxlength'=>30,'readonly'=>true));?>
		</td>
		<td width="200px">
			<?php echo $form->textField($row,'input_remark',array('class'=>'span','id'=>'Tbankmutation_'.$x.'_input_remark','name'=>'Tbankmutation['.$x.'][input_remark]','style'=>'font-size:8pt;height:20px;','maxlength'=>50,'readonly'=>false));?>
		</td>
		
		<!--<td>
		
			<?php //echo $form->label($row,$row->typetext,array('style'=>'font-size:8pt;'));?>
		</td>-->
		</tr>
	<?php $x++;} ?>
	</tbody>	
</table>


</div>



<!--<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>-->






<?php echo $form->datePickerRow($modeldummy,'tanggaltimestamp_date',array('style'=>'display:none','label'=>false,'disabled'=>true));?>		
<br id="temp"/><br id="temp"/>

<?php $this->endWidget(); ?>


<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'In Progress',
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

<?php 	
	$base = Yii::app()->baseUrl;
	$urlDateCss = $base.'/css/jquery.datetimepicker.css';
	$urlDate = $base.'/js/jquery.datetimepicker.js'; 

?>

<link href="<?php echo $urlDateCss ;?>" rel="stylesheet" type="text/css"/>
<script src="<?php echo $urlDate ;?>" type="text/javascript"></script>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
var rowCount =<?php echo count($model) ?>;
var url = '<?php echo $url ;?>';
var authorizedBackDated = true;
var checkAll ='<?php echo $checkAll?>';
var url_fail ='<?php echo $url_fail ?>';
$('#progressbar').hide();
if(checkAll){
	$('#checkBoxAll').prop('checked',true);
	$('#checkBoxAll').prop('disabled',true);
	//$('.checkBoxDetail').prop('disabled',true);
	$('.checkBoxDetail2').val('Y');
}





function save_check(num){

if($('#save_flg_'+num).is(':checked')){
	$('#safe_flg_'+num).val('Y');

}
else{
	$('#safe_flg_'+num).val('N');
}	
}



//$('.datetimepicker').datetimepicker({format:'d/m/Y H:i'});
//$('.datetimepicker').datetimepicker('update');
$('.tdate').datepicker({format:'dd/mm/yyyy'});
$('#Tbankmutation_from_dt').datepicker('update');
$('#Tbankmutation_to_dt').datepicker('update');

$(document).ready(function()
	{
	$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateBackDated'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedBackDated = false;
				}
			}
		});

});

$(document).ajaxComplete(function( event, xhr, settings ) {
		if (settings.url === "<?php echo $this->createUrl('ajxValidateBackDated'); ?>" ) 
		{

      		if(!authorizedBackDated)
      		{
      			//var date = new Date();
				///var month = date.getMonth();
				//var year = date.getFullYear();
				
				////month = month + 1;
				//if(month < 10)month = '0'+month;
	
			
			}
      	}
  	});

function getYesterdaysDate() {
    var date = new Date();
    date.setDate(date.getDate()-1);
    return date.getFullYear()  + '-' + (date.getMonth()+1) + '-' + date.getDate() + ' 00:00:00';
}


init();

function init(){
	
	var x;
	for(x=1;x<=rowCount;x++){
		remark(x);
	}
}

function remark(num){
	var client_cd= $('#Tbankmutation_'+num+'_client_cd').val();
	var typetext=$('#Tbankmutation_'+num+'_typetext').val();
	var frombank=$('#Tbankmutation_'+num+'_frombank').val();
	if(typetext=='Setoran'){
		var text= typetext+' '+client_cd;
		$('#Tbankmutation_'+num+'_input_remark').val(text);
	}
	else if(typetext=='Interest'){
		
		if(frombank=='NGA'){
				$('#Tbankmutation_'+num+'_input_remark').val('Bunga CIMB');
		}
	else{
		$('#Tbankmutation_'+num+'_input_remark').val('Bunga BCA');
	}
		
	}
	else{
		$('#Tbankmutation_'+num+'_input_remark').val(typetext);
	}
	
}



$('#Tbankmutation_type_mutasi').change(function(){
	//alert('tet');
	var type=$('#Tbankmutation_type_mutasi').val();
	if(type=='S'){
	$('.Typejournal').html('Setoran');
	
	}
	else {
		$('.Typejournal').html('Interest');
	
	}

});

if(rowCount==0){
	$('#tableTbankmutation').hide();
}
else{
	$('#tableTbankmutation').show();
}

$('#datetimepicker').datetimepicker({format:'d/m/Y H:i:s'});
	$("#Tbankmutation_from_dt").datepicker({format : "dd/mm/yyyy"});
	$("#Tbankmutation_to_dt").datepicker({format : "dd/mm/yyyy"});
	<?php $day=date('d');
	$mounth=date('m');
	$year=date('Y'); ?>
	//$("#Tbankmutation_from_dt").datepicker("setDate",Date(<?php echo $year ?>,<?php echo $mounth?>,<?php echo $day?>));
	//$("#Tbankmutation_to_dt").datepicker("setDate",new Date(<?php echo $year ?>,<?php echo $day?>,<?php echo $mounth?>));
	
	
	//adjustWidthNull();
	
	
	/*
	if(authorizedBackDated)$("#authorizedBackDated").val(1);
		else
			$("#authorizedBackDated").val(0);
		*/	
	$('#btnRetrieve').click(function()
	{
		$('#scenario').val('filter');
		
		
	});
	$('#btnPrint').click(function()
	{
		$('#scenario').val('print');
		
		
	});
	$('#btnImport').click(function()
	{
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('import');
	});
	
	$('#btnJournal').click(function()
	{
		$('#scenario').val('journal');
		$('#rowCount').val(rowCount);
		$('#progressbar').show();
		if(authorizedBackDated)$("#authorizedBackDated").val(1);
		else
			$("#authorizedBackDated").val(0);
	});
	
	var x;
	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	function adjustWidth(){
		
		$("#header1").width($("#tableTbankmutation tbody tr:eq(0) td:eq(0)").width());
		$("#header2").width($("#tableTbankmutation tbody tr:eq(0) td:eq(1)").width());
		$("#header3").width($("#tableTbankmutation tbody tr:eq(0) td:eq(2)").width());
		$("#header4").width($("#tableTbankmutation tbody tr:eq(0) td:eq(3)").width());
		$("#header5").width($("#tableTbankmutation tbody tr:eq(0) td:eq(4)").width());
		$("#header6").width($("#tableTbankmutation tbody tr:eq(0) td:eq(5)").width());
		$("#header7").width($("#tableTbankmutation tbody tr:eq(0) td:eq(6)").width());
		$("#header8").width($("#tableTbankmutation tbody tr:eq(0) td:eq(7)").width());
		$("#header9").width($("#tableTbankmutation tbody tr:eq(0) td:eq(8)").width());
		$("#header10").width($("#tableTbankmutation tbody tr:eq(0) td:eq(9)").width());
		$("#header11").width($("#tableTbankmutation tbody tr:eq(0) td:eq(10)").width());
		$("#header12").width($("#tableTbankmutation tbody tr:eq(0) td:eq(11)").width());
	}
	function adjustWidthNull(){
		
		$("#header1").width("125px");
		$("#header2").width("40px");
		$("#header3").width("75px");
		$("#header4").width("76px");
		$("#header5").width("35px");
		$("#header6").width("75px");
		$("#header7").width("116px");
		$("#header8").width("76px");
		$("#header9").width("72px");
		$("#header10").width("62px");
		$("#header11").width("12px");
		$("#header12").width("62px");
		//$("#header13").width();
		
	}

	function changeAll()
	{
		if($("#checkBoxAll").is(':checked'))
		{
			$(".checkBoxDetail").prop('checked',true);
			$(".checkBoxDetail2").prop('checked',true);
			$(".checkBoxDetail2").val('Y');
		}
		else
		{
			$(".checkBoxDetail").prop('checked',false);
			$(".checkBoxDetail2").prop('checked',false);
			$(".checkBoxDetail2").val('N');
		}
	}
	$('.tdate').datepicker({format : "dd/mm/yyyy"});
	
	
	$('#Tbankmutation_from_dt').change(function(){
		$('#Tbankmutation_to_dt').val($('#Tbankmutation_from_dt').val());
		
	});
	
	if(url !=''){
		 var myWindow = window.open('<?php echo $url;?>&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false','_blank');
		 myWindow.document.title = 'Mutasi RDI';
	}
	if(url_fail !='')
	{
		if(confirm('Do you want to see bank mutation failed?')===true)
		{
			var myWindow = window.open(url_fail,'_blank');
			myWindow.document.title = 'Bank Mutation Failed';
		}
		
	}
	
</script>

