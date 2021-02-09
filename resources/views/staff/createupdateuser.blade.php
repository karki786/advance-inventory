@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} |  @lang('staff.Edit/Create Users')
@endsection

@section('heading')
@lang('staff.Create Staff')
@endsection
@section('content')
    @include('staff.form')
@endsection

@section('js')
    $('select').select2({
    allowClear: true,
    placeholder: "Please Select ",
    //Allow manually entered text in drop down.
    createSearchChoice: function (term, data) {
    if ($(data).filter(function () {
    return this.text.localeCompare(term) === 0;
    }).length === 0) {
    return {id: term, text: term};
    }
    },
    });

    Dropzone.options.image = {
    maxFiles: 1,
    url: "{!! url('/user/upload/photo') !!}",
    paramName: "file",
    dictDefaultMessage: "Upload User Avatar",
    acceptedFiles: "image/*",
    headers: {
    "X-CSRF-Token": $('input[name="_token"]').val()
    },
    uploadprogress: function (progress, bytesSent) {
    console.log(progress);
    },
    success:function(file,response){
    console.log(response.save_path);
    $('input[name="avatar"]').val(response.save_path);
    },
    maxfilesexceeded: function(file) {
    this.removeAllFiles();
    this.addFile(file);
    }
    };
@endsection