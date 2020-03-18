@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/ssl-certs/general.software_ssl-certs') }}
@parent
@stop


@section('header_right')
@can('create', \App\Models\SSL-Certs::class)
    <a href="{{ route('ssl-certs.create') }}" class="btn btn-primary pull-right">
      {{ trans('general.create') }}
    </a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">

          <table
              data-columns="{{ \App\Presenters\SSL-CertsPresenter::dataTableLayout() }}"
              data-cookie-id-table="ssl-certsTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="ssl-certsTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.ssl-certs.index') }}"
              data-export-options='{
            "fileName": "export-ssl-certs-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
            }'>
          </table>

      </div><!-- /.box-body -->

      <div class="box-footer clearfix">
      </div>
    </div><!-- /.box -->
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop
