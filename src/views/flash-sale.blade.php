@extends(View::exists('layouts.app') ? 'layouts.app' : 'mineralcms.flashsale.app');

@section('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style>
.js-dataTable-mineral td:last-child{
    text-align: center;
}
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Flash Sale <a href="{{ url('flash-sale/form') }}" class="btn btn-primary btn-xs" ><i class="tiny mdi mdi-plus"></i></a></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Manage Flash Sale</h6>
                <div class="table-responsive">
                    <table class="table dataTable no-footer table-striped js-dataTable-mineral" id="table-data" width="100%">
                        <thead width="100%">
                            <tr>
                                <th>Name</th>
                                <th>Discount</th>
                                <th>Is Active?</th>
                                <th class="hidden-xs" style="width: 15%;">Created At</th>
                                <th class="text-center" style="width: 10%;">Updated At</th>
                                <th class="text-center" style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
     
@endsection

@section('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script type="text/javascript">
    //Mineral - Set Datatable Configuratsion
    $('#table-data').DataTable({
        responsive: true,
        "autoWidth": false,
        'ajax' : '{{ url("flash-sale/datatable") }}',
        'columns' : [
            { data: 'name', name: 'name' },
            { data: 'discount', name: 'discount' },
            { data: 'is_publish', name: 'is_publish' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        'order': [[ 2, 'desc' ]],
        'columnDefs' : [ { orderable: false, targets: [ 4 ] } ],
        'pageLength' : 10,
        'lengthMenu' : [[5, 10, 15, 20], [5, 10, 15, 20]]
    }); 

</script>
@endsection

@section('custom-scripts')
<script src="{{ asset('assets/js/data-table.js') }}"></script>

@endsection