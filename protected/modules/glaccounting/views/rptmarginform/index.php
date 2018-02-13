<?php
$this->breadcrumbs = array(
	'Report Margin FORM III-I' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Report Margin FORM III-I',
		'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/texchrate/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
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

<?php AHelper::showFlash($this) ?>
<!-- show flash -->
<?php AHelper::applyFormatting()
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'Rptrepoharian-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>
<br/>
<?php echo $form->errorSummary(array($model)); ?>
<input type="hidden" name="scenario" id="scenario" />
<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model, 'rpt_date', array(
				'prepend' => '<i class="icon-calendar"></i>',
				'placeholder' => 'dd/mm/yyyy',
				'class' => 'tdate span8',
				'options' => array('format' => 'dd/mm/yyyy')
			));
			?>
		</div>
		<div class="span5">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'OK',
					'id'=>'btnPrint'
				)); ?>
				&emsp;
				<!-- <a id="btnSave" class="btn btn-primary">Save to Text File ( 1-4 )</a>  -->
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Save Text File',
					'id'=>'btnSaveText'
				)); ?>
		</div>
	</div>
	<pre><strong>Note : Save text file hanya boleh dilakukan jika sudah print report pada tanggal tersebut</strong></pre>
	<!--
	<div class="control-group">
			<div class="span2">
				<label>Report Type</label>
			</div>
			<div class="span4">
				<?php echo $form->checkBox($model,'form_1',array('class'=>'rpt_type','id'=>'rpt_type_0'))."&nbsp; FORM III-I-1";?><br />
				<?php echo $form->checkBox($model,'form_2',array('class'=>'rpt_type','id'=>'rpt_type_1'))."&nbsp; FORM III-I-2";?><br />
				<?php echo $form->checkBox($model,'form_3',array('class'=>'rpt_type','id'=>'rpt_type_2'))."&nbsp; FORM III-I-3";?><br />
				<?php echo $form->checkBox($model,'form_4',array('class'=>'rpt_type','id'=>'rpt_type_3'))."&nbsp; FORM III-I-1 detail";?><br />
				<?php echo $form->checkBox($model,'all_form',array('class'=>'rpt_type','id'=>'rpt_type_4'))."&nbsp; All FORM ( 1-4 )";?><br />
			</div>
		</div>-->
	
</div>
<br />

<div id="list_report">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#form_1" aria-controls="form_1" role="tab" data-toggle="tab">FORMULIR III-I.1</a></li>
    <li role="presentation"><a href="#form_2" aria-controls="form_2" role="tab" data-toggle="tab">FORMULIR III-I.2</a></li>
    <li role="presentation"><a href="#form_3" aria-controls="form_3" role="tab" data-toggle="tab">FORMULIR III-I.3</a></li>
    <!-- <li role="presentation"><a href="#form_1_detail" aria-controls="form_1_detail" role="tab" data-toggle="tab">FORMULIR III-I.1 detail</a></li> -->
    <li role="presentation"><a href="#form_all" aria-controls="form_all" role="tab" data-toggle="tab">ALL FORMULIR (1-3)</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="form_1">
    <iframe  id="iframe_form_1" src="<?php echo $urlForm1; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="form_2">
    <iframe  id="iframe_form_2" src="<?php echo $urlForm2; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="form_3">
    <iframe  id="iframe_form_3" src="<?php echo $urlForm3; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
    </div>
    <!--
    <div role="tabpanel" class="tab-pane" id="form_1_detail">
        </div>-->
    
    <div role="tabpanel" class="tab-pane" id="form_all">
   	<iframe id="iframe_form_all" src="<?php echo $urlAll; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
   	</div>
  </div>

</div>

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


<script>

	var rand_value = '<?php echo $model->vo_random_value;?>';
	var urlForm1 = '<?php echo $urlForm1 ;?>';
	var urlForm2 = '<?php echo $urlForm2 ;?>';
	var urlForm3 = '<?php echo $urlForm3 ;?>';
	var urlAll ='<?php echo $urlAll ;?>';
	
	init();
	function init()
	{
		if(urlForm1=='' && urlForm2=='' && urlForm3 =='')
		{
			$('#list_report').hide();
		}
	cek_date();
		//cekTabPils();	
	}
	
	$('#btnPrint').click(function(){
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('print');
	});
	$('#btnSaveText').click(function(){
		$('#scenario').val('saveText');
	})
	$('#Rptmarginform_rpt_date').change(function(){
		cek_date();
	})
	
	function cek_date()
	{
		var tanggal=$('#Rptmarginform_rpt_date').val();
			$.ajax({
					'type'     :'POST',
					'url'      : '<?php echo $this->CreateUrl('CheckTextFile'); ?>',
					'dataType' : 'json',
					'data'     : { 'tanggal':tanggal},							
					'success'  : function(data)
					{
						//console.log(data)
						if(data.status=='success')
						{
							$('#btnSaveText').attr('disabled',false);
						}	
						else
						{
							$('#btnSaveText').attr('disabled',true);
						}
					}
			});
	}
	
	
	/*
	$('.rpt_type').change(function(){
			cekTabPils();
		})*/
	
	/*
	
		function cekTabPils()
		{
			//FORM 1
			if($('#rpt_type_0').is(':checked') && urlForm1 !='')
			{
				$('#form1_h').show();
				$('#form1_d').show();
				$('#iframe_form_1').show();
			}
			else
			{
				$('#form1_h').hide();
				$('#form1_d').hide();
				$('#iframe_form_1').hide();
			}
			//FORM 2
			if($('#rpt_type_1').is(':checked') && urlForm2 !='')
			{
				$('#form2_h').show();
				$('#form2_d').show();
				//$('#iframe_form_2').show();
			}
			else
			{
				$('#form2_h').hide();
				$('#form2_d').hide();
				//$('#iframe_form_2').hide();
			}
			//FORM 3
			if($('#rpt_type_2').is(':checked') && urlForm3 !='')
			{
				$('#form3_h').show();
				$('#form3_d').show();
				$('#iframe_form_3').show();
			}
			else
			{
				$('#form3_h').hide();
				$('#form3_d').hide();
				$('#iframe_form_3').hide();
			}		
			//FORM ALL
			if($('#rpt_type_4').is(':checked') && urlAll !='')
			{
				$('#All_h').show();
				$('#All_d').show();
				$('#iframe_form_all').show();
			}
			else
			{
				$('#All_h').hide();
				$('#All_d').hide();
				$('#iframe_form_all').hide();
			}			
		}
		*/
	
</script>