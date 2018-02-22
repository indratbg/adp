<style>
    #tableList {
        background-color: #C3D9FF;
    }
    #tableList thead, #tableList tbody {
        display: block;
    }
    #tableList tbody {
        max-height: 300px;
        overflow: auto;
        background-color: #FFFFFF;
    }
  
</style>
<?php
$this->breadcrumbs = array(
    'Generate Daily OTC Fee Journal' => array('index'),
    'List',
);

$this->menu = array(
    array('label' => 'Generate Daily OTC Fee Journal', 'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),

    array('label' => 'List', 'url' => array('index'), 'icon' => 'list', 'itemOptions' => array('class' => 'active', 'style' => 'float:right')),
    //array('label' => 'Approval', 'url' => Yii::app()->request->baseUrl . '?r=inbox//index', 'icon' => 'list', 'itemOptions' => array('style' => 'float:right')),
);
?>



<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'Genjurbiayaotcharian-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal'
)); ?>

<br/>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?>
<?php echo $form->errorSummary(array($model));?>
 
<input type="hidden" name="scenario" id="scenario">
<input type="hidden" name="rowCount" id="rowCount">
 <div class="error_msg">
    </div>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
            <div class="span3">
                <?php echo $form->labelEx($model,'doc_dt');?>
            </div>
            <div class="span7">
            <?php echo $form->datePickerRow($model,'doc_dt',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span9','options'=>array('format' => 'dd/mm/yyyy'))); ?>    
            </div>
           
        </div>
        <div class="control-group">
            <div class="span3">
                <?php echo $form->labelEx($model,'jur_date');?>
            </div>
            <div class="span7">
            <?php echo $form->datePickerRow($model,'jur_date',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span9','options'=>array('format' => 'dd/mm/yyyy'))); ?>    
            </div>
        </div>
    </div>
    <div class="span4">
         <div class="control-group">
              <div class="span3">
                <?php echo $form->labelEx($model,'folder_cd');?>
            </div>
            <div class="span5">
                <?php echo $form->textField($model,'folder_cd',array('class'=>'span12'));?>
            </div>
         </div>
         <div class="control-group">
              <div class="span3">
                <?php echo $form->labelEx($model,'otc_fee');?>
            </div>
            <div class="span5">
                <?php echo $form->textField($model,'otc_fee',array('class'=>'span12 tnumber','style'=>'text-align:right'));?>
            </div>
         </div>
    </div>
    <div class="span4">
        <div class="control-group">
                 <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Retrieve',
                    'id'=>'btnRetrieve',
                )); ?>
                &emsp;
                 <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'label'=>'Generate',
                    'id'=>'btnSave',
                )); ?>
        </div>       
    </div>
</div>
<br />
<table id="tableList" class="table-bordered table-condensed" style="width: 83%">
    <thead>
        <tr>
            <th width="50px">Tidak dijournal</th>
            <th width="90px">Client Code</th>
            <th width="250px">Name</th>
            <th width="50px">Desc.</th>
            <th width="70px">Broker</th>
            <th width="60px">Stock</th>
            <th width="100px">Receive/Buy</th>
            <th width="100px">Withdraw/Sell</th>
            <th width="60px">OTC Fee</th>
        </tr>
    </thead>
    <tbody>
     
    </tbody>
