<style>
    input[type=radio] {
        margin-top: -3px;
    }
</style>
<?php
$this->breadcrumbs = array(
	'Unrealized Gain Loss' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Unrealized Gain Loss',
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

<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
    <div class="span6">

        <div class="control-group">
            <div class="span3">
                <label>Date From</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'bgn_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
                ?>
            </div>
            <div class="span2">
                <label>To</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'end_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Client</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model, 'client_option', array(
					'value' => '0',
					'class' => 'client_option',
					'id' => 'client_option_0'
				)) . "&emsp; All";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->radioButton($model, 'client_option', array(
					'value' => '1',
					'class' => 'client_option',
					'id' => 'client_option_1'
				)) . "&emsp; Specified";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'client_cd', array('class' => 'span10')); ?>
            </div>
        </div>

        <div class="control-group">
            <div class="offset3 span5">
                <?php echo $form->checkBox($model, 'avail_flg', array(
					'value' => 'Y',
					'uncheckValue' => 'N'
				));
                ?>&nbsp; With Available Limit
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <div class="span2">
                <label>Branch</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model, 'branch_option', array(
					'value' => '0',
					'class' => 'branch_option',
					'id' => 'branch_option_0'
				)) . "&emsp; All";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->radioButton($model, 'branch_option', array(
					'value' => '1',
					'class' => 'branch_option',
					'id' => 'branch_option_1'
				)) . "&emsp; Specified";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model, 'branch_cd', CHtml::listData(Branch::model()->findAll(array(
					'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
					'condition' => " approved_stat='A'",
					'order' => 'brch_cd'
				)), 'brch_cd', 'brch_name'), array(
					'class' => 'span12',
					'prompt' => '-Select-',
					'style' => 'font-family:courier'
				));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span2">
                <label>Sales</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model, 'rem_option', array(
					'value' => '0',
					'class' => 'rem_option',
					'id' => 'rem_option_0'
				)) . "&emsp; All";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->radioButton($model, 'rem_option', array(
					'value' => '1',
					'class' => 'rem_option',
					'id' => 'rem_option_1'
				)) . "&emsp; Specified";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model, 'rem_cd', CHtml::listData($rem_cd, 'rem_cd', 'rem_name'), array(
					'prompt' => '-Select-',
					'class' => 'span12',
					'style' => 'font-family:courier'
				));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span2">
                <label>Stock</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model, 'stk_option', array(
					'value' => '0',
					'class' => 'stk_option',
					'id' => 'stk_option_0'
				)) . "&emsp; All";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->radioButton($model, 'stk_option', array(
					'value' => '1',
					'class' => 'stk_option',
					'id' => 'stk_option_1'
				)) . "&emsp; Specified";
                ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownList($model, 'stk_cd', CHtml::listData($stk_cd, 'stk_cd', 'stk_desc'), array(
					'class' => 'span12',
					'prompt' => '-Select-',
					'style' => 'font-family:courier'
				));
                ?>
            </div>
        </div>

    </div>
   </div>
    <div class="form-actions">

                <?php $this->widget('bootstrap.widgets.TbButton', array(
		'label' => 'Show Report',
		'type' => 'primary',
		'id' => 'btnPrint',
		'buttonType' => 'submit',
	));
                ?>
            </div>
    <br />
    <iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
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
	        stk_option();
	        rem_option();
	        client_option();
	        branch_option();
        }

        function getClient()
        {
	        var result = [];
	        $('#Rptunrealizedgainloss_client_cd').autocomplete(
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
				open: function() {
				$(this).autocomplete("widget").width(400);
				}
				});
			}

			$('#Rptunrealizedgainloss_bgn_date').change(function(){
			$('#Rptunrealizedgainloss_end_date').val($('#Rptunrealizedgainloss_bgn_date').val());
			});
			$('.branch_option').change(function(){
			branch_option();
			})

			$('.stk_option').change(function(){
				stk_option();
			})

			$('.rem_option').change(function(){
				rem_option();
			})
			$('.client_option').change(function(){
				client_option();
			})
			function branch_option()
			{
				if($('#branch_option_1').is(':checked'))
				{
					$('#Rptunrealizedgainloss_branch_cd').attr('disabled',false);
				}
				else
				{
					$('#Rptunrealizedgainloss_branch_cd').val('');
					$('#Rptunrealizedgainloss_branch_cd').attr('disabled',true);
				}
			}
			function stk_option()
			{
				if($('#stk_option_1').is(':checked'))
				{
					$('#Rptunrealizedgainloss_stk_cd').attr('disabled',false);
				}
				else
				{
					$('#Rptunrealizedgainloss_stk_cd').val('');
					$('#Rptunrealizedgainloss_stk_cd').attr('disabled',true);
				}
			}
			function rem_option()
			{
				if($('#rem_option_1').is(':checked'))
				{
					$('#Rptunrealizedgainloss_rem_cd').attr('disabled',false);
				}
				else
				{
					$('#Rptunrealizedgainloss_rem_cd').val('');
					$('#Rptunrealizedgainloss_rem_cd').attr('disabled',true);
				}
			}
			function client_option()
			{
				if($('#client_option_1').is(':checked'))
				{
					$('#Rptunrealizedgainloss_client_cd').attr('disabled',false);
				}
				else
				{
					$('#Rptunrealizedgainloss_client_cd').val('');
					$('#Rptunrealizedgainloss_client_cd').attr('disabled',true);
				}
			}
		$('#btnPrint').click(function(){
			$('#mywaitdialog').dialog('open');
			})			
    </script>
