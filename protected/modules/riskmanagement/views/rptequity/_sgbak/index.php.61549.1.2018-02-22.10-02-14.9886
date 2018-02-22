<?php
$this->breadcrumbs = array(
    'Equity Report'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'Equity Report',
        'itemOptions'=> array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
    ),
    array(
        'label'=>'List',
        'url'=> array('index'),
        'icon'=>'list',
        'itemOptions'=> array(
            'class'=>'active',
            'style'=>'float:right'
        )
    ),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'importTransaction-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
    ));
?>

<?php AHelper::showFlash($this);?>
<?php AHelper::applyFormatting() ?> 

<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
    <div class="span5">
        <div class="control-group">
            <div class="span3">
                <label>Date</label>
            </div>
            <div class="span3">
                <?php echo $form->textField($model, 'as_per_date', array(
                    'class'=>'span10 tdate',
                    'placeholder'=>'dd/mm/yyyy'
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Account Type</label>
            </div>
            <div class="span2">
                <input type="radio" name="Rptequity[acct_type]" value="M" <?php echo $model->acct_type=='M'?'checked':'' ;?> > &nbsp;Margin
            </div>
            <div class="span2">
                <input type="radio" name="Rptequity[acct_type]" value="R" <?php echo $model->acct_type=='R'?'checked':'' ;?> > &nbsp;Regular
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Limit</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model,'limit',array('class'=>'span8 tnumber','style'=>'text-align:right'));?> &nbsp;<strong>JUTA</strong>
            </div>
        </div>
        
         
        <div class="control-group">
            <div class="span5">

                <?php $this->widget('bootstrap.widgets.TbButton', array(
                                    'label'=>'SHOW',
                                    'type'=>'primary',
                                    'id'=>'btnPrint',
                                    'buttonType'=>'submit',
                                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span7">
        <div class="control-group">
            <div class="span2">
                <label>Client</label>
            </div>
            <div class="span2">
                 <input type="radio" class="client_option" id="client_option_0" name="Rptequity[client_option]" value="0" <?php echo $model->client_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span2">
                 <input type="radio" class="client_option" id="client_option_1" name="Rptequity[client_option]" value="1" <?php echo $model->client_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
             <div class="span2">
                 <?php echo $form->textField($model,'bgn_client',array('class'=>'span12'));?>
            </div>
            <div class="span2">
                 <?php echo $form->textField($model,'end_client',array('class'=>'span12'));?>
            </div>
        </div>
        <div class="control-group">
            <div class="span2">
                <label>Branch</label>
            </div>
            <div class="span2">
                 <input type="radio" class="branch_option" id="branch_option_0" name="Rptequity[branch_option]" value="0" <?php echo $model->branch_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span2">
                 <input type="radio" class="branch_option" id="branch_option_1" name="Rptequity[branch_option]" value="1" <?php echo $model->branch_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
            <div class="span2">
                   <?php echo $form->dropDownList($model,'bgn_branch',CHtml::listData($branch, 'brch_cd', 'brch_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
            </div>
            <div class="span2">
                   <?php echo $form->dropDownList($model,'end_branch',CHtml::listData($branch, 'brch_cd', 'brch_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
            </div>
        </div>
        <div class="control-group">
            <div class="span2">
                <label>Sales</label>
            </div>
            <div class="span2">
                 <input type="radio" class="rem_option" id="rem_option_0" name="Rptequity[rem_option]" value="0" <?php echo $model->rem_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span2">
                 <input type="radio" class="rem_option" id="rem_option_1" name="Rptequity[rem_option]" value="1" <?php echo $model->rem_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
             <div class="span2">
                   <?php echo $form->dropDownList($model,'bgn_rem',CHtml::listData($rem_cd, 'rem_cd', 'rem_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
            </div>
            <div class="span2">
                   <?php echo $form->dropDownList($model,'end_rem',CHtml::listData($rem_cd, 'rem_cd', 'rem_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
            </div>
        </div>
        
    </div>

</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model, 'dummy_date', array(
        'label'=>false,
        'style'=>'display:none'
    ));
?>
<?php $this->endWidget(); ?>
<script>
    init();
    function init()
    {
        $('.tdate').datepicker(
        {
            'format' : 'dd/mm/yyyy'
        });
        getClient();
        clientOption();
        branchOption();
        remOption();
    }
    $('.client_option').change(function(){
        clientOption();
    })
    $('.branch_option').change(function(){
        branchOption();
    })
     $('.rem_option').change(function(){
        remOption();
    })
    
    function getClient()
    {
        var result = [];
        $('#Rptequity_bgn_client, #Rptequity_end_client').autocomplete(
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
                    $(this).autocomplete("widget").width(400);
                    $(this).autocomplete("widget").css('overflow-y','scroll');
                    $(this).autocomplete("widget").css('max-height','250px');
                    $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
    
    function clientOption()
    {
        if($('#client_option_0').is(':checked'))
        {
            $('#Rptequity_bgn_client').prop('disabled',true);
            $('#Rptequity_end_client').prop('disabled',true);
        }
        else
        {
            $('#Rptequity_bgn_client').prop('disabled',false);
            $('#Rptequity_end_client').prop('disabled',false);
        }
    }
    function branchOption()
    {
        if($('#branch_option_0').is(':checked'))
        {
            $('#Rptequity_bgn_branch').prop('disabled',true);
            $('#Rptequity_end_branch').prop('disabled',true);
        }
        else
        {
            $('#Rptequity_bgn_branch').prop('disabled',false);
            $('#Rptequity_end_branch').prop('disabled',false);
        }
        
    }
    function remOption()
    {
        if($('#rem_option_0').is(':checked'))
        {
            $('#Rptequity_bgn_rem').prop('disabled',true);
            $('#Rptequity_end_rem').prop('disabled',true);
        }
        else
        {
            $('#Rptequity_bgn_rem').prop('disabled',false);
            $('#Rptequity_end_rem').prop('disabled',false);
        }
    }
    $('#Rptequity_bgn_client').change(function(){
        $('#Rptequity_end_client').val($('#Rptequity_bgn_client').val().toUpperCase());
    })
    $('#Rptequity_bgn_branch').change(function()
    {
        $('#Rptequity_end_branch').val($('#Rptequity_bgn_branch').val());
    })
    $('#Rptequity_bgn_rem').change(function(){
        $('#Rptequity_end_rem').val($('#Rptequity_bgn_rem').val());
    })
</script>