</table>
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
    var rowCount=0;
    var valid =true;
    $('#btnRetrieve').click(function(e)
    {
        e.preventDefault();
        $('.error_msg').empty();
        $('#Genjurbiayaotcharian_folder_cd').attr('required',false);
        getData();
    })
     $('#btnSave').click(function(e)
    {
        e.preventDefault();
        $('.error_msg').empty();
        $('#Genjurbiayaotcharian_folder_cd').attr('required',true);
        if(!$('#Genjurbiayaotcharian_folder_cd').val())
        {
            $('#Genjurbiayaotcharian_folder_cd').focus();
            Message('danger', 'File No. tidak boleh kosong');
            valid=false;
        }
        else
        {
            valid=true;
        }
        saveData();
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
    
    function getData()
    {
         
         $.ajax({
                'type'     :'POST',
                'url'      : '<?php echo $this->CreateUrl('GetListData'); ?>',
                    'dataType' : 'json',
                'data'     : {  'doc_dt':$('#Genjurbiayaotcharian_doc_dt').val(),
                                'otc_fee':$('#Genjurbiayaotcharian_otc_fee').val()
                            },
                'success'  : function(data){
                    
                            if(!data.error_msg)
                            {
                            $('#tableList').find('tbody tr').remove();
                            var table = $('#tableList').find('tbody');
                            rowCount=0;
                            var temp_client='';
                            var temp_total='';
                            var client_cd_arr = new Array();
                            var temp_total = new Array();
                            var cnt_data = data.list.length;
                            
                            $.each(data.list, function(index, item) {
                                client_cd_arr[rowCount] = item.client_cd; 
                                temp_total[rowCount] = item.sum_otc;
                                
                                //untuk total per client
                                if(rowCount>0)
                                {
                                    if(item.client_cd != client_cd_arr[rowCount-1])
                                        table.append($('<tr>')
                                        .attr('id','row'+(index+1))
                                         .append($('<td>')
                                         .append($('<label>')
                                                .html('Total ')
                                                 .css('font-weight','bold')
                                            )
                                            .attr('colspan',8)
                                            .css('text-align','right')
                                           
                                        ).append($('<td>')
                                            .append($('<input>')
                                                .attr('class','span tnumber')
                                                .attr('name','Genjurbiayaotcharian['+(index+1)+'][total]')
                                                .attr('type','text')
                                                .attr('value',setting.func.number.addCommas(temp_total[rowCount-1]) )
                                                .prop('readonly',true)
                                                .css('text-align','right')
                                                .css('font-weight','bold')
                                            )
                                        )   
                                    );//end append
                                }
                                
                              
                                 
                              if(temp_client !=item.client_cd)
                                {
                                  table.append($('<tr>')
                                    .attr('id','row'+(index+1))
                                    .attr('class','jurnal')
                                     .append($('<td>')
                                        .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[tidak_dijurnal]')
                                            .attr('type','checkbox')
                                            .attr('value',item.tidak_dijurnal)
                                        )
                                         .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[doc_dt]')
                                            .attr('type','hidden')
                                            .attr('value',item.doc_dt)
                                        )
                                         .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[doc_num]')
                                            .attr('type','hidden')
                                            .attr('value',item.doc_num)
                                        )
                                        .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[sum_otc]')
                                            .attr('type','hidden')
                                            .attr('value',item.sum_otc)
                                        )
                                         .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[client_cd]')
                                            .attr('type','hidden')
                                            .attr('value',item.client_cd)
                                        )
                                        .css('text-align','center')
                                        .attr('class','tidak_dijurnal')
                                    ).append($('<td>')
                                        .attr('class','client')
                                        .append($('<input>')
                                                .attr('class','span')
                                                .attr('name','Genjurbiayaotcharian[client]')
                                                .attr('type','text')
                                                .attr('value',item.client_cd==temp_client?'':item.client_cd)
                                                .prop('readonly',true)
                                            )
                                  
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][client_name]')
                                            .attr('type','text')
                                            .attr('value',item.client_cd==temp_client?'':item.client_name)
                                            .prop('readonly',true)
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][doc_rem]')
                                            .attr('type','text')
                                            .attr('value',item.doc_rem)
                                            .prop('readonly',true)
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][broker]')
                                            .attr('type','text')
                                            .attr('value',item.broker)
                                            .prop('readonly',true)
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][stk_cd]')
                                            .attr('type','text')
                                            .attr('value',item.stk_cd)
                                            .prop('readonly',true)
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span tnumber')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][total_share_qty]')
                                            .attr('type','text')
                                            .attr('value',setting.func.number.addCommas(item.total_share_qty))
                                            .prop('readonly',true)
                                             .css('text-align','right')
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span tnumber')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][withdrawn_share_qty]')
                                            .attr('type','text')
                                            .attr('value',setting.func.number.addCommas(item.withdrawn_share_qty))
                                            .prop('readonly',true)
                                            .css('text-align','right')
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span tnumber')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][otc]')
                                            .attr('type','text')
                                            .attr('value',setting.func.number.addCommas(item.otc))
                                            .prop('readonly',true)
                                            .css('text-align','right')
                                        )
                                    )   
                                );//end append
                               }//end if client_cd<>
                               //jika client sama dengan sebelumnya
                               else
                               {
                                   table.append($('<tr>')
                                    .attr('id','row'+(index+1))
                                    .attr('class','jurnal')
                                    .append($('<td>')
                                         .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[doc_dt]')
                                            .attr('type','hidden')
                                            .attr('value',item.doc_dt)
                                        )
                                         .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[doc_num]')
                                            .attr('type','hidden')
                                            .attr('value',item.doc_num)
                                        )
                                        .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[sum_otc]')
                                            .attr('type','hidden')
                                            .attr('value',item.sum_otc)
                                        )
                                         .append($('<input>')
                                            .attr('name','Genjurbiayaotcharian[client_cd]')
                                            .attr('type','hidden')
                                            .attr('value',item.client_cd)
                                        )
                                        .css('text-align','center')
                                        .attr('class','tidak_dijurnal')
                                    )
                                    .append($('<td>')
                                    )
                                    .append($('<td>')
                                        
                                    )
                                     .append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][doc_rem]')
                                            .attr('type','text')
                                            .attr('value',item.doc_rem)
                                            .prop('readonly',true)
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][broker]')
                                            .attr('type','text')
                                            .attr('value',item.broker)
                                            .prop('readonly',true)
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][stk_cd]')
                                            .attr('type','text')
                                            .attr('value',item.stk_cd)
                                            .prop('readonly',true)
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span tnumber')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][total_share_qty]')
                                            .attr('type','text')
                                            .attr('value',setting.func.number.addCommas(item.total_share_qty))
                                            .prop('readonly',true)
                                             .css('text-align','right')
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span tnumber')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][withdrawn_share_qty]')
                                            .attr('type','text')
                                            .attr('value',setting.func.number.addCommas(item.withdrawn_share_qty))
                                            .prop('readonly',true)
                                            .css('text-align','right')
                                        )
                                    ).append($('<td>')
                                        .append($('<input>')
                                            .attr('class','span tnumber')
                                            .attr('name','Genjurbiayaotcharian['+(index+1)+'][otc]')
                                            .attr('type','text')
                                            .attr('value',setting.func.number.addCommas(item.otc))
                                            .prop('readonly',true)
                                            .css('text-align','right')
                                        )
                                    )   
                                );//end append
                               }
                                temp_client=item.client_cd;
                                rowCount++;
                                //untuk baris terakhir
                                if(rowCount == cnt_data)
                                {
                                    table.append($('<tr>')
                                    .attr('id','row'+(index+1))
                                     .append($('<td>')
                                     .append($('<label>')
                                            .html('Total ')
                                            .css('font-weight','bold')
                                        )
                                        .attr('colspan',8)
                                        .css('text-align','right')
                                        ).append($('<td>')
                                            .append($('<input>')
                                                .attr('class','span tnumber')
                                                .attr('name','Genjurbiayaotcharian['+(index+1)+'][total]')
                                                .attr('type','text')
                                                .attr('value',setting.func.number.addCommas(temp_total[rowCount-1]) )
                                                .prop('readonly',true)
                                                .css('text-align','right')
                                                .css('font-weight','bold')
                                            )
                                        )   
                                    );//end append
                                }
                                
                              
                            });//end each
                            
                            $(window).trigger('resize');
                        }
                        else
                        {
                            Message('danger', data.error_msg)
                        }   
                 },//end success
                'complete':function()
                {
                    $('#showloading').fadeOut();
                },
                'async':true
            });
    }
    
    function saveData()
    {
        var jur_date =$('#Genjurbiayaotcharian_jur_date').val();
        if(confirm('Apakah anda yakin akan menjurnal di tanggal '+jur_date+' ?'))
        {
            
        
                var tidak_dijurnal='N';
                var record = {};
                var x=0;
                var available=false;
                var temp_client='';
                var client_cd='';
                $("#tableList").children('tbody').children('tr.jurnal').each(function(index)
                 {
                     available=true;
                     client_cd=$(this).children('td.tidak_dijurnal').children("[name='Genjurbiayaotcharian[client_cd]']").val();
                     if($(this).children('td.tidak_dijurnal').children("[name='Genjurbiayaotcharian[tidak_dijurnal]']").is(':checked'))
                     {
                            tidak_dijurnal='Y';     
                     }
                    else
                    {
                        if(temp_client == client_cd)
                        {
                            tidak_dijurnal=tidak_dijurnal;
                        }
                        else
                        {
                             tidak_dijurnal='N';
                        }
                    }
                    
                    
                    
                    record[x] = {};
                    record[x]['doc_dt']= $(this).children('td.tidak_dijurnal').children("[name='Genjurbiayaotcharian[doc_dt]']").val();
                    record[x]['doc_num']= $(this).children('td.tidak_dijurnal').children("[name='Genjurbiayaotcharian[doc_num]']").val();
                    record[x]['client_cd']= client_cd;
                    record[x]['sum_otc']= $(this).children('td.tidak_dijurnal').children("[name='Genjurbiayaotcharian[sum_otc]']").val();
                    record[x]['tidak_dijurnal']= tidak_dijurnal;
                    x++;  
                    temp_client =client_cd ;
                });
                
                if(!available)
                {
                    Message('danger', 'Tidak ada data yang digenerate');
                }
               
                if(valid){
                //sent data
                    $.ajax({
                        'type'     :'POST',
                        'url'      : '<?php echo $this->CreateUrl('SaveData'); ?>',
                        'dataType' : 'json',
                        'data'     : {  'record':record,
                                        'folder_cd':$('#Genjurbiayaotcharian_folder_cd').val(),
                                        'jur_date' :$('#Genjurbiayaotcharian_jur_date').val(),
                                    },
                        'success'  : function(data)
                                    {
                                       if(data.success_msg)
                                       {
                                           Message('success', data.success_msg);
                                           $('#tableList').find('tbody tr').remove();
                                       }
                                        if(data.error_msg)
                                       {
                                           Message('danger', data.error_msg)
                                       }
                                    }
                           });
                $('#showloading').fadeOut();
                }
            }
            else
            {
                return false;
            }
        
    }
    
    
    $(window).resize(function()
    {
        alignColumn();
    })
    $(window).trigger('resize');

    function alignColumn()//align columns in thead and tbody
    {
        var header = $("#tableList").find('thead');
        var firstRow = $("#tableList").find('tbody tr');

        firstRow.find('td:eq(0)').css('width', header.find('th:eq(0)').width() + 'px');
        firstRow.find('td:eq(1)').css('width', header.find('th:eq(1)').width() + 'px');
        firstRow.find('td:eq(2)').css('width', header.find('th:eq(2)').width() + 'px');
        firstRow.find('td:eq(3)').css('width', header.find('th:eq(3)').width() + 'px');
        firstRow.find('td:eq(4)').css('width', header.find('th:eq(4)').width() + 'px');
        firstRow.find('td:eq(5)').css('width', header.find('th:eq(5)').width() + 'px');
        firstRow.find('td:eq(6)').css('width', header.find('th:eq(6)').width() + 'px');
        firstRow.find('td:eq(7)').css('width', header.find('th:eq(7)').width() + 'px');
        firstRow.find('td:eq(8)').css('width', header.find('th:eq(8)').width() + 'px');
    }
    $('#Genjurbiayaotcharian_folder_cd').change(function(){
        $('#Genjurbiayaotcharian_folder_cd').val($('#Genjurbiayaotcharian_folder_cd').val().toUpperCase());
    });
    
    $(document).ajaxStart(function(){
     $("#mywaitdialog").dialog('open');  
    });
    
    $(document).ajaxComplete(function(){
       $("#mywaitdialog").dialog('close');
    });
    $('#Genjurbiayaotcharian_doc_dt').change(function(){
        $('#Genjurbiayaotcharian_jur_date').val($('#Genjurbiayaotcharian_doc_dt').val());
    })
</script>