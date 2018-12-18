@extends('layouts.master')
@section('title')
    Barcode Scanner
@endsection
@section('content')
<div class="container">
    <section class="content">
        <div class="box box-default">
            <div class="box-body">
                <div class="box-body">
                    <form action="{{ route('product.store') }}" method="POST" id="add-form">{{ csrf_field() }}
                        <input type="hidden" value="0" name="_more">
                        <div id="msg-modal"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="loc">Lokasi Perkebunan</label>
                                {{-- <input type="text" class="form-control" name="loc" id="loc" placeholder="lokasi perkebunan..."> --}}
                                <select name="loc" id="loc" class="form-control">
                                    <option value="Malang">Malang</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Jakarta">Jakarta</option>
                                </select>
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exp">Expired Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control" name="exp" id="exp" placeholder="Tanggal kadaluarsa...">
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="batch">Batch Produksi</label>
                                <input type="number" class="form-control" name="batch" id="batch" placeholder="Batch ke...">
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="karton">Jumlah Karton</label>
                                <input type="number" class="form-control" name="karton" id="karton" placeholder="Jumlah karton...">
                            </div>
                            <span class="help-block"></span>
                        </div>
                        <div class="col-md-12">
                            <div class="clearfix">
                                <button type="button" id="saveadd" class="pull-right btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="container">
    <section class="content">
        <div class="box box-default">
            <div class="box-body">
                <div class="clearfix">
                    <div class="col-md-4">
                    <select class="form-control pull-left" id="kertas">
                        <option value="A4">A4</option>
                        <option value="A5">A5</option>
                        <option value="B5">B5</option>
                    </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchbox" placeholder="Cari ...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('product.all') }}" id="getBatch" method="POST" target="_blank">
                                {{ csrf_field() }}
                                <input onkeypress="" type="hidden" id="selectedItem" name="d">
                                <a style="margin-right: 20px" onclick="event.preventDefault();
                                document.getElementById('getBatch').submit();" type="button" class="btn btn-warning pull-right">Print Batch</a>
                        </form>
                    </div>
                </div>
                <div id="tableView" class="box-body table-responsive no-padding">
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('style')
<style>
    div#product-table_filter {
        display: none;
    }
    div#product-table_length {
        display: none;
    }
</style>
@endsection
@section('script')

<script>
    function getDetail(e){
        let ukuran = $("#kertas").val();
        window.open($(e).attr('href')+"/"+ukuran,'_blank');
    }
    function printBatch(){
        var items=document.getElementsByName('batch');
        var selectedItems="";
        for(var i=0; i<items.length; i++){
            if(items[i].type=='checkbox' && items[i].checked==true)
            selectedItems+= ","+items[i].value;
        }
        $("#selectedItem").val(selectedItems.substr(1));
    }
    $(document).ready(function(){
        reloadData();
    });
    function selectAll(e){
        var items=document.getElementsByName('batch');
        if(!$(e).is(':checked')){
            for(var i=0; i<items.length; i++){
                items[i].checked=false
            }
        }else{
            for(var i=0; i<items.length; i++){
                if(items[i].type=='checkbox' && items[i].checked===false)
                    items[i].checked=true
            }
        }
    }
    function reloadData(){
        $.ajax({
            method: "get",
            url: "{{ route('product.data') }}",
            success:function(e){
                    $("#tableView").html(e);
                    $("#product-table").DataTable({
                        columnDefs: [ {
                            orderable: false,
                            className: 'select-checkbox',
                            targets:   0
                        } ],
                        select: {
                            style:    'os',
                            selector: 'td:first-child'
                        },
                        order: [[ 1, 'asc' ]]
                    });
            }
        });
    }
    function disableAction(){
        $('#saveadd').attr('disabled','disabled');
        $('#save').attr('disabled','disabled');
    }
    function enableAction(){
        $('#saveadd').removeAttr('disabled');
        $('#save').removeAttr('disabled');
    }
    function disableInput(){
        $("select[name=loc]").attr('readonly','readonly');
        $("input[name=batch]").attr('readonly','readonly');
        $("input[name=exp]").attr('readonly','readonly');
        $("input[name=karton]").attr('readonly','readonly');
    }
    function enableInput(){
        $("select[name=loc]").removeAttr('readonly');
        $("input[name=batch]").removeAttr('readonly');
        $("input[name=exp]").removeAttr('readonly');
        $("input[name=karton]").removeAttr('readonly');
    }
    function hideModal(){
        $("#modal-add").modal('hide');
        $("#msg-modal").html();
    }
    function saveData(add=0){
        disableAction();
        disableInput();
        $("input").parent().removeClass('has-error');
        $("input").parent().parent().find('.help-block').text("");
        $.ajax({
            method: "post",
            url: "{{ route('product.store') }}",
            data: $("#add-form").serialize(),
            // contentType: "JSON",
            success:function(e){
                console.log($("#add-form").serialize());
                if(e.status == 0){
                    if(e.error_msg.loc){
                        $("input[name=loc]").parent().addClass('has-error');
                        $("input[name=loc]").parent().parent().find('.help-block').text(e.error_msg.loc);
                    }
                    if(e.error_msg.batch){
                        $("input[name=batch]").parent().addClass('has-error');
                        $("input[name=batch]").parent().parent().find('.help-block').text(e.error_msg.batch);
                    }
                    if(e.error_msg.exp){
                        $("input[name=exp]").parent().addClass('has-error');
                        $("input[name=exp]").parent().parent().find('.help-block').text(e.error_msg.exp);
                    }
                    if(e.error_msg.karton){
                        $("input[name=karton]").parent().addClass('has-error');
                        $("input[name=karton]").parent().parent().find('.help-block').text(e.error_msg.karton);
                    }
                    enableInput();
                    enableAction();
                }else if(e.status == 1){
                    reloadData();
                    $("#add-form")[0].reset();
                    enableAction();
                    enableInput();
                    if(add == 1){
                        $("#msg-modal").html(e.data);
                    }else{
                        $("#msg-modal").html(e.data);
                        hideModal();
                    }
                }

                
            }
        });
    }   
    
    $("#close").on('click',function(){
        $("#add-form")[0].reset();
    });
    $("#saveadd").on('click',function(){
        saveData(1);
    });
    $("#save").on('click',function(){
        saveData();
    });
    
    $("#searchbox").keyup(function() {
        $("input[type=search]").keyup();
        $("input[type=search]").val($(this).val());
    });
    $("#exp").datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
</script>
@endsection