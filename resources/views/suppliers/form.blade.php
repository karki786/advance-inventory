
<div class="panel panel-default cls-panel" >
  <div class="panel-heading">
    <h3 class="panel-title">
     {!! Helper::translateAndShorten('Add A Supplier','supplier',50)!!}
    </h3>
  </div>
    @if(isset($supplier))
        {!! Form::model($supplier, ['action' => ['SupplierController@update', $supplier->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'SupplierController@store', 'onsubmit' => 'return postForm();', 'files'=>false)) !!}
    @endif
  <div class="panel-body">
      <div class="form-group{!! $errors->has('supplierName') ? ' has-error' : '' !!}">
          {!! Form::label('supplierName',  trans('supplier.Supplier Name') ) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              {!! Form::text('supplierName', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('supplierName', '<p class="help-block">:message</p>') !!}
      </div>

      <div class="form-group{!! $errors->has('address') ? ' has-error' : '' !!}">
          {!! Form::label('address',trans('supplier.Supplier Address')) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
              {!! Form::text('address', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
      </div>

      <div class="form-group{!! $errors->has('location') ? ' has-error' : '' !!}">
          {!! Form::label('location',trans('supplier.Supplier Premise')) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
              {!! Form::text('location', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
      </div>

      <div class="form-group{!! $errors->has('website') ? ' has-error' : '' !!}">
          {!! Form::label('website',trans('supplier.Website')) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-globe"></i></span>
              {!! Form::text('website', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
      </div>

      <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!}">
          {!! Form::label('email',trans('supplier.Email')) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
              {!! Form::text('email', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
      </div>

      <div class="form-group{!! $errors->has('phone') ? ' has-error' : '' !!}">
          {!! Form::label('phone',trans('supplier.Phone')) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-phone"></i></span>
              {!! Form::text('phone', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group{!! $errors->has('remarks') ? ' has-error' : '' !!}">
          {!! Form::label('remarks',trans('supplier.Remarks')) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-comment"></i></span>
              {!! Form::textarea('remarks', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('remarks', '<p class="help-block">:message</p>') !!}
      </div>

      <div class="form-group{!! $errors->has('supplierDiscount') ? ' has-error' : '' !!}">
          {!! Form::label('supplierDiscount',trans('supplier.Supplier Discount Percentage')) !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-calculator"></i></span>
              {!! Form::text('supplierDiscount', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('supplierDiscount', '<p class="help-block">:message</p>') !!}
      </div>


  </div>
    <div class="panel-footer">
        <button class="btn btn-flat save_form bg-green btn-block" type="submit"><i class="fa fa-shopping-cart"></i> @lang('supplier.Save Supplier') </button>
    </div>
    {!! Form::close() !!}
</div>
