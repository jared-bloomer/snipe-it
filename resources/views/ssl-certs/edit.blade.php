@extends('layouts/edit-form', [
    'createText' => trans('admin/ssl-certs/form.create') ,
    'updateText' => trans('admin/ssl-certs/form.update'),
    'helpTitle' => trans('admin/ssl-certs/general.about_ssl-certs_title'),
    'helpText' => trans('admin/ssl-certs/general.about_ssl-certs_text'),
    'formAction' => ($item) ? route('ssl-certs.update', ['ssl-cert' => $item->id]) : route('ssl-cert.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/ssl-certs/form.name')])
@include ('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'ssl-cert'])


<!-- Serial-->
@can('viewKeys', $item)
<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
    <label for="serial" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.ssl-cert_key') }}</label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'serial')) ? ' required' : '' }}">
        <textarea class="form-control" type="text" name="serial" id="serial">{{ Input::old('serial', $item->serial) }}</textarea>
        {!! $errors->first('serial', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>
@endcan

<!-- Seats -->
<div class="form-group {{ $errors->has('seats') ? ' has-error' : '' }}">
    <label for="seats" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.seats') }}</label>
    <div class="col-md-7 col-sm-12 required">
        <div class="col-md-2" style="padding-left:0px">
            <input class="form-control" type="text" name="seats" id="seats" value="{{ Input::old('seats', $item->seats) }}" />
        </div>
    </div>
    {!! $errors->first('seats', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
</div>

@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id', 'required' => 'true'])

<!-- SSL-Certsd to name -->
<div class="form-group {{ $errors->has('ssl-cert_name') ? ' has-error' : '' }}">
    <label for="ssl-cert_name" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.to_name') }}</label>
    <div class="col-md-7">
        <input class="form-control" type="text" name="ssl-cert_name" id="ssl-cert_name" value="{{ Input::old('ssl-cert_name', $item->ssl-cert_name) }}" />
        {!! $errors->first('ssl-cert_name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- SSL-Certsd to email -->
<div class="form-group {{ $errors->has('ssl-cert_email') ? ' has-error' : '' }}">
    <label for="ssl-cert_email" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.to_email') }}</label>
    <div class="col-md-7">
        <input class="form-control" type="text" name="ssl-cert_email" id="ssl-cert_email" value="{{ Input::old('ssl-cert_email', $item->ssl-cert_email) }}" />
        {!! $errors->first('ssl-cert_email', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- Reassignable -->
<div class="form-group {{ $errors->has('reassignable') ? ' has-error' : '' }}">
    <label for="reassignable" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.reassignable') }}</label>
    <div class="col-md-7 input-group">
        {{ Form::Checkbox('reassignable', '1', Input::old('reassignable', $item->id ? $item->reassignable : '1'),array('class' => 'minimal')) }}
        {{ trans('general.yes') }}
    </div>
</div>


@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.purchase_cost')
@include ('partials.forms.edit.purchase_date')

<!-- Expiration Date -->
<div class="form-group {{ $errors->has('expiration_date') ? ' has-error' : '' }}">
    <label for="expiration_date" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.expiration') }}</label>

    <div class="input-group col-md-3">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expiration_date" id="expiration_date" value="{{ Input::old('expiration_date', $item->expiration_date) }}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
        {!! $errors->first('expiration_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>

</div>

<!-- Termination Date -->
<div class="form-group {{ $errors->has('termination_date') ? ' has-error' : '' }}">
    <label for="termination_date" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.termination_date') }}</label>

    <div class="input-group col-md-3">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="termination_date" id="termination_date" value="{{ Input::old('termination_date', $item->termination_date) }}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
        {!! $errors->first('termination_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

{{-- @TODO How does this differ from Order #? --}}
<!-- Purchase Order -->
<div class="form-group {{ $errors->has('purchase_order') ? ' has-error' : '' }}">
    <label for="purchase_order" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.purchase_order') }}</label>
    <div class="col-md-3">
        <input class="form-control" type="text" name="purchase_order" id="purchase_order" value="{{ Input::old('purchase_order', $item->purchase_order) }}" />
        {!! $errors->first('purchase_order', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.depreciation')

<!-- Maintained -->
<div class="form-group {{ $errors->has('maintained') ? ' has-error' : '' }}">
    <label for="maintained" class="col-md-3 control-label">{{ trans('admin/ssl-certs/form.maintained') }}</label>
    <div class="checkbox col-md-7">
        {{ Form::Checkbox('maintained', '1', Input::old('maintained', $item->maintained),array('class' => 'minimal')) }}
        {{ trans('general.yes') }}
    </div>
</div>

@include ('partials.forms.edit.notes')

@stop
