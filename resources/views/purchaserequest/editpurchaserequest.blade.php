@extends('layouts.master')

@section('title')
    Create New Purchase Order
@endsection


@section('content')
    <style>
        .editablegrid-reorder, .editablegrid-productName, .editablegrid-taxable,.editablegrid-unitCost {
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
            Create New Purchase Order
            <small></small>
        </h1>

    </section>
    <hr/>
    {!! Form::model($product, ['action' => ['PurchaseOrderController@update', $id], 'method' => 'patch'])
    !!}
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

    <div id="tablecontent">

    </div>
    <div class="row">
        <div class="col-md-12">
            <span class='ttcost pull-right '>Total Cost :  <span
                        class="totalCost">0</span></span>
        </div>
    </div>
    <input type="hidden" name="order" id="orderDetails"/>
    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                Terms
            </h3>
        </div>

        <div class="panel-body">

            <div class="form-group{!! $errors->has('supplierName') ? ' has-error' : '' !!}">
                {!! Form::label('supplierName', 'Supplier Name') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::select('supplierName',$suppliers, null, ['class' => 'form-control']) !!}
                </div>
                {!! $errors->first('supplierName', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('deliverBy') ? ' has-error' : '' !!}">
                {!! Form::label('deliverBy', 'Deliver By') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    {!! Form::text('deliverBy', null, ['class' => 'form-control','placeholder'=>'Deliver By','id'=>'deliverBy'])
                    !!}

                </div>
                {!! $errors->first('deliverBy', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('termsOfPayment') ? ' has-error' : '' !!}">
                {!! Form::label('termsOfPayment', 'Terms Of Payment') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-file"></i></span>
                    {!! Form::text('termsOfPayment', null, ['class' => 'form-control','placeholder'=>'Terms of Payment']) !!}
                </div>
                {!! $errors->first('termsOfPayment', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('lpoDate') ? ' has-error' : '' !!}">
                {!! Form::label('lpoDate', 'Lpo Date') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    {!! Form::text('lpoDate', Carbon\Carbon::today()->format('Y/m/d'), ['class' => 'form-control','placeholder'=>'lpo Date']) !!}
                </div>
                {!! $errors->first('lpoDate', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{!! $errors->has('departmentId') ? ' has-error' : '' !!}">
                {!! Form::label('departmentId', 'Department') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    {!! Form::select('departmentId',$departments, null,['class' => 'form-control']) !!}
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                </div>
                {!! $errors->first('departmentId', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group{!! $errors->has('totalCost') ? ' has-error' : '' !!}">
                {!! Form::label('totalCost', 'Total Cost of Order') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    {!! Form::text('totalCost', null, ['class' => 'form-control totalCost','placeholder'=>'Total Cost']) !!}

                </div>
                {!! $errors->first('totalCost', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group{!! $errors->has('lpoCurrencyType') ? ' has-error' : '' !!}">
                {!! Form::label('lpoCurrencyType', 'Currency Type For LPO') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    {!! Form::select('lpoCurrencyType',array('KES'=>'KES','EURO'=>'EURO','USD'=>'USD'), null, ['class' => 'form-control']) !!}
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                </div>
                {!! $errors->first('lpoCurrencyType', '<p class="help-block">:message</p>') !!}
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

    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                LPO Status
            </h3>
        </div>

        <div class="panel-body">
            <div class="form-group{!! $errors->has('lpoStatus') ? ' has-error' : '' !!}">
                {!! Form::label('lpoStatus', 'lpoStatus') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-file"></i></span>
                    {!! Form::select('lpoStatus',array('Awaiting Approval'=>'Awaiting Approval','rejected'=>'Rejected','approved'=>'Approved'), null, ['class' => 'form-control']) !!}
                    <span class="input-group-addon"><i class="fa fa-file"></i></span>
                </div>
                {!! $errors->first('lpoStatus', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group{!! $errors->has('rejectionReason') ? ' has-error' : '' !!}">
                {!! Form::label('rejectionReason', 'Rejection Reason') !!}
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                    {!! Form::text('rejectionReason', null, ['class' => 'form-control','placeholder'=>'Rejection Reason']) !!}
                    <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                </div>
                {!! $errors->first('rejectionReason', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-flat bg-green btn-block">Save Purchase Order</button>
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
                {"name": "productName", "label": "Product", "datatype": "string", "editable": true},
                {"name": "unitCost", "label": "Unit Cost", "datatype": "double(2)", "editable": true},
                {"name": "taxable", "label": "Taxable (T)", "datatype": "string", "editable": true},
                {"name": "reorder", "label": "Reorder Amount", "datatype": "double(2)", "editable": true},
                {"name": "cost", "label": "Cost", "datatype": "double(2)", "editable": false},
                {"name": "action", "label": "Action", "datatype": "string", "editable": false}

            ];


            var data = {!!$orders!!};
            editableGrid = new EditableGrid("DemoGridJSON", {
                baseUrl: "{{url()}}"
            });
            editableGrid.load({"metadata": metadata, "data": data});
            var orders = [];
            var rowCount = editableGrid.getRowCount();
            var total = 0;
            for (i = 0; i < rowCount; i++) {
                var costColumn = editableGrid.getColumnIndex("cost");
                var unitCost = editableGrid.getValueAt(i, editableGrid.getColumnIndex("unitCost"));
                var reorder = editableGrid.getValueAt(i, editableGrid.getColumnIndex("reorder"));
                var cost = parseFloat(unitCost) * parseFloat(reorder);
                editableGrid.setValueAt(i, costColumn, numberWithCommas(cost.toFixed(2)));
                orders.push(editableGrid.getRowValues(i))
                total = (parseFloat(total) + cost).toFixed(2);
            }
            $("#totalCost").val(numberWithCommas(total));
            $(".totalCost").html(numberWithCommas(total));
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

            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function updateVals(editableGrid) {
                console.log(editableGrid.getRowCount());
                console.log(editableGrid.getRowValues(2));
                var orders = [];
                var rowCount = editableGrid.getRowCount();
                var total = 0;
                for (i = 0; i < rowCount; i++) {
                    var costColumn = editableGrid.getColumnIndex("cost");
                    var unitCost = editableGrid.getValueAt(i, editableGrid.getColumnIndex("unitCost"));
                    var reorder = editableGrid.getValueAt(i, editableGrid.getColumnIndex("reorder"));
                    var cost = parseFloat(unitCost) * parseFloat(reorder);
                    editableGrid.setValueAt(i, costColumn, numberWithCommas(cost.toFixed(2)));
                    orders.push(editableGrid.getRowValues(i))
                    total = (parseFloat(total) + cost).toFixed(2);
                }
                $("#totalCost").val(numberWithCommas(total));
                $(".totalCost").html(numberWithCommas(total));
                console.log(orders);
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
                    url: "{!!url('order/api/reorder/')!!}/" + theID,
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
            $('#deliverBy, #lpoDate').datepicker({
                format: "yyyy/mm/dd"
            });
        }
    </script>
@endsection