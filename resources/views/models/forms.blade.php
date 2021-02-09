    {!! Form::open(array('action' => 'ModelModifyController@store', 'files'=>false)) !!}
        
  <div class="form-group{!! $errors->has('columnName') ? ' has-error' : '' !!}">
          {!! Form::label('columnName', 'Column Name to Be added') !!}
          <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-columns"></i></span>
              {!! Form::text('columnName', null, ['class' => 'form-control']) !!}
          </div>
          {!! $errors->first('columnName', '<p class="help-block">:message</p>') !!}
      </div>

    <div class="form-group{!! $errors->has('table') ? ' has-error' : '' !!}">
            {!! Form::label('table', 'Table to add Column to') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-table"></i></span>
                 {!! Form::select('table',array('departments'=>'departments','dispatches'=>'dispatches','products'=>'products','restocks'=>'restocks','suppliers'=>'suppliers','users'=>'users'), null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('table', '<p class="help-block">:message</p>') !!}
        </div>

    <div class="form-group{!! $errors->has('columnType') ? ' has-error' : '' !!}">
            {!! Form::label('columnType', 'Column Type') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-columns"></i></span>
                 {!! Form::select('columnType',array('char'=>'char','date'=>'date','dateTime'=>'dateTime','decimal'=>'decimal','double'=>'double','float'=>'float','integer'=>'integer','longText'=>'longText','string'=>'string','text'=>'text'), null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('columnType', '<p class="help-block">:message</p>') !!}
        </div>
    <div class="form-group{!! $errors->has('fontawesome') ? ' has-error' : '' !!}">
            {!! Form::label('fontawesome', 'FontAwesome Icon') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-f"></i></span>
                 {!! Form::select('fontawesome',$fonts, null, ['class' => 'form-control fontawesome']) !!}
            </div>
            {!! $errors->first('fontawesome', '<p class="help-block">:message</p>') !!}
        </div>

    <div class="form-group{!! $errors->has('userView') ? ' has-error' : '' !!}">
            {!! Form::label('userView', 'User Representation of Column') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-eye"></i></span>
                {!! Form::text('userView', null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('userView', '<p class="help-block">:message</p>') !!}
        </div>

    <div class="form-group{!! $errors->has('renderAs') ? ' has-error' : '' !!}">
            {!! Form::label('renderAs', 'Render Input as') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-reorder"></i></span>
                 {!! Form::select('renderAs',array('select','input','textarea'), null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('renderAs', '<p class="help-block">:message</p>') !!}
        </div>
    <button class="btn btn-primary btn-block" type="submit">Add Column</button>

        
        {!! Form::close() !!}
