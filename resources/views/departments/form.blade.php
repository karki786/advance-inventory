<div class="panel panel-default cls-panel">
    <div class="panel-heading">
        <h3 class="panel-title"> {!! Helper::translateAndShorten('Add A Department','department',50)!!}</h3>
    </div>

    @if(isset($department))
        {!! Form::model($department, ['action' => ['DepartmentController@update', $department->id], 'method' => 'patch']) !!}
    @else
        {!! Form::open(array('action' => 'DepartmentController@store', 'files'=>false)) !!}
    @endif
    <div class="panel-body">
        <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
            {!! Form::label('name',  trans('department.Department Name') ) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group{!! $errors->has('budgetLimit') ? ' has-error' : '' !!}">
            {!! Form::label('budgetLimit', trans('department.Budget Limit')) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                {!! Form::text('budgetLimit', null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('budgetLimit', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group{!! $errors->has('departmentEmail') ? ' has-error' : '' !!}">
            {!! Form::label('departmentEmail', trans('department.Department Email')) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                {!! Form::text('departmentEmail', null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('departmentEmail', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group{!! $errors->has('budgetStartDate') ? ' has-error' : '' !!}">
            {!! Form::label('budgetStartDate', trans('department.Budget Start Date')) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <date name="budgetStartDate"/>
            </div>
            {!! $errors->first('budgetStartDate', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group{!! $errors->has('budgetEndDate') ? ' has-error' : '' !!}">
            {!! Form::label('budgetEndDate', trans('department.Budget End Date')) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <date name="budgetEndDate"/>
            </div>
            {!! $errors->first('budgetEndDate', '<p class="help-block">:message</p>') !!}
        </div>


    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-flat bg-green btn-block save_form"> <i class="fa fa-users"></i> @lang('department.Save Department')</button>
        {!! Form::close() !!}
    </div>
</div>
