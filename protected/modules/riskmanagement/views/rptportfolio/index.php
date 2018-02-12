<?php
$this->breadcrumbs = array(
    'Portfolio/ Buy Back per Date'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'Portfolio/ Buy Back per Date',
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
    <div class="span6">
        <div class="control-group">
            <div class="span3">
                <label>Price Date</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'price_date', array(
                    'class'=>'span7 tdate',
                    'placeholder'=>'dd/mm/yyyy',
                    //'readonly'=>true
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Transaction Date</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'trx_date', array(
                    'class'=>'span7 tdate',
                    'placeholder'=>'dd/mm/yyyy'
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Account Type</label>
            </div>
            <div class="span3">
                <input type="radio" name="Rptportfolio[acct_type]" value="M" <?php echo $model->acct_type=='M'?'checked':'' ;?> > &nbsp;Margin
            </div>
            <div class="span3">
                <input type="radio" name="Rptportfolio[acct_type]" value="R" <?php echo $model->acct_type=='R'?'checked':'' ;?> > &nbsp;Regular
            </div>
        </div>        
         <div class="control-group">
            <div class="span3">
                <label>Client</label>
            </div>
            <div class="span3">
                 <input type="radio" class="client_option" id="client_option_0" name="Rptportfolio[client_option]" value="0" <?php echo $model->client_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span3">
                 <input type="radio" class="client_option" id="client_option_1" name="Rptportfolio[client_option]" value="1" <?php echo $model->client_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
             <div class="span3">
                 <?php echo $form->textField($model,'client_cd',array('class'=>'span12'));?>
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
    <div class="span6">
        <div class="control-group">
            <div class="span3">
                <label>Branch</label>
            </div>
            <div class="span3">
                 <input type="radio" class="branch_option" id="branch_option_0" name="Rptportfolio[branch_option]" value="0" <?php echo $model->branch_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span3">
                 <input type="radio" class="branch_option" id="branch_option_1" name="Rptportfolio[branch_option]" value="1" <?php echo $model->branch_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
            <div class="span3">
                   <?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch, 'brch_cd', 'brch_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
            </div>
           
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Sales</label>
            </div>
            <div class="span3">
                 <input type="radio" class="rem_option" id="rem_option_0" name="Rptportfolio[rem_option]" value="0" <?php echo $model->rem_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span3">
                 <input type="radio" class="rem_option" id="rem_option_1" name="Rptportfolio[rem_option]" value="1" <?php echo $model->rem_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
             <div class="span3">
                   <?php echo $form->dropDownList($model,'rem_cd',CHtml::listData($rem_cd, 'rem_cd', 'rem_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
            </div>
           
        </div>
         <div class="control-group">
            <div class="span3">
                <label>Stock</label>
            </div>
            <div class="span3">
                 <input type="radio" class="stk_cd_option" id="stk_cd_option_0" name="Rptportfolio[stk_cd_option]" value="0" <?php echo $model->stk_cd_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span3">
                 <input type="radio" class="stk_cd_option" id="stk_cd_option_1" name="Rptportfolio[stk_cd_option]" value="1" <?php echo $model->stk_cd_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
            <div class="span3">
                   <?php echo $form->textField($model,'stk_cd',array('class'=>'span12'));?>
            </div>
           
        </div>
         <div class="control-group">
            <div class="span3">
                <label>Report Type</label>
            </div>
            <div class="span3">
                 <input type="radio" class="report_type" id="report_type_0" name="Rptportfolio[report_type]" value="0" <?php echo $model->report_type=='0'?'checked':'' ;?> > &nbsp;Portfolio
            </div>
            <div class="span3">
                 <input type="radio" class="report_type" id="report_type_1" name="Rptportfolio[report_type]" value="1" <?php echo $model->report_type=='1'?'checked':'' ;?> > &nbsp;Buy Back
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
        getStock();
        stkOption();
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
    $('.stk_cd_option').change(function(){
        stkOption();
    })
    function getClient()
    {
        var result = [];
        $('#Rptportfolio_client_cd').autocomplete(
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
            $('#Rptportfolio_client_cd').prop('disabled',true);
        }
        else
        {
            $('#Rptportfolio_client_cd').prop('disabled',false);
        }
    }
    function branchOption()
    {
        if($('#branch_option_0').is(':checked'))
        {
            $('#Rptportfolio_branch_cd').prop('disabled',true);
        }
        else
        {
            $('#Rptportfolio_branch_cd').prop('disabled',false);
        }
        
    }
    function remOption()
    {
        if($('#rem_option_0').is(':checked'))
        {
            $('#Rptportfolio_rem_cd').prop('disabled',true);
        }
        else
        {
            $('#Rptportfolio_rem_cd').prop('disabled',false);
        }
    }
     function stkOption()
    {
        if($('#stk_cd_option_0').is(':checked'))
        {
            $('#Rptportfolio_stk_cd').prop('disabled',true);
        }
        else
        {
            $('#Rptportfolio_stk_cd').prop('disabled',false);
        }
    }
    
    function getStock()
{ 
        var result = [];
        $('#Rptportfolio_stk_cd').autocomplete(
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
                    $(this).autocomplete("widget").width(500);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
</script>
