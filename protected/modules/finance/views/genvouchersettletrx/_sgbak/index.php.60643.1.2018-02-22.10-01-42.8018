<style>
    .radio.inline{margin-top:5px}
    
    .radio.inline label{margin-left: 15px;}
    
    .tnumber, .tnumberdec
    {
        text-align:right
    }
</style>

<?php
$this->breadcrumbs=array(
    'Generate Voucher to Settle Transaction'=>array('index'),
    'List',
);

$this->menu=array(
    array('label'=>'Generate Voucher to Settle Transaction', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
    array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
    array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php 
    //$bankAccount = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'RDI_PAY' AND param_cd2 = 'BANK' and param_cd3 = 'BCA02'");
    $bankAccountNonRdi = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'NON_RDI' AND param_cd2 = 'BANK'");
    $cust_flg = Sysparam::model()->find("param_id = 'GEN VCH SETTLE TRX' AND param_cd1 = 'TYPE' AND param_cd2 = 'CUSTODY' and param_cd3='RDI' ")->dflg1;
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'tpayrech-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal'
)); ?>

    <?php 
        echo $form->errorSummary($model); 
        
        foreach($modelVoucherList as $row)
        {
            echo $form->errorSummary($row);
        }
    ?>
    <br />

    <div class="row-fluid">
        <div class="span4">
            <div class="span4">
                <?php echo $form->labelEx($model,'trx_date',array('class'=>'control-label')) ?>
            </div>
            <?php echo $form->datePickerRow($model,'trx_date',array('id'=>'trxDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
            <input type="hidden" id="trxDate_hid" value="<?php echo $model->trx_date ?>" />
        </div>
        <div class="span4">
            <div class="span2">
                <?php echo $form->labelEx($model,'Type',array('class'=>'control-label')) ?>
            </div>
            <?php echo $form->radioButtonListInlineRow($model,'client_type',array('R'=>'Regular','C'=>'Custody','CR'=>'Custody with Rekening Dana'),array('class'=>'clientType','label'=>false)) ?>
            <input type="hidden" id="clientType_hid" value="<?php echo $model->client_type ?>" />
        </div>
        <div id="bankAccount_div" class="span4" style="<?php if($model->client_type == 'R')echo 'display:none' ?>">
            <div class="span4">
                <?php echo $form->labelEx($model,'Bank Account',array('class'=>'control-label')) ?>
            </div>
            <?php echo $form->textField($model,'gl_acct_cd',array('id'=>'glAcctCd','class'=>'span3','value'=>$model->client_type=='R'?'':$bankAccountNonRdi->dstr1,'readonly'=>true)) ?>
            <?php echo $form->textField($model,'sl_acct_cd',array('id'=>'slAcctCd','class'=>'span5','value'=>$model->client_type=='R'?'':$bankAccountNonRdi->dstr2,'readonly'=>true)) ?>
        </div>
    </div>
    
    <div class="row-fluid">
        <div class="span4">
            <div class="span4">
                <?php echo $form->labelEx($model,'due_date',array('class'=>'control-label')) ?>
            </div>
            <?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'label'=>false)); ?>
            <input type="hidden" id="dueDate_hid" value="<?php echo $model->due_date ?>" />
        </div>
        <div id="brchCd_span" class="span4" <?php if($model->client_type != 'R')echo "style='display:none'" ?>>
            <div class="span4">
                <?php echo $form->labelEx($model,'Branch Code',array('class'=>'control-label')) ?>
            </div>
            <?php echo $form->dropDownList($model,'brch_cd',array_merge(array('%'=>'ALL'),CHtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'brch_cd')), 'brch_cd', 'CodeAndName')),array('class'=>'span8','id'=>'brchCd')) ?>
            <input type="hidden" id="brchCd_hid" value="<?php echo $model->brch_cd ?>" />
        </div>
    </div>
    
    <br/>
    
    <div class="row-fluid">
        <div class="span4">
            
        </div>
        <div class="span4" style="text-align:right">
            <div id="retrieve" style="float:left">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'id'=>'btnRetrieve',
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Retrieve',
                    'htmlOptions'=>array('name'=>'submit','value'=>'retrieve')
                )); ?>
            </div>
            
            <div class="span1" style="float:left">
                
            </div>
            
            <div id="submit" style="float:left">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'id'=>'btnSubmit',
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Process',
                    'htmlOptions'=>array('name'=>'submit','value'=>'submit','disabled'=>!$retrieved)
                )); ?>
            </div>
        </div>
    </div>
    
    <br/>

