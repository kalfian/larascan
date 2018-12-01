@extends('layouts.master')
@section('title')
    Barcode Scanner
@endsection
@section('content')
<div class="container">
    <section class="content">
        <div class="box box-default">
            <div class="box-body">
                <div class="clearfix">
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-add">Tambah</button>
                </div>
                <div id="tableView" class="box-body table-responsive no-padding">
                    
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <form action="{{ route('product.store') }}" method="POST" id="add-form">{{ csrf_field() }}
        <input type="hidden" value="0" name="_more">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah Produksi</h4>
            </div>
            <div class="modal-body">
                    <div id="msg-modal">
                        
                    </div>
                    <div class="form-group">
                        <label for="loc">Lokasi Perkebunan</label>
                        <input type="text" class="form-control" name="loc" id="loc" placeholder="lokasi perkebunan...">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="batch">Batch Produksi</label>
                        <input type="number" class="form-control" name="batch" id="batch" placeholder="Batch ke...">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="exp">Expired Date</label>
                        <input type="text" class="form-control" name="exp" id="exp" placeholder="Tanggal kadaluarsa...">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="karton">Jumlah Karton</label>
                        <input type="number" class="form-control" name="karton" id="karton" placeholder="Jumlah karton...">
                        <span class="help-block"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveadd" class="btn btn-primary">Save & Add another</button>
                <button type="button" id="save" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    </div>
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
    function reloadData(){
        $.ajax({
            method: "get",
            url: "{{ route('product.data') }}",
            success:function(e){
                    $("#tableView").html(e);
                    $("#product-table").DataTable();
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
        $("input[name=loc]").attr('readonly','readonly');
        $("input[name=batch]").attr('readonly','readonly');
        $("input[name=exp]").attr('readonly','readonly');
        $("input[name=karton]").attr('readonly','readonly');
    }
    function enableInput(){
        $("input[name=loc]").removeAttr('readonly');
        $("input[name=batch]").removeAttr('readonly');
        $("input[name=exp]").removeAttr('readonly');
        $("input[name=karton]").removeAttr('readonly');
    }
    function saveData(add=0){
        disableAction();
        disableInput();
        $("input").parent().removeClass('has-error');
        $("input").parent().find('.help-block').text("");
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
                        $("input[name=loc]").parent().find('.help-block').text(e.error_msg.loc);
                    }
                    if(e.error_msg.batch){
                        $("input[name=batch]").parent().addClass('has-error');
                        $("input[name=batch]").parent().find('.help-block').text(e.error_msg.batch);
                    }
                    if(e.error_msg.exp){
                        $("input[name=exp]").parent().addClass('has-error');
                        $("input[name=exp]").parent().find('.help-block').text(e.error_msg.exp);
                    }
                    if(e.error_msg.karton){
                        $("input[name=karton]").parent().addClass('has-error');
                        $("input[name=karton]").parent().find('.help-block').text(e.error_msg.karton);
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
                        $("#modal-add").modal('hide');
                    }
                }

                
            }
        });
    }   
    reloadData();
    $("#saveadd").on('click',function(){
        saveData(1);
    });
    $("#save").on('click',function(){
        saveData();
    });
    
    $("#searchbox").keyup(function() {
        dataTable.fnFilter(this.value);
    });
    $("#exp").datepicker({
        autoclose: true
    });
</script>
@endsection