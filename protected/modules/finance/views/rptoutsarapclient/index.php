<?php $this->menu = array( array('label' => 'Outstanding AR/AP Client', 'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')), array('label' => 'List', 'url' => array('index'), 'icon' => 'list', 'itemOptions' => array('class' => 'active', 'style' => 'float:right')), ); ?>

<?php AHelper::showFlash($this)
?>
<!-- show flash -->
<?php AHelper::applyFormatting() ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array('id' => 'iporeport-form', 'enableAjaxValidation' => false, 'type' => 'horizontal')); ?>

<?php echo $form->errorSummary($model); ?>

<br/>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <div class="span3">
                <strong>Option</strong>
            </div>
            <div class="span4">
                <?php echo $form->radioButton($model, 'option', array('value' => '0', 'class' => 'option', 'id' => 'option_0')); ?>&nbsp;Outstanding
            </div>
            <div class="span1">
                <label>As at</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'as_at_date', array('class' => 'span10 tdate', 'placeholder' => 'dd/mm/yyyy')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">

            </div>
            <div class="span4">
                <?php echo $form->radioButton($model, 'option', array('value' => '1', 'class' => 'option', 'id' => 'option_1')); ?>&nbsp;AR/AP Settlement

            </div>
            <div class="span1">
                <label>From</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'from_date', array('class' => 'span10 tdate', 'placeholder' => 'dd/mm/yyyy')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span7"></div>
            <div class="span1">
                <label>To</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'to_date', array('class' => 'span10 tdate', 'placeholder' => 'dd/mm/yyyy')); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Sort By</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model, 'sort_by', array('value' => '0', 'class' => 'sortby')); ?>&nbsp;Date
            </div>
            <div class="span5">
                <?php echo $form->radioButton($model, 'sort_by', array('value' => '1', 'class' => 'sortby')); ?>&nbsp;Gl Account Code
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <div class="span3">
                <label>Client Cd</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model, 'client_option', array('value' => '0', 'id' => 'client_option_0', 'class' => 'client_option')); ?>&nbsp;All
            </div>
            <div class="span3">
                <?php echo $form->radioButton($model, 'client_option', array('value' => '1', 'id' => 'client_option_1', 'class' => 'client_option')); ?>&nbsp;Specified
            </div>
        </div>
        <div class="control-group">
            <div class="offset3 span3">
                <?php echo $form->textField($model, 'bgn_client', array('class' => 'span10')); ?>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'end_client', array('class' => 'span10')); ?>
            </div>
        </div>

        <div class="control-group">
            <div class="span3">
                <label>Branch Code</label>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model, 'branch_cd',
                 CHtml::listData(Branch::model()->findAll(array('select' => "brch_cd||' - '||brch_name brch_name, brch_cd", 'order' => 'brch_cd')), 'brch_cd', 'brch_name'), 
                 				array('class' => 'span10', 'style' => 'font-family:courier', 'prompt' => '-All-','disabled'=>$branch_flg=='Y'?true:'')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('id' => 'btnSubmit', 'buttonType' => 'submit', 'type' => 'primary', 'label' => 'Show Report', )); ?>
</div>

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model, 'dummy_date', array('label' => false, 'style' => 'display:none')); ?>
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
    	init();
    function init()
    {
    $('.tdate').datepicker({'format':'dd/mm/yyyy'});
    getClient();
    cek_option();
    cek_client_option();
    }

    function getClient()
    {
    var result = [];
    $('#Rptoutsarapclient_bgn_client, #Rptoutsarapclient_end_client').autocomplete(
    {
    source: function (request, response)
    {
    $.ajax({
    'type'		: 'POST',
    'url'		: '<?php echo $this->createUrl('getclient'); ?>
		',
		'dataType' 	: 'json',
		'data'		:	{
		'term': request.term,

		},
		'success'	: 	function (data)
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
		minLength: 1,
		open: function()
		{
		$(this).autocomplete("widget").width(400);
		},
		position:
		{
		//    offset: '-150 0' // Shift 150px to the left, 0px vertically.
		}

		});

		}

		$('.option').change(function(){
		cek_option();
		});
		$('.client_option').change(function(){
		cek_client_option();
		})

		$('#Rptoutsarapclient_from_date').change(function(){
		$('#Rptoutsarapclient_to_date').val($('#Rptoutsarapclient_from_date').val());
		})

		function cek_option()
		{
		if($('#option_0').is(':checked'))
		{
		$('#Rptoutsarapclient_as_at_date').attr('required',true);
		$('#Rptoutsarapclient_from_date').attr('required',false);
		$('#Rptoutsarapclient_to_date').attr('required',false);
		$('#Rptoutsarapclient_from_date').prop('disabled',true);
		$('#Rptoutsarapclient_to_date').prop('disabled',true);
		$('#Rptoutsarapclient_as_at_date').prop('disabled',false);
		$('.sortby').prop('disabled',false);
		}
		else
		{
		$('#Rptoutsarapclient_as_at_date').attr('required',false);
		$('#Rptoutsarapclient_from_date').attr('required',true);
		$('#Rptoutsarapclient_to_date').attr('required',true);
		$('#Rptoutsarapclient_from_date').prop('disabled',false);
		$('#Rptoutsarapclient_to_date').prop('disabled',false);
		$('#Rptoutsarapclient_as_at_date').prop('disabled',false);
		$('.sortby').prop('disabled',true);
		}
		}
		function cek_client_option()
		{
			if($('#client_option_0').is(':checked'))
		    {
		    $('#Rptoutsarapclient_bgn_client').prop('disabled',true);
		    $('#Rptoutsarapclient_end_client').prop('disabled',true);
		
		    }
		    else
		    {
		    $('#Rptoutsarapclient_bgn_client').prop('disabled',false);
		    $('#Rptoutsarapclient_end_client').prop('disabled',false);
		
		    }
    	}
    $('#btnSubmit').click(function(){
    $('#mywaitdialog').dialog('open');
    })
    $('#Rptoutsarapclient_bgn_client').change(function(){
    	$('#Rptoutsarapclient_bgn_client').val($('#Rptoutsarapclient_bgn_client').val().toUpperCase());
    	$('#Rptoutsarapclient_end_client').val($('#Rptoutsarapclient_bgn_client').val());
    });
    
     $('#Rptoutsarapclient_end_client').change(function(){
    	$('#Rptoutsarapclient_end_client').val($('#Rptoutsarapclient_end_client').val().toUpperCase());
    });
    
</script>