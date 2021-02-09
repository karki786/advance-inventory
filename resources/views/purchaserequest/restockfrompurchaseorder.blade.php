@extends('layouts.master')

@section('title')
    Create New Purchase Order
@endsection


@section('content')
    <style>
        .editablegrid-received {
            background: rgb(255, 255, 224) !important;
        }

    </style>
    <section class="content-header">
        <h1>
            Restock Item From Purchase Order
            <small>Restock Items from an existing purchase order</small>
        </h1>

    </section>
    <hr/>
    {!! Form::open(array('action' => 'PurchaseOrderController@postRestockFromPurchaseOrder', 'onsubmit' => 'return postForm();',
    'files'=>false)) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default cls-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Restock from Purchase Order
                    </h3>
                </div>

                <div class="panel-body">
                    <p class="alert alert-info error" style="display: none">

                    </p>

                    <div id="tablecontent">

                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary btn-block">Restock With Above Values</button>
                </div>
            </div>
        </div>


        <input type="hidden" name="order" id="orderDetails"/>
        <input type="hidden" name="supplierId" value="{{$product->polSupplierId}}" id="supplierID"/>
        <input type="hidden" name="polId" value="{{$id}}" id="supplierID"/>
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
                        {"name": "productName", "label": "Product", "datatype": "string", "editable": false},
                        {"name": "unitCost", "label": "Unit Cost", "datatype": "string", "editable": false},
                        {"name": "reorder", "label": "Reorder Amount", "datatype": "double(2)", "editable": false},
                        {"name": "received", "label": "Receive Goods", "datatype": "double(2)", "editable": true},
                        {
                            "name": "delivered",
                            "label": "Amount Delivered So Far",
                            "datatype": "string",
                            "editable": false
                        },
                        {"name": "orderId", "label": "Order ID", "datatype": "string", "editable": false},
                    ];


                    var data = {!!$orders!!};
                editableGrid = new EditableGrid("DemoGridJSON", {
                    baseUrl: "{{url()}}"
                });
                editableGrid.load({"metadata": metadata, "data": data});
                var orders = [];
                var rowCount = editableGrid.getRowCount();
                for (i = 0; i < rowCount; i++) {
                    orders.push(editableGrid.getRowValues(i))
                }
                $("#orderDetails").val(JSON.stringify(orders));

                //editableGrid.addCellValidator("delivered", new CellValidator({ isValid: function(value) { return value == 0 || (parseInt(value) <= 16); } }));
                //function to render our two demo charts
                EditableGrid.prototype.renderCharts = function () {

                };


                function updateVals(editableGrid) {
                    var orders = [];
                    var rowCount = editableGrid.getRowCount();
                    $(".error").html("");
                    $(".error").hide();
                    for (i = 0; i < rowCount; i++) {
                        var row = editableGrid.getRowValues(i);
                        console.log(row.reorder - row.received);
                        var valid = row.reorder - row.delivered;
                       console.log(row);
                        if (row.received <= row.reorder - row.delivered) {
                            orders.push(editableGrid.getRowValues(i))
                        } else {
                            $(".error").show();
                            $(".error").append(row.productName + " : Received Ammount cannot be greater than Reorder ammount, Item will not be restocked <br/>");
                        }

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
                        url: "{!!url('order/api/reorder/')!!}/" + theID,
                        beforeSend: function (xhr) {
                            $("#addOrder").text("Loading");
                            $("#addOrder").attr('disabled', 'disabled')
                        }
                    })
                            .done(function (msg) {
                                var rowCount = editableGrid.getRowCount();
                                rowCount = rowCount - 1;
                                editableGrid.insertAfter(rowCount, msg.id, msg.values);
                                updateVals(editableGrid);
                                $("#addOrder").text("Add Order");
                                $("#addOrder").removeAttr('disabled');
                            });
                });

                $('#deliverBy').datepicker({
                    format: "yyyy/mm/dd"
                });
                }
            </script>
@endsection