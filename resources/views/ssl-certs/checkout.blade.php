@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/ssl-certs/general.checkout') }}
@parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
        <!-- left column -->
    <div class="col-md-7">
        <form class="form-horizontal" method="post" action="" autocomplete="off">
            {{csrf_field()}}

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"> {{ $ssl-cert->name }}</h3>
                </div>
                <div class="box-body">

                    <!-- Asset name -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('admin/hardware/form.name') }}</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ $ssl-cert->name }}</p>
                        </div>
                    </div>

                    <!-- Serial -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('admin/hardware/form.serial') }}</label>
                        <div class="col-md-9">
                            <p class="form-control-static" style="word-wrap: break-word;">
                                @can('viewKeys', $ssl-cert)
                                    {{ $ssl-cert->serial }}
                                @else
                                    ------------
                                @endcan
                            </p>
                        </div>
                    </div>

                    @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'false'])

                    @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'fieldname' => 'assigned_to', 'required'=>'true'])

                    @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/ssl-certs/form.asset'), 'fieldname' => 'asset_id', 'style' => 'display:none;'])


                    <!-- Note -->
                    <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                        <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                        <div class="col-md-7">
                            <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note') }}</textarea>
                            {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                    </div>
                </div>


                @if ($ssl-cert->requireAcceptance() || $ssl-cert->getEula() || ($snipeSettings->slack_endpoint!=''))
                    <div class="form-group notification-callout">
                        <div class="col-md-8 col-md-offset-3">
                            <div class="callout callout-info">

                                @if ($ssl-cert->requireAcceptance())
                                    <i class="fa fa-envelope"></i>
                                    {{ trans('admin/categories/general.required_acceptance') }}
                                    <br>
                                @endif

                                @if ($ssl-cert->getEula())
                                    <i class="fa fa-envelope"></i>
                                    {{ trans('admin/categories/general.required_eula') }}
                                    <br>
                                @endif

                                @if (($ssl-cert->category) && ($ssl-cert->category->checkin_email))
                                    <i class="fa fa-envelope"></i>
                                    {{ trans('admin/categories/general.checkin_email_notification') }}
                                    <br>
                                @endif

                                @if ($snipeSettings->slack_endpoint!='')
                                    <i class="fa fa-slack"></i>
                                    A slack message will be sent
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="box-footer">
                    <a class="btn btn-link" href="{{ route('ssl-certs.index') }}">{{ trans('button.cancel') }}</a>
                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
                </div>
            </div> <!-- /.box-->
        </form>
    </div> <!-- /.col-md-7-->
</div>

@stop
