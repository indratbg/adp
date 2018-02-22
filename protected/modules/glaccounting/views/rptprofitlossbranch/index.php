<?php
$this->breadcrumbs = array(
	'Profit Loss Branch' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Profit Loss Branch',
		'itemOptions' => array('style' => 'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
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

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'importTransaction-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>

<?php echo $form->errorSummary($model); ?>
<?php AHelper::showFlash($this)
?>

<?php

$half_year = array('0'=>'1. January - June','1'=>'2. July - December');
$quarter = array('0'=>'1. January - March','1'=>'2. April - June','2'=>'3. July - September','3'=>'4. October - December');
?>

<br>

<input type="hidden" name="scenario" id="scenario" />
 <?php echo $form->textField($model,'vo_random_value',array('style'=>'display:none'));?>
<div class="error_msg">
    </div>
<div class="row-fluid">
    <div id="rep_ui_yj">
        <div class="span6">
        <legend><b>Report Presentation</b></legend>
        <div class="control-group">
            <div class="span3">
                <label>Month</label>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model, 'month', AConstant::getArrayMonth(), array(
                    'class' => 'span10',
                    'prompt' => '-Select-'
                ));
                ?>
              
            </div>
            <div class="span1">
                <label>Year</label>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model, 'year', AConstant::getArrayYear(), array(
                    'class' => 'span10',
                    'prompt' => '-Select-'
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>January upto</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model,'doc_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type' => 'primary',
                    'label' => 'Show',
                    'id' => 'btnSubmit'
                ));
                ?>      
            </div>
            <div class="span4">
                                
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Save to Excel',
                        'type' => 'primary',
                        'id' => 'btn_xls',
                        'buttonType' => 'submit',
                    ));
                 ?> 
            </div>
        </div>
    
     </div>
    </div>
    
    
    <div id="rep_ui_others">
    	<div class="span4">
    		<legend><b>Report Presentation</b></legend>
    		<div class="control-group">
    			<div class="span7">
    				<input type="radio" id="rpt_pres_0" name="Rptprofitlossbranch[rpt_pres]" value="0" <?php echo $model->rpt_pres==0?'checked':''?> class="rpt_pres"/>&nbsp;1. Quarter Year
    			</div>
    		</div>
    		<div class="control-group">
    			<div class="span7">
    				<input type="radio" id="rpt_pres_1" name="Rptprofitlossbranch[rpt_pres]" value="1" <?php echo $model->rpt_pres==1?'checked':''?> class="rpt_pres"/>&nbsp;2. Half Year
    			</div>
    		</div>
    		<div class="control-group">
    			<div class="span7">
    				<input type="radio" id="rpt_pres_2" name="Rptprofitlossbranch[rpt_pres]" value="2" <?php echo $model->rpt_pres==2?'checked':''?> class="rpt_pres"/>&nbsp;3. Full Year
    			</div>
    		</div>
    		<div class="control-group">
    			<div class="span7">
    				<input type="radio" id="rpt_pres_3" name="Rptprofitlossbranch[rpt_pres]" value="3" <?php echo $model->rpt_pres==3?'checked':''?> class="rpt_pres"/>&nbsp;4. January upto
    			</div>
    			<div class="span4">
    					<?php echo $form->textField($model,'doc_date',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
    			</div>
    		</div>
    		
    	</div>
    	<div class="span3">
    		<legend><b>Criteria(s)</b></legend>
    		<div class="control-group">
    			<div class="span3">
    				<label>Year</label>
    			</div>
    			<div class="span7">
    				<?php echo $form->dropDownList($model,'year',AConstant::getArrayYear(),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
    			</div>
    		</div>
    		<div class="control-group">
    			<div class="span3">
    				<label>Half Year</label>
    			</div>
    			<div class="span7">
    				<?php echo $form->dropDownList($model,'half_year',$half_year,array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
    			</div>
    		</div>
    		<div class="control-group">
    			<div class="span3">
    				<label>Quarter</label>
    			</div>
    			<div class="span7">
    				<?php echo $form->dropDownList($model,'quarter',$quarter,array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
    			</div>
    		</div>
    		<div class="control-group">
    			<div class="span9">
    				<?php $this->widget('bootstrap.widgets.TbButton', array(
    					'buttonType' => 'submit',
    					'type' => 'primary',
    					'label' => 'OK',
    					'id' => 'btnSubmit'
    				));
    				?>
    			 &emsp;
                 
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Save to Excel',
                        'type' => 'primary',
                        'id' => 'btn_xls',
                        'buttonType' => 'submit',
                    ));
                 ?>
    			</div>
    		</div>
    		
    	</div>
	</div>
	<div class="span4">
		<legend><b>Branch(s)</b></legend>
			<div class="control-group">
				<div class="span6">
					<input type="radio" id="branch_option_1" name="Rptprofitlossbranch[branch_option]" value="1" <?php echo $model->branch_option==1?'checked':''?> class="branch_option"/>&nbsp;All Branch
				</div>
				<div class="span6">
					<input type="radio" id="branch_option_2" name="Rptprofitlossbranch[branch_option]" value="2" <?php echo $model->branch_option==2?'checked':''?> class="branch_option"/>&nbsp;Total All Branches
				</div>
			</div>
			
			<div class="control-group">
				<div class="span6">
					<input type="radio" id="branch_option_3" name="Rptprofitlossbranch[branch_option]" value="3" <?php echo $model->branch_option==3?'checked':''?> class="branch_option"/>&nbsp;Total w/o Fixed Income
				</div>
				<div class="span6">
					<input type="radio" id="branch_option_4" name="Rptprofitlossbranch[branch_option]" value="4" <?php echo $model->branch_option==4?'checked':''?> class="branch_option"/>&nbsp;Detail Expense
				</div>
			</div>
			<div class="control-group">
				<div class="span6">
					<input type="radio" id="branch_option_0" name="Rptprofitlossbranch[branch_option]" value="0" <?php echo $model->branch_option==0?'checked':''?> class="branch_option"/>&nbsp;Specified Branch
				</div>
				<div class="span6">
					<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
				</div>
			</div>
	</div>
</div>



<br />
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'disabled'=>true,'style'=>'display:none'));?>
<?php $this->endWidget(); ?>
<



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
	var url_xls = '<?php echo $url_xls ?>';
	var ui_flg = '<?php echo $ui_flg;?>';
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
		rep_pres();
		branch_option();
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
		if('<?php echo $ui_flg ;?>' =='YJ')
		{
		    $('#rep_ui_others').html('');
		}
		else
		{
		    $('#rep_ui_yj').html('');
		}
	}
	
	$('.rpt_pres').change(function()
	{
		rep_pres();
	})
	$('.branch_option').change(function()
	{
		branch_option();
	})
	
	function rep_pres()
	{
		if($('#rpt_pres_0').is(':checked'))
		{
			$('#Rptprofitlossbranch_year').prop('disabled',false);
			$('#Rptprofitlossbranch_half_year').prop('disabled',true);
			$('#Rptprofitlossbranch_quarter').prop('disabled',false);
			$('#Rptprofitlossbranch_doc_date').attr('required',false);
			$('#Rptprofitlossbranch_quarter').attr('required',true);
			$('#Rptprofitlossbranch_half_year').attr('required',false);
		}
		else if($('#rpt_pres_1').is(':checked'))
		{
			$('#Rptprofitlossbranch_year').prop('disabled',false);
			$('#Rptprofitlossbranch_half_year').prop('disabled',false);
			$('#Rptprofitlossbranch_quarter').prop('disabled',true);
			$('#Rptprofitlossbranch_doc_date').attr('required',false);
			$('#Rptprofitlossbranch_quarter').attr('required',false);
			$('#Rptprofitlossbranch_half_year').attr('required',true);
		}
		else if($('#rpt_pres_2').is(':checked'))
		{
			$('#Rptprofitlossbranch_year').prop('disabled',false);
			$('#Rptprofitlossbranch_half_year').prop('disabled',true);
			$('#Rptprofitlossbranch_quarter').prop('disabled',true);
			$('#Rptprofitlossbranch_doc_date').attr('required',false);
			$('#Rptprofitlossbranch_quarter').attr('required',false);
			$('#Rptprofitlossbranch_half_year').attr('required',false);
		}
		else if($('#rpt_pres_3').is(':checked'))
		{
			$('#Rptprofitlossbranch_year').prop('disabled',false);
			$('#Rptprofitlossbranch_half_year').prop('disabled',true);
			$('#Rptprofitlossbranch_quarter').prop('disabled',true);
			$('#Rptprofitlossbranch_doc_date').attr('required',true);
			$('#Rptprofitlossbranch_quarter').attr('required',false);
			$('#Rptprofitlossbranch_half_year').attr('required',false);
		}
	}
	function branch_option()
	{
		if($('#branch_option_0').is(':checked'))
		{
			$('#Rptprofitlossbranch_branch_cd').prop('disabled',false);
		}
		else
		{
			$('#Rptprofitlossbranch_branch_cd').prop('disabled',true);
		}
	}
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
	$(window).resize(function()
	{
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
	});
	$('#Rptprofitlossbranch_year').change(function(){
		
		if($('#rpt_pres_3').is(':checked'))
		{
		    var dt = $('#Rptprofitlossbranch_doc_date').val().split('/');
			$('#Rptprofitlossbranch_doc_date').val(dt[0]+'/'+dt[1]+'/'+$('#Rptprofitlossbranch_year').val());
			$('.tdate').datepicker('update');
		}
	});
	
	$('#Rptprofitlossbranch_doc_date').change(function(){
		var year =$('#Rptprofitlossbranch_doc_date').val().split('/'); 
		$('#Rptprofitlossbranch_year').val(year[2]);
	})
	
	$('#Rptprofitlossbranch_month, #Rptprofitlossbranch_year').change(function(){
        var date = $('#Rptprofitlossbranch_doc_date').val().split('/');
         if(ui_flg == 'YJ')
         {
             $('#Rptprofitlossbranch_doc_date').val(date[0]+'/'+$('#Rptprofitlossbranch_month').val()+'/'+$('#Rptprofitlossbranch_year').val());
         }
        Get_End_Date($('#Rptprofitlossbranch_doc_date').val())
    });
	function Get_End_Date(tgl)
    {
        var date = tgl.split('/');
        var day = parseInt(date[0]);
        var month = parseInt(date[1]);
        var year = parseInt(date[2]);
        var d = new Date(year,month,day);
          d.setDate(d.getDate() - day);
        var month = d.getMonth()+1;
        var new_date = d.getDate()+'/'+month+'/'+d.getFullYear();
          
        $('#Rptprofitlossbranch_doc_date').val(new_date);
        $('.tdate').datepicker('update');
    }
     $('#btnSubmit').click(function(e){
        $('#mywaitdialog').dialog('open');
       e.preventDefault()
        $('.error_msg').empty();
       $('#scenario').val('print');
       $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo $this->createUrl('AjxShowReport'); ?>',
                    'dataType'  : 'json',
                    'data'      : $('#importTransaction-form').serialize(),
                    'success'   :   function (data) 
                                {
                                    $('#mywaitdialog').dialog('close');
                                    if(data.status='success')
                                    {
                                           if(data.error_msg)
                                           {
                                               Message('danger', data.error_msg)
                                           }
                                           else
                                           {
                                               $('#iframe').show();
                                                $("#iframe").attr("src", data.url);
                                                $('#btn_xls').prop('disabled',false);
                                                $('#Rptprofitlossbranch_vo_random_value').val(data.rand_value);
                                           }
                                    }
                                }
                });
    
    })
    $('#btn_xls').click(function() {
        $('#scenario').val('export');
    });
    
    
  function Message(cls, msg)
    {
        $('.error_msg').find('div').remove();
        $('.error_msg').append($('<div>')
                       .attr('class', 'alert alert-block alert-' + cls)
                            .append($('<button>').attr('type', 'button')
                            .attr('class', 'close')
                            .attr('data-dismiss', 'alert')
                            .attr('aria-label', 'Close')
                            .append($('<span>')
                            .attr('aria-hidden', true)
                            .html('X')
                            )
                           )
                               .append($('<p>').html(msg))
           );
  }
    
</script>