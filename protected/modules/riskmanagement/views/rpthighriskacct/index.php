<?php
$this->breadcrumbs = array(
    'High Risk Account'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'High Risk Account',
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
    <div class="span4">
        <div class="control-group">
            <div class="span3">
                <label>Date</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'trx_date', array(
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
            <div class="span3">
                <input type="radio" name="Rpthighriskacct[acct_type]" value="M" <?php echo $model->acct_type=='M'?'checked':'' ;?> > &nbsp;Margin
            </div>
            <div class="span3">
                <input type="radio" name="Rpthighriskacct[acct_type]" value="R" <?php echo $model->acct_type=='R'?'checked':'' ;?> > &nbsp;Regular
            </div>
        </div>        
         <div class="control-group">
            <div class="span3">
                <label>Client</label>
            </div>
            <div class="span3">
                 <input type="radio" class="client_option" id="client_option_0" name="Rpthighriskacct[client_option]" value="0" <?php echo $model->client_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span3">
                 <input type="radio" class="client_option" id="client_option_1" name="Rpthighriskacct[client_option]" value="1" <?php echo $model->client_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
             <div class="span3">
                 <?php echo $form->textField($model,'client_cd',array('class'=>'span12'));?>
            </div>
           
        </div>
        <div class="control-group">
            <div class="span3">
                <label>Branch</label>
            </div>
            <div class="span3">
                 <input type="radio" class="branch_option" id="branch_option_0" name="Rpthighriskacct[branch_option]" value="0" <?php echo $model->branch_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span3">
                 <input type="radio" class="branch_option" id="branch_option_1" name="Rpthighriskacct[branch_option]" value="1" <?php echo $model->branch_option=='1'?'checked':'' ;?> > &nbsp;Specified
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
                 <input type="radio" class="rem_option" id="rem_option_0" name="Rpthighriskacct[rem_option]" value="0" <?php echo $model->rem_option=='0'?'checked':'' ;?> > &nbsp;All
            </div>
            <div class="span3">
                 <input type="radio" class="rem_option" id="rem_option_1" name="Rpthighriskacct[rem_option]" value="1" <?php echo $model->rem_option=='1'?'checked':'' ;?> > &nbsp;Specified
            </div>
             <div class="span3">
                   <?php echo $form->dropDownList($model,'rem_cd',CHtml::listData($rem_cd, 'rem_cd', 'rem_name'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
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
    <div class="span4">
        <div class="control-group">
            <div class="span4">
                <label>High Risk Type</label>
            </div>
            <div class="span5">
                <input type="radio" class="high_risk_type" id="high_risk_type_0" name="Rpthighriskacct[high_risk_type]" value="LB" <?php echo $model->high_risk_type=='LB'?'checked':'' ;?> > &nbsp;Loan Besar
            </div>
        </div>
        <div class="control-group">
            <div class="offset4 span10">
                <input type="radio" class="high_risk_type" id="high_risk_type_1" name="Rpthighriskacct[high_risk_type]" value="LS" <?php echo $model->high_risk_type=='LS'?'checked':'' ;?> > &nbsp;Loan Short
            </div>
        </div>
        <div class="control-group">
            <div class="offset4 span10">
                <input type="radio" class="high_risk_type" id="high_risk_type_2" name="Rpthighriskacct[high_risk_type]" value="MC" <?php echo $model->high_risk_type=='MC'?'checked':'' ;?> > &nbsp;Margin Call
            </div>
        </div>
        <div class="control-group">
            <div class="offset4 span10">
                <input type="radio" class="high_risk_type" id="high_risk_type_3" name="Rpthighriskacct[high_risk_type]" value="LWS" <?php echo $model->high_risk_type=='LWS'?'checked':'' ;?> > &nbsp;Loan Without Stock
            </div>
        </div>
        <div class="control-group">
            <div class="offset4 span10">
                <input type="radio" class="high_risk_type" id="high_risk_type_4" name="Rpthighriskacct[high_risk_type]" value="MP" <?php echo $model->high_risk_type=='MP'?'checked':'' ;?> > &nbsp;Margin Call Problematic Client
            </div>
        </div>
    </div>
    <div class="span4">
       <div class="control-group">
           <div class="span4">
               <label>AR/AP + Buy Back</label>
           </div>
           <div class="span4">
               <?php echo $form->textField($model,'buy_back',array('class'=>'span12 tnumber','style'=>'text-align:right','readonly'=>'true'));?>
           </div>
       </div>
       <div class="control-group">
           <div class="span4">
               <label>Buy Back <> 0 </label>
           </div>
       </div>
        <div class="control-group">
           <div class="span4">
               <label>Portfolio Original</label>
           </div>
           <div class="span4">
                <?php echo $form->textField($model,'port_ori',array('class'=>'span8 tnumber','style'=>'text-align:right'));?>&nbsp;%
           </div>
       </div>
       <div class="control-group">
           <div class="span4">
               <label>Portfolio Discounted</label>
           </div>
           <div class="span4">
                <?php echo $form->textField($model,'port_disc',array('class'=>'span8 tnumber','style'=>'text-align:right'));?>&nbsp;%
           </div>
       </div>
        <div class="control-group">
           <div class="span8">
               <label>Portfolio (0), Buy Back <> 0 </label>
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
        $('#Rpthighriskacct_client_cd').autocomplete(
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
            $('#Rpthighriskacct_client_cd').prop('disabled',true);
        }
        else
        {
            $('#Rpthighriskacct_client_cd').prop('disabled',false);
        }
    }
    function branchOption()
    {
        if($('#branch_option_0').is(':checked'))
        {
            $('#Rpthighriskacct_branch_cd').prop('disabled',true);
        }
        else
        {
            $('#Rpthighriskacct_branch_cd').prop('disabled',false);
        }
        
    }
    function remOption()
    {
        if($('#rem_option_0').is(':checked'))
        {
            $('#Rpthighriskacct_rem_cd').prop('disabled',true);
        }
        else
        {
            $('#Rpthighriskacct_rem_cd').prop('disabled',false);
        }
    }
</script>
