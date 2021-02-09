@extends('layouts.master')

@section('title')
    Create New Purchase Order
@endsection


@section('content')
    <style>
        .editablegrid-prDescription, .editablegrid-prQty, .editablegrid-prPurpose, .editablegrid-unitCost {
            background: rgb(255, 255, 224) !important;
        }

        .ttcost {
            font-size: 18px;
            margin-bottom: 5px !important;
            border: 1px;
            border-style: solid;
            border-color: #fcfcfc;
            padding: 5px;
            margin-top: -13px;
            font-weight: bold;
        }

    </style>
    <section class="content-header">
        <h1>
            Create New Purchase Request
            <small></small>
        </h1>

    </section>
    <hr/>
    @if(isset($requestDetails))
        {!! Form::model($requestDetails, ['action' => ['PurchaseRequestController@update', $requestDetails->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'PurchaseRequestController@store', 'onsubmit' => 'return postForm();',
'files'=>false)) !!}
    @endif
    <div class="row">
        <div class="col-md-6">

            <div class="panel panel-default cls-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Product That is under Stock Control
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="alert alert-info">
                        Create a Purchase Order for items in your stock by using the form below. For items that are not
                        in stock use the form in the right. The items in
                        the table below that have a yellow background are editable.
                    </div>
                    <div class="form-group{!! $errors->has('productName') ? ' has-error' : '' !!}">
                        {!! Form::label('productName', 'Product Name') !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                            {!! Form::select('productName',$products, null, ['class' => 'form-control',
                            'id'=>'productName']) !!}
                        </div>
                        {!! $errors->first('productName', '<p class="help-block">:message</p>') !!}
                    </div>


                </div>
                <div class="panel-footer">
                    <div class="btn btn-flat bg-green btn-block" id="addOrder">Add to Order</div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default cls-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Manual Product
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="form-group{!! $errors->has('productName') ? ' has-error' : '' !!}">
                        {!! Form::label('productName', 'Product Name') !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                            {!! Form::text('productName', null, ['id'=>'productName1','class' => 'form-control','placeholder'=>'Product Name']) !!}
                        </div>
                        {!! $errors->first('productName', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group{!! $errors->has('prductCount') ? ' has-error' : '' !!}">
                        {!! Form::label('prductCount', 'Product  Count') !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
                            {!! Form::text('prductCount', null, ['id'=>'productCount','class' => 'form-control','placeholder'=>'Product Count']) !!}
                        </div>
                        {!! $errors->first('prductCount', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group{!! $errors->has('unitCost') ? ' has-error' : '' !!}">
                        {!! Form::label('unitCost', 'Unit Cost') !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            {!! Form::text('unitCost', null, ['id'=>'unitCost','class' => 'form-control','placeholder'=>'Unit Cost']) !!}
                        </div>
                        {!! $errors->first('unitCost', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>


                <div class="panel-footer">
                    <div class="btn btn-flat bg-green btn-block" id="addProduct">Add to Order</div>
                </div>
            </div>

        </div>
    </div>

    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                Purchase Order Items
            </h3>
        </div>

        <div class="panel-body">
            <div id="tablecontent">

            </div>
        </div>
    </div>

    <input type="hidden" name="request" id="orderDetails"/>
    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                Terms
            </h3>
        </div>

        <div class="panel-body">
            <div class="form-group{!! $errors->has('owner') ? ' has-error' : '' !!}">
                {!! Form::label('owner', 'Owner Of Requsition') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::select('owner',$staff, null, ['class' => 'form-control']) !!}
                </div>
                {!! $errors->first('owner', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group{!! $errors->has('remindMeOn') ? ' has-error' : '' !!}">
                {!! Form::label('remindMeOn', 'Remind Me if LPO not Created On (By Default 7 days change as neccessary)') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    {!! Form::text('remindMeOn', Carbon\Carbon::today()->addDay(7)->format('Y/m/d'), ['class' => 'form-control','placeholder'=>'Reminder','id'=>'deliverBy']) !!}
                </div>
                {!! $errors->first('remindMeOn', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('departmentId') ? ' has-error' : '' !!}">
                {!! Form::label('departmentId', 'Department') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    {!! Form::select('departmentId',$departments, null, ['class' => 'form-control']) !!}
                </div>
                {!! $errors->first('departmentId', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('notifyOnLpoCreation') ? ' has-error' : '' !!}">
                {!! Form::label('notifyOnLpoCreation', 'Notify On LPO Creation') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    {!! Form::select('notifyOnLpoCreation[]',$staff, null, ['class' => 'form-control', 'multiple'=>'multiple']) !!}
                </div>
                {!! $errors->first('notifyOnLpoCreation', '<p class="help-block">:message</p>') !!}
            </div>


            <div class="form-group{!! $errors->has('remarks') ? ' has-error' : '' !!}">
                {!! Form::label('remarks', 'Remarks') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                    {!! Form::text('remarks', null, ['class' => 'form-control','placeholder'=>'']) !!}
                </div>
                {!! $errors->first('remarks', '<p class="help-block">:message</p>') !!}
            </div>


        </div>
    </div>
    <button type="submit" class="btn btn-flat bg-green btn-block">Save Purchase Request</button>
    {!! Form::close() !!}
@endsection

@section('jquery')
    <script>
        window.onload = function () {
            $('select').select2({});
            function image(relativePath) {
                return "{{url()}}/images/" + relativePath;
            }


            var metadata = [
                {"name": "id", "label": "Product ID", "datatype": "string", "editable": false},
                {
                    "name": "prDescription",
                    "label": "Description & Specification",
                    "datatype": "string",
                    "editable": true
                },
           /*     {"name": "reorderAmount", "label": "Reorder Limit", "datatype": "integer", "editable": false},*/
                {"name": "prQty", "label": "Quantity", "datatype": "double(2)", "editable": true},
                {"name": "prPurpose", "label": "Purpose", "datatype": "string", "editable": true},
                {"name": "action", "label": "Action", "datatype": "string", "editable": false}

            ];


            var data = {!!$product!!};

            editableGrid = new EditableGrid("DemoGridJSON", {
                baseUrl: "{{url()}}"
            });
            @if(Input::old('order'))
              editableGrid.load({"metadata": metadata, "data": {!!json_encode(Input::old('order'))!!}});
            @else
              editableGrid.load({"metadata": metadata, "data": data});
                    @endif

                    var orders = [];
            var rowCount = editableGrid.getRowCount();
            for (i = 0; i < rowCount; i++) {
                orders.push(editableGrid.getRowValues(i))
            }
            $("#orderDetails").val(JSON.stringify(orders));
            //function to render our two demo charts
            EditableGrid.prototype.renderCharts = function () {
                updateVals(this);
            };
            editableGrid.setCellRenderer("action", new CellRenderer({
                render: function (cell, value) {
                    // this action will remove the row, so first find the ID of the row containing this cell
                    var rowId = editableGrid.getRowId(cell.rowIndex);
                    cell.innerHTML = "<a onclick=\"if (confirm('Are you sure you want to delete this Order ? ')) { editableGrid.remove(" + cell.rowIndex + "); editableGrid.renderCharts(); } \" style=\"cursor:pointer\">" +
                            "<img src=\"" + image("delete.png") + "\" border=\"0\" alt=\"delete\" title=\"Delete row\"/></a>";
                }
            }));


            function updateVals(editableGrid) {
                console.log(editableGrid.getRowCount());
                console.log(editableGrid.getRowValues(2));
                var orders = [];
                var rowCount = editableGrid.getRowCount();

                for (i = 0; i < rowCount; i++) {
                    orders.push(editableGrid.getRowValues(i))
                }
                $("#orderDetails").val(JSON.stringify(orders));
            }

            editableGrid.modelChanged = function (rowIndex, columnIndex, oldValue, newValue, row) {
                updateVals(editableGrid);
            }
            editableGrid.renderGrid("tablecontent", "table table-paper table-hover table-bordered");

            $("#addOrder").click(function () {
                var theID = $("#productName").select2('val');
                $.ajax({
                    method: "GET",
                    url: "{{url()}}/request/api/reorder/" + theID,
                    beforeSend: function (xhr) {
                        $("#addOrder").text("Loading");
                        $("#addOrder").attr('disabled', 'disabled')
                    }
                })
                        .done(function (msg) {
                            var rowCount = editableGrid.getRowCount();
                            rowCount = rowCount - 1;
                            console.log(rowCount);
                            console.log(msg.values);
                            editableGrid.insertAfter(rowCount, msg.id, msg.values);
                            updateVals(editableGrid);
                            $("#addOrder").text("Add Order");
                            $("#addOrder").removeAttr('disabled');
                        });
            });

            $("#addProduct").click(function () {
                var rowCount = editableGrid.getRowCount();
                rowCount = rowCount - 1;
                var productCount = $("#productCount").val();
                var productName = $("#productName1").val();
                var unitCost = $("#unitCost").val();
                var values = {
                    'id': "0",
                    'productName': productName,
                    'reorderAmount': 0,
                    'amount': 0,
                    'unitCost': unitCost,
                    'reorder': productCount
                };
                var id = rowCount + 1;
                editableGrid.insertAfter(rowCount, id, values);
                updateVals(editableGrid);
            });
            //

            $('#deliverBy, #lpoDate').datepicker({
                format: "yyyy/mm/dd"
            });
        }
    </script>
@endsection