<?php   
    if($retrieved)
    {
        echo $this->renderPartial('list',array('model'=>$model,'modelVoucherList'=>$modelVoucherList,'form'=>$form)) ;
    }
?>

<?php $this->endWidget(); ?>

<script>
    $(document).ready(function()
    {
        checkAll();
        countTotal();
        if('<?php echo $cust_flg;?>'=='N')
        {
            $('#GenVoucherSettleTrx_client_type_2').prop('disabled',true);
        }
    });

    $(".clientType").change(function()
    {
        branchControl();
        setBankAccount();
    });

    $("#trxDate").change(function()
    {
        $.ajax({
            'type'     :'POST',
            'url'      : '<?php echo $this->createUrl('ajxGetDueDate'); ?>',
            'dataType' : 'json',
            'data'     : {
                            'trxDate':$("#trxDate").val(),
                    },
            'success'  : function(data){
                $("#dueDate").val(data).datepicker('update');
            }
        });
    });
    
    $("#btnSubmit").click(function()
    {
        setFilterValue();
    });
    
    function branchControl()
    {
        if(!$(".clientType[value=R]").is(":checked"))
        {
            $("#brchCd_span").hide();
        }
        else
        {
            $("#brchCd_span").show();
        }
    }
    
    function checkAll()
    {
        var checkAll = true;
        
        $("#tableVchList").children("tbody").children('tr.first').each(function()
        {
            if(!$(this).children('td.generate').children("[type=checkbox]").is(':checked'))
            {
                checkAll = false;
                return false;
            }
        });
        
        if(checkAll)
        {
            $("#checkAll").prop('checked',true);
        }
        else
        {
            $("#checkAll").prop('checked',false);
        }
    }
    
    function setFilterValue()
    {
        var oldClientType = $("#clientType_hid").val();
        $(".clientType[value="+oldClientType+"]").prop('checked',true).change();
        
        $("#brchCd").val($("#brchCd_hid").val());
        $("#trxDate").val($("#trxDate_hid").val()).datepicker('update');
        $("#dueDate").val($("#dueDate_hid").val()).datepicker('update');
    }
    
    function countTotal()
    {
        var vchCnt = buyAmt = sellAmt = 0;
        
        $("#tableVchList").children('tbody').children('tr').each(function()
        {
            if($(this).children('td.generate').children('[type=checkbox]').is(':checked'))
            {
                vchCnt++;
                buyAmt+= parseFloat(setting.func.number.removeCommas($(this).children('td.netBuy').children('[type=text]').val()));
                sellAmt+= parseFloat(setting.func.number.removeCommas($(this).children('td.netSell').children('[type=text]').val()));
            }       
        });
        
        $("#totalVoucher").html(vchCnt);
        $("#totalBuy").val(buyAmt).blur();
        $("#totalSell").val(sellAmt).blur();
    }
    
    function setBankAccount()
    {
        if(!$(".clientType[value=R]").is(":checked"))
        {
            $("#glAcctCd").val('<?php echo $bankAccountNonRdi->dstr1 ?>');
            $("#slAcctCd").val('<?php echo $bankAccountNonRdi->dstr2 ?>');
            $("#bankAccount_div").show();
        }
        else
        {
            $("#bankAccount_div").hide();
            $("#glAcctCd").val('');
            $("#slAcctCd").val('');
        }
    }
    
</script>