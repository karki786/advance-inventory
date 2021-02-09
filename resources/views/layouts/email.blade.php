<div id="email-popup" class="white-popup mfp-hide">
    {!! Form::open(array( 'method' =>
    'get','class'=>'email_form')) !!}
    <p style="padding: 20px;"><b>Please provide the email you want to send this info to you can replace the default email your admin has sent</b></p>

    <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!}">
        {!! Form::label('email', 'Email') !!}
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
    <button class=" btn btn-primary btn-block" type="submit"><i class="  fa fa-submit"></i> Send Email
    </button>
    </td>
    {!! Form::close() !!}
</div>
