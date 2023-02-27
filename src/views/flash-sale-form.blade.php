@extends(View::exists('layouts.app') ? 'layouts.app' : 'mineralcms.flashsale.app')

@section('title', 'Flash Sale')

@section('plugin-styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<style>
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; }
.toggle.ios .toggle-handle { border-radius: 20rem; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Flash Sale <a href="{{ url('menu') }}" class="btn btn-primary btn-xs" ><i class="tiny mdi mdi-plus"></i></a></h4>
    </div>
</div>
<form id="form" method="post" >
	{{ csrf_field() }}
	<div class="row">
		
		<div class="col-md-6 grid-margin stretch-card">
			<div class="card" style="max-height: 560px;">
				<div class="card-body" >
					{{-- <h4 class="mb-4">General Information</h4> --}}
	                <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="name">Name</label>
	                            <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name" required value="{{ $flashsale->name }}" />
	                        </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="excerpt">Excerpt</label>
	                            <textarea class="form-control" name="excerpt" placeholder="Ringkasan Deskripsi" >{{$flashsale->excerpt}}</textarea>
	                        </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="excerpt">Discount Type</label>
	                            <select class="form-control" name="type" >
	                            	<option value="">-- Select Type --</option>
	                            	<option value="DISCOUNT" {{ $flashsale->type == 'DISCOUNT' ? 'selected' : '' }}>DISCOUNT</option>
	                            	<option value="FREE_ONGKIR" {{ $flashsale->type == 'FREE_ONGKIR' ? 'selected' : '' }}>FREE ONGKIR</option>
	                            </select>
	                        </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="name">Tier level user</label>
	                            <select class="form-control" name="user_level">
	                            	@foreach(config('flashsale.user_level') as $key => $level)
	                            	<option value="{{ $key }}" {{ ($flashsale->user_level == $key ? 'selected' : '')}}>{{ $level}}</option>
	                            	@endforeach
	                            </select>
	                        </div>
                    	</div>
                    </div>
                    <div class="row">
	                    <div class="col-6">
	                    	<div class="form-group">
	                            <label for="discount_price">Discount (IDR)</label>
	                            <input type="number" name="discount_price" class="form-control" id="discount_price" placeholder="10000" value="{{ $flashsale->discount_price }}">
	                        </div>
	                    </div>
	                    <div class="col-6">
	                    	<div class="form-group">
	                            <label for="discount_percent">Discount (%)</label>
	                            <input type="number" name="discount_percent" class="form-control" id="discount_percent" placeholder="10" value="{{ $flashsale->discount_percent }}">
	                        </div>
	                    </div>
	                </div>

                    {{-- <div class="row mt-2"> --}}
                    	<div class="row">
	                        <div class="col-6">
	                            <label for="price">Publish Date</label>
	                            <div class="form-group">
	                                <div class="input-group date date-time" id="datetimepicker" data-target-input="nearest" data-date="{{ $flashsale->published_at ? $flashsale->published_at->format('Y-m-d H:i:s') : date('Y-m-d H:i:s') }}">
	                                    <input type="text" name="pdate" class="form-control datetimepicker-input" data-target="#datetimepicker" />
	                                    <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
	                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-6">
	                            <label for="price">Ended Date</label>
	                            <div class="form-group">
	                                <div class="input-group date date-time" id="datetimepicker1" data-target-input="nearest" data-date="{{ $flashsale->ended_at ? $flashsale->ended_at->format('Y-m-d H:i:s') : date('Y-m-d H:i:s') }}">
	                                    <input type="text" name="edate" class="form-control datetimepicker-input" data-target="#datetimepicker1" />
	                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
	                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
                    	</div>
                    {{-- </div> --}}

                    <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <input type="checkbox" name="is_publish" value="1" {{ ($flashsale->is_publish == 1 ? "checked" : "") }} data-toggle="toggle" data-onstyle="success" data-size="xs" data-style="ios"> publish?
	                        </div>
	                    </div>
                    </div>

                    <div class="row">
                    	<div class="col-md-12">
		                    <div class="form-group">
		                        <button class="btn btn-success" name="action" value="save" type="submit"><i class="si si-check push-5-r"></i> Save</button>
		                        @if(!empty($flashsale->id))
		                        <button class="btn btn-danger" name="action" value="delete" type="submit" data-name="{{ $flashsale->name }}"><i class="si si-trash push-5-r"></i> Delete</button>
		                        @endif
                        	</div>
                        </div>
                    </div>
				</div>
			</div>
		</div>

		<div class="col-md-4 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
                        <div class="col-xs-12">
                            <label for="product-tree">Choose Product</label>
                             <div class="px-2 pb-2">
	                            <input type="text" x-ref="category" id="cat-src" class="form-control" placeholder="Search Product">
	                        </div>
	                        <label for="chkSelectAll">
	                        	<input type="checkbox" class="mr-2 ml-2" name="chkSelectAll" id="chkSelectAll" >Select All<br />
	                        </label>
                            <div id="product-tree" style="overflow-y:scroll; overflow-x:scroll; max-height: 500px;"></div>
                            <div id="prod-holder"></div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection

@section('plugin-scripts')
    <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

@endsection

@section('custom-scripts')
    <script src="{{ asset('assets/js/tinymce.js?date='.date('ymd')) }}"></script>    
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/timepicker.js?date='.date('ymd')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/jstree.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.1/dist/alpine.min.js" defer></script>

    <script type="text/javascript">
    	$(function(){
			// $('.date-time').each(function() {
	            $('#datetimepicker').datetimepicker({
	                format: 'DD-MM-YYYY HH:mm',
	                defaultDate: $('#datetimepicker').data('date'),
	            });

	            $('#datetimepicker1').datetimepicker({
	                format: 'DD-MM-YYYY HH:mm',
	                defaultDate: $('#datetimepicker1').data('date'),
	            });
	        // });

	         $("#cat-src").keyup(function (){
                var searchString = $(this).val();
                $("#product-tree").jstree('search', searchString);
            });


	         $('#chkSelectAll').on('click',function () {
	         	let cxbx = $(this).is(':checked')
	         	if (cxbx) {
	         		$('#product-tree').jstree("check_all");
	         	}else{
	         		$('#product-tree').jstree("deselect_all");
	         	}
	         })

	        $('#product-tree').jstree({
		        "core" : {
		            'data' : {
		                'url' : '{{ url("flash-sale/tree/".$flashsale->id) }}',
		                'data' : function (node) {
		                    return { 'id' : node.id };
		                }
		            }
		        },
		        "plugins" : [ "dnd", "search", "checkbox"],
		        "search" : {
                    "show_only_matches" : true,
                    "show_only_matches_children" : true
                },
                 "dnd": {
		            "is_draggable": function (node) {
		                return false;  // flip switch here.
		            }
		        },
		    });

		    $("#form").on('submit',function(e){
	            e.preventDefault();
	            var selectedCategories = [];

	            //handle categories

	            var categories = $("#product-tree").jstree("get_selected",true);
	            $.each(categories,function(index,val){
	                selectedCategories.push(val.id);
	                // if(val.parent != '#') // index == 0 &&
	                // {
	                //     selectedCategories.push(val.parent);
	                // }
	                //
	                // if(selectedCategories.indexOf(val.id) == -1)
	                // {
	                //     selectedCategories.push(val.id);
	                // }

	            });

	            $.each(selectedCategories,function(index,val){
	                $('#prod-holder').append('<input type="hidden" name="products[]" value="'+val+'" />');
	            });

	            $('#form').off('submit');
	            $(this).submit();
	        });
		});
    </script>
@endsection
