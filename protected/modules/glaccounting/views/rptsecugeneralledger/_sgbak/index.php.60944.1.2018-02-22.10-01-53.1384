<?php
$this->breadcrumbs = array(
	'General Ledger' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'General Ledger',
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
$month = array(
	'01' => 'January',
	'02' => 'February',
	'03' => 'March',
	'04' => 'April',
	'05' => 'May',
	'06' => 'June',
	'07' => 'July',
	'08' => 'August',
	'09' => 'September',
	'10' => 'October',
	'11' => 'November',
	'12' => 'December'
);
?>

<br>

<div class="row-fluid">
	<div class="span6">

		<div class="control-group">
			<div class="span2">
				<label>Month</label>
			</div>
			<div class="span5">
				<?php echo $form->dropDownListRow($model, 'month', $month, array(
					'class' => 'span8',
					'prompt' => '-Select-',
					'label' => FALSE
				));
				?>
			</div>
			<div class="span1">
				<label>Year</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'year', array('class' => 'span8 numeric')); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Periode</label>
			</div>
			<div class="span5">
				<?php echo $form->datePickerRow($model, 'end_date', array(
					'prepend' => '<i class="icon-calendar"></i>',
					'placeholder' => 'dd/mm/yyyy',
					'class' => 'tdate span7',
					'label' => false,
					'options' => array('format' => 'dd/mm/yyyy')
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Gl Acct</label>
			</div>
			<div class="span2">
				<input type="radio" id="gl_option_0" name="Rptsecugeneralledger[gl_option]" value="0" <?php echo $model->gl_option==0?'checked':''?> class="gl_option"/>&nbsp;All
			</div>
			<div class="span2">	
				<input type="radio" id="gl_option_1" name="Rptsecugeneralledger[gl_option]" value="1" <?php echo $model->gl_option==1?'checked':''?> class="gl_option"/>&nbsp;Specified
			</div>
			<div class="span5">
				<?php echo $form->dropDownList($model,'gl_acct',array(),array('class'=>'span12','style'=>'font-family:courier;'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Reversal</label>
			</div>
			<div class="span2">
				<input type="radio" id="reversal_jur_0" name="Rptsecugeneralledger[reversal_jur]" value="0" <?php echo $model->reversal_jur==0?'checked':''?> class="reversal_jur"/>&nbsp;SHOW
			</div>
			<div class="span2">
				<input type="radio" id="reversal_jur_1" name="Rptsecugeneralledger[reversal_jur]" value="1" <?php echo $model->reversal_jur==1?'checked':''?> class="reversal_jur"/>&nbsp;HIDE
			</div>
		</div>
		<div class="control-group">
			<div class="span5">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'OK',
					'id' => 'btnSubmit'
				));
				?>
				&emsp;
				<a href="<?php echo Yii::app()->request->baseUrl.'?r=glaccounting/rptsecugeneralledger/GetXls&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</a>
			</div>
		</div>
	</div>
	<!--End Span6  -->

	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Client</label>
			</div>
			<div class="span2">
			    <input type="radio" id="client_option_0" name="Rptsecugeneralledger[client_option]" value="0" <?php echo $model->client_option==0?'checked':''?> class="client_option"/>&nbsp;All
			</div>
			<div class="span2">
                <input type="radio" id="client_option_1" name="Rptsecugeneralledger[client_option]" value="1" <?php echo $model->client_option==1?'checked':''?> class="client_option"/>&nbsp;Specified
            </div>
            <div class="span2">
                <?php echo $form->textField($model,'client_cd',array('class'=>'span12'));?>
            </div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Stock</label>
			</div>
			<div class="span2">
                <input type="radio" id="stk_option_0" name="Rptsecugeneralledger[stk_option]" value="0" <?php echo $model->stk_option==0?'checked':''?> class="stk_option"/>&nbsp;All
            </div>
            <div class="span2">
                <input type="radio" id="stk_option_1" name="Rptsecugeneralledger[stk_option]" value="1" <?php echo $model->stk_option==1?'checked':''?> class="stk_option"/>&nbsp;Specified
            </div>
            <div class="span2">
                  <?php echo $form->textField($model,'stk_cd',array('class'=>'span12'));?>
            </div>
			
		</div>
			
	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
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
var url_xls =   '<?php echo $url_xls ?>';
var gl_a = '<?php echo $model->gl_acct;?>';
init();
function init()
{
	if(url_xls=='')
	{
	$('#btn_xls').attr('disabled',true);
	}
	
	gl_option();
	client_option();
	getClient();
	stk_option();
	getGL_List();
	getStock();
}
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
	})
	


	function getGL_List()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('AjxGetGl_acct'); ?>',
			'dataType' : 'json',
			'data'     : {
							'tanggal' : $("#Rptsecugeneralledger_end_date").val(),
						}, 
			'success'  : function(data){
				var result = data.content;				
				
				$('#Rptsecugeneralledger_gl_acct').empty();
				$('#Rptsecugeneralledger_gl_acct').append($('<option>').val("").text("-Select-"));
				
				$.each(result, function(i, item) {
			    	$('#Rptsecugeneralledger_gl_acct').append($('<option>').val(this['sl_code']).text(this['sl_desc']));
				});		
				
				$('#Rptsecugeneralledger_gl_acct').val(gl_a);
			}
		});
	}
	
	$('.gl_option').change(function(){
		gl_option();
	});
	$('.client_option').change(function(){
	client_option();
	});
	$('.stk_option').change(function(){
	stk_option();
	});
	
	function gl_option()
	{
		if($('#gl_option_0').is(':checked'))
		{
			$('#Rptsecugeneralledger_gl_acct').val('');
			$('#Rptsecugeneralledger_gl_acct').prop('disabled',true);
			
		}
		else
		{
			$('#Rptsecugeneralledger_gl_acct').prop('disabled',false);
		}
	}
	function client_option()
	{
		if($('#client_option_0').is(':checked'))
		{
			$('#Rptsecugeneralledger_client_cd').val('');
			$('#Rptsecugeneralledger_client_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptsecugeneralledger_client_cd').prop('disabled',false);
		}
	}
	function stk_option()
	{
		if(!$('#stk_option_1').is(':checked'))
		{
			$('#Rptsecugeneralledger_stk_cd').val('');
			$('#Rptsecugeneralledger_stk_cd').prop('disabled',true);
		}
		else
		{
			$('#Rptsecugeneralledger_stk_cd').prop('disabled',false);
		}
	}
	
	function getClient()
    {
        var result = [];
        $('#Rptsecugeneralledger_client_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
                                    {
                                         response(data);
                                         result = data;
                                    }
                });
            },
            change: function(event,ui)
            {
                $(this).val($(this).val().toUpperCase());
                if (ui.item==null)
                {
                    // Only accept value that matches the items in the autocomplete list
                    
                    var inputVal = $(this).val();
                    var match = false;
                    
                    $.each(result,function()
                    {
                        if(this.value.toUpperCase() == inputVal)
                        {
                            match = true;
                            return false;
                        }
                    });
                    
                }
            },
            minLength: 0,
             open: function() { 
                    $(this).autocomplete("widget").width(500);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
	
	$('#Rptsecugeneralledger_month').change(function(){
	    var end_date = $('#Rptsecugeneralledger_end_date').val().split('/');
		$('#Rptsecugeneralledger_end_date').val(end_date[0]+'/'+$('#Rptsecugeneralledger_month').val()+'/'+end_date[2]);
		Get_End_Date($('#Rptsecugeneralledger_end_date').val());
	});
	
	$('#Rptsecugeneralledger_year').on('keyup',function(){
		 var end_date = $('#Rptsecugeneralledger_end_date').val().split('/');
		$('#Rptsecugeneralledger_end_date').val(end_date[0]+'/'+end_date[1]+'/'+$('#Rptsecugeneralledger_year').val());
		Get_End_Date($('#Rptsecugeneralledger_end_date').val());
	})
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
		  
		$('#Rptsecugeneralledger_end_date').val(new_date);
		$('.tdate').datepicker('update');
	}
	function getStock()
    { 
        var result = [];
        $('#Rptsecugeneralledger_stk_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
                                    {
                                         response(data);
                                         result = data;
                                    }
                });
            },
            change: function(event,ui)
            {
                $(this).val($(this).val().toUpperCase());
                if (ui.item==null)
                {
                    // Only accept value that matches the items in the autocomplete list
                    
                    var inputVal = $(this).val();
                    var match = false;
                    
                    $.each(result,function()
                    {
                        if(this.value.toUpperCase() == inputVal)
                        {
                            match = true;
                            return false;
                        }
                        
                    });
                     if(!match)
                    {
                        $(this).val('');
                    }
                }
            },
            minLength: 0,
           open: function() { 
                    $(this).autocomplete("widget").width(400);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
</script>