@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/ssl-certs/general.view') }}
 - {{ $ssl-cert->name }}
@parent
@stop

{{-- Right header --}}
@section('header_right')
<div class="btn-group pull-right">
  @can('update', $ssl-cert)
    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="{{ route('ssl-certs.edit', ['ssl-cert' => $ssl-cert->id]) }}">{{ trans('admin/ssl-certs/general.edit') }}</a></li>
        <li><a href="{{ route('clone/ssl-cert', $ssl-cert->id) }}">{{ trans('admin/ssl-certs/general.clone') }}</a></li>
    </ul>
   @endcan
</div>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
        <li><a href="#uploads" data-toggle="tab">{{ trans('general.file_uploads') }}</a></li>
        <li><a href="#history" data-toggle="tab">{{ trans('admin/ssl-certs/general.checkout_history') }}</a></li>
        <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip"></i> {{ trans('button.upload') }}</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-8">

              <div class="table-responsive">

                <table
                        data-columns="{{ \App\Presenters\SSL-CertsPresenter::dataTableLayoutSeats() }}"
                        data-cookie-id-table="seatsTable-{{ $ssl-cert->id }}"
                        data-id-table="seatsTable-{{ $ssl-cert->id }}"
                        id="seatsTable-{{$ssl-cert->id}}"
                        data-pagination="true"
                        data-search="false"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        class="table table-striped snipe-table"
                        data-url="{{ route('api.ssl-cert.seats',['ssl-cert_id' => $ssl-cert->id]) }}"
                        data-export-options='{
                        "fileName": "export-seats-{{ str_slug($ssl-cert->name) }}-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
                </table>

              </div>

            </div>

            <div class="col-md-4">
              <div class="table">
                <table class="table">
                  <tbody>
                    @if (!is_null($ssl-cert->company))
                    <tr>
                      <td>{{ trans('general.company') }}</td>
                      <td>{{ $ssl-cert->company->name }}</td>
                    </tr>
                    @endif

                    @if ($ssl-cert->manufacturer)
                      <tr>
                        <td>{{ trans('admin/hardware/form.manufacturer') }}:</td>
                        <td><p style="line-height: 23px;">
                          @can('view', \App\Models\Manufacturer::class)
                            <a href="{{ route('manufacturers.show', $ssl-cert->manufacturer->id) }}">
                              {{ $ssl-cert->manufacturer->name }}
                            </a>
                          @else
                            {{ $ssl-cert->manufacturer->name }}
                          @endcan

                          @if ($ssl-cert->manufacturer->url)
                            <br><i class="fa fa-globe"></i> <a href="{{ $ssl-cert->manufacturer->url }}" rel="noopener">{{ $ssl-cert->manufacturer->url }}</a>
                          @endif

                          @if ($ssl-cert->manufacturer->support_url)
                            <br><i class="fa fa-life-ring"></i>
                              <a href="{{ $ssl-cert->manufacturer->support_url }}"  rel="noopener">{{ $ssl-cert->manufacturer->support_url }}</a>
                          @endif

                          @if ($ssl-cert->manufacturer->support_phone)
                            <br><i class="fa fa-phone"></i>
                              <a href="tel:{{ $ssl-cert->manufacturer->support_phone }}">{{ $ssl-cert->manufacturer->support_phone }}</a>
                          @endif

                          @if ($ssl-cert->manufacturer->support_email)
                            <br><i class="fa fa-envelope"></i> <a href="mailto:{{ $ssl-cert->manufacturer->support_email }}">{{ $ssl-cert->manufacturer->support_email }}</a>
                          @endif
                          </p>
                        </td>
                      </tr>
                    @endif


                      @if (!is_null($ssl-cert->serial))
                      <tr>
                        <td>{{ trans('admin/ssl-certs/form.ssl-cert_key') }}: </td>
                        <td style="word-wrap: break-word;overflow-wrap: break-word;word-break: break-word;">
                          @can('viewKeys', $ssl-cert)
                            {!! nl2br(e($ssl-cert->serial)) !!}
                          @else
                           ------------
                          @endcan

                        </td>
                      </tr>
                      @endif

                    @if ($ssl-cert->category)
                      <tr>
                        <td>{{ trans('general.category') }}: </td>
                        <td style="word-wrap: break-word;overflow-wrap: break-word;word-break: break-word;">
                          <a href="{{ route('categories.show', $ssl-cert->category->id) }}">{{ $ssl-cert->category->name }}</a>
                        </td>
                      </tr>
                    @endif


                    @if ($ssl-cert->ssl-cert_name!='')
                    <tr>
                      <td>{{ trans('admin/ssl-certs/form.to_name') }}: </td>
                      <td>{{ $ssl-cert->ssl-cert_name }}</td>
                    </tr>
                    @endif

                    @if ($ssl-cert->ssl-cert_email!='')
                    <tr>
                      <td>{{ trans('admin/ssl-certs/form.to_email') }}:</td>
                      <td>{{ $ssl-cert->ssl-cert_email }}</td>
                    </tr>
                    @endif

                    @if ($ssl-cert->supplier_id)
                    <tr>
                      <td>{{ trans('general.supplier') }}:
                      </td>
                      <td>
                        <a href="{{ route('suppliers.show', $ssl-cert->supplier_id) }}">
                          {{ $ssl-cert->supplier->name }}
                        </a>
                      </td>
                    </tr>
                    @endif

                    @if (isset($ssl-cert->expiration_date))
                    <tr>
                      <td>{{ trans('admin/ssl-certs/form.expiration') }}:</td>
                      <td>{{ $ssl-cert->expiration_date }}</td>
                    </tr>
                    @endif

                    @if ($ssl-cert->depreciation)
                      <tr>
                        <td>
                          {{ trans('admin/hardware/form.depreciation') }}:
                        </td>
                        <td>
                          {{ $ssl-cert->depreciation->name }}
                          ({{ $ssl-cert->depreciation->months }}
                          {{ trans('admin/hardware/form.months') }}
                          )
                        </td>
                      </tr>
                      <tr>
                        <td>
                          {{ trans('admin/hardware/form.depreciates_on') }}:
                        </td>
                        <td>
                          {{ $ssl-cert->depreciated_date()->format("Y-m-d") }}
                        </td>
                      </tr>

                      <tr>
                        <td>
                          {{ trans('admin/hardware/form.fully_depreciated') }}:
                        </td>
                        <td>
                        @if ($ssl-cert->time_until_depreciated()->y > 0)
                          {{ $ssl-cert->time_until_depreciated()->y }}
                          {{ trans('admin/hardware/form.years') }},
                        @endif
                        {{ $ssl-cert->time_until_depreciated()->m }}
                        {{ trans('admin/hardware/form.months') }}
                        </td>
                      </tr>
                    @endif

                    @if ($ssl-cert->purchase_order)
                    <tr>
                      <td>
                        {{ trans('admin/ssl-certs/form.purchase_order') }}:
                      </td>
                      <td>
                        {{ $ssl-cert->purchase_order }}
                      </td>
                    </tr>
                    @endif

                    @if (isset($ssl-cert->purchase_date))
                    <tr>
                      <td>{{ trans('general.purchase_date') }}:</td>
                      <td>{{ $ssl-cert->purchase_date }}</td>
                    </tr>
                    @endif

                    @if ($ssl-cert->purchase_cost > 0)
                    <tr>
                      <td>{{ trans('general.purchase_cost') }}:</td>
                      <td>
                        {{ $snipeSettings->default_currency }}
                        {{ \App\Helpers\Helper::formatCurrencyOutput($ssl-cert->purchase_cost) }}
                      </td>
                    </tr>
                    @endif

                    @if ($ssl-cert->order_number)
                    <tr>
                      <td>{{ trans('general.order_number') }}:</td>
                      <td>{{ $ssl-cert->order_number }}</td>
                    </tr>
                    @endif

                    @if (($ssl-cert->seats) && ($ssl-cert->seats) > 0)
                    <tr>
                      <td>{{ trans('admin/ssl-certs/form.seats') }}:</td>
                      <td>{{ $ssl-cert->seats }}</td>
                    </tr>
                    @endif

                    <tr>
                      <td>{{ trans('admin/ssl-certs/form.reassignable') }}:</td>
                      <td>{{ $ssl-cert->reassignable ? 'Yes' : 'No' }}</td>
                    </tr>

                    @if ($ssl-cert->notes)
                    <tr>
                      <td>{{ trans('general.notes') }}:</td>
                      <td>
                        {!! nl2br(e($ssl-cert->notes)) !!}
                      </td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div> <!-- .table-->
            </div> <!--/.col-md-5-->
          </div> <!--/.row-->
        </div> <!-- /.tab-pane -->

        <div class="tab-pane" id="uploads">
          <div class="table-responsive">
            <table
                data-cookie-id-table="ssl-certUploadsTable"
                data-id-table="ssl-certUploadsTable"
                id="ssl-certUploadsTable"
                data-search="true"
                data-pagination="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-footer="true"
                data-toolbar="#upload-toolbar"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                class="table table-striped snipe-table"
                data-export-options='{
                    "fileName": "export-ssl-cert-uploads-{{ str_slug($ssl-cert->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>
            <thead>
              <tr>
                <th data-visible="true"></th>
                <th class="col-md-4" data-field="file_name" data-visible="true" data-sortable="true" data-switchable="true">{{ trans('general.file_name') }}</th>
                <th class="col-md-4" data-field="notes" data-visible="true" data-sortable="true" data-switchable="true">{{ trans('general.notes') }}</th>
                <th class="col-md-2" data-field="created_at" data-visible="true"  data-sortable="true" data-switchable="true">{{ trans('general.created_at') }}</th>
                <th class="col-md-2" data-searchable="true" data-visible="true">{{ trans('general.image') }}</th>
                <th class="col-md-2" data-field="download" data-visible="true"  data-sortable="false" data-switchable="true">Download</th>
                <th class="col-md-2" data-field="delete" data-visible="true"  data-sortable="false" data-switchable="true">Delete</th>
              </tr>
            </thead>
            <tbody>
            @if ($ssl-cert->uploads->count() > 0)
              @foreach ($ssl-cert->uploads as $file)
              <tr>
                <td><i class="{{ \App\Helpers\Helper::filetype_icon($file->filename) }} icon-med"></i></td>
                <td>
                  {{ $file->filename }}

                </td>
                <td>
                  @if ($file->note)
                    {{ $file->note }}
                  @endif
                </td>
                <td>{{ $file->created_at }}</td>
                <td>
                @if ($file->filename)
                    @if ( \App\Helpers\Helper::checkUploadIsImage($file->get_src('ssl-certs')))
                      <a href="{{ route('show.ssl-certfile', ['ssl-certId' => $ssl-cert->id, 'fileId' => $file->id, 'download' => 'false']) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show.ssl-certfile', ['ssl-certId' => $ssl-cert->id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                    @endif
                @endif
                </td>
                <td>
                  @if ($file->filename)
                    <a href="{{ route('show.ssl-certfile', [$ssl-cert->id, $file->id, 'download' => 'true']) }}" class="btn btn-default"><i class="fa fa-download"></i></a>
                  @endif
                </td>
                <td>
                  <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/ssl-certfile', [$ssl-cert->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?"><i class="fa fa-trash icon-white"></i></a>
                </td>
              </tr>
              @endforeach
            @else
              <tr>
              <td colspan="6">{{ trans('general.no_results') }}</td>
              </tr>
            @endif
            </tbody>
          </table>
          </div>
        </div> <!-- /.tab-pane -->

        <div class="tab-pane" id="history">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
              <table
                      class="table table-striped snipe-table"
                      data-cookie-id-table="dsffsdfssl-certHistoryTable"
                      data-id-table="dsffsdfssl-certHistoryTable"
                      id="dsffsdfssl-certHistoryTable"
                      data-pagination="true"
                      data-show-columns="true"
                      data-side-pagination="server"
                      data-show-refresh="true"
                      data-show-export="true"
                      data-sort-order="desc"
                      data-export-options='{
                       "fileName": "export-{{ str_slug($ssl-cert->name) }}-history-{{ date('Y-m-d') }}",
                       "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                     }'
                      data-url="{{ route('api.activity.index', ['item_id' => $ssl-cert->id, 'item_type' => 'ssl-cert']) }}">

                <thead>
                <tr>
                  <th class="col-sm-2" data-visible="true" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                  <th class="col-sm-2"data-visible="true" data-sortable="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                  <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                  <th class="col-sm-2" data-sortable="true" data-visible="true" data-field="note">{{ trans('general.notes') }}</th>
                  @if  ($snipeSettings->require_accept_signature=='1')
                    <th class="col-md-3" data-field="signature_file" data-visible="false"  data-formatter="imageFormatter">{{ trans('general.signature') }}</th>
                  @endif
                </tr>
                </thead>
              </table>
              </div>
            </div> <!-- /.col-md-12-->
          </div> <!-- /.row-->
        </div> <!-- /.tab-pane -->
      </div> <!-- /.tab-content -->
    </div> <!-- nav-tabs-custom -->
  </div>  <!-- /.col -->
</div> <!-- /.row -->

@can('update', \App\Models\SSL-Certs::class)
  @include ('modals.upload-file', ['item_type' => 'ssl-cert', 'item_id' => $ssl-cert->id])
@endcan

@stop


@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop

