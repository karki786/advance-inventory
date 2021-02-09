<div id="delete-popup" class="white-popup mfp-hide">
    {!! Form::open(array( 'method' =>
    'delete','class'=>'return_form')) !!}
<p>By deleting this you are deleting the custom column from your table. Are you sure you want to do this?</p>
    <button class=" btn btn-primary btn-block" type="submit"><i class="  fa fa-remove"></i> Yes Delete this Column
    </button>
    </td>
    {!! Form::close() !!}
</div>
