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
        <h4 class="mb-3 mb-md-0">Flash Sale <a href="{{ url('flash-sale/form') }}" class="btn btn-primary btn-xs" ><i class="tiny mdi mdi-plus"></i></a></h4>
    </div>
</div>
<form id="form" method="post" >
	{{ csrf_field() }}
	<div class="row" id="app">
		
		<div class="col-md-6 grid-margin stretch-card">
			<div class="card" style="max-height: 640px;">
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
	                            <select class="form-control" name="type" id="type">
	                            	<option value="DISCOUNT" {{ $flashsale->type == 'DISCOUNT' ? 'selected' : '' }}>DISCOUNT</option>
	                            	<option value="FREE_ONGKIR" {{ $flashsale->type == 'FREE_ONGKIR' ? 'selected' : '' }}>FREE ONGKIR</option>
	                            </select>
	                        </div>
                    	</div>
                    </div>
                    <div class="row" style="display:none">
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
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="name">Minimum Qty</label>
	                              <input type="number" name="minimum_qty" class="form-control" id="minimum_qty" placeholder="1" value="{{ $flashsale->minimum_qty }}">
	                        </div>
                    	</div>
                    </div>
                    <div class="row" id="discount_value" {{ $flashsale->type == 'FREE_ONGKIR' ? "style=display:none" : '' }} >
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

		<div class="col-md-5 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
                        <div class="col-xs-12">
                            <label for="product-tree">Choose Product</label>
                            <div >
                            	<div class="d-flex justify-content-between">
                            		<div class="form-group">
                            			<select class="form-control" v-model="limit" title="Show List">
                            				<option>15</option>
                            				<option>25</option>
                            				<option>50</option>
                            				<option>100</option>
                            			</select>
                            		</div>
					            	<div class="form-check">
	                            		<label class="form-check-label" title="Select all product in list ">
						                	<input type="checkbox" class="form-check-input" v-model="select_all"> Select All
						              	</label>
					            	</div>
					            	<div class="form-check">
						              	<label class="form-check-label" title="Show only published product">
						                	<input type="checkbox" v-model="publish" class="form-check-input"> Show publish
						              	</label>
                            		</div>
                            	</div>
                            	<div class="list-area">
									<div class="form-group">
										<input type="text" v-model="search" class="form-control" placeholder="Type to search">
									</div>
									<div class="d-flex justify-content-end">
										<span v-if="selectedProducts.length > 0">@{{ selectedProducts.length }} Products Selected</span>
									</div>

									<div class="list-group">
										<template v-for="product in products">
										 	<a class="px-3 py-1 d-flex justify-content-between list-group-item list-group-item-action" :class="[{'bg-secondary text-white' : checkInArray(product, selectedProducts)}]" @click="selectItem(product.id)" :title="product.name">
										    	<span v-html="product.text_sort"></span>
										    	<button v-if="checkInArray(product, selectedProducts)" class="btn btn-danger btn-icon btn-sm" style="width:25px!important; height: 25px!important;"><span class="mdi mdi-delete"></span></button>
										  	</a>
										</template>
									</div>

									<div class="d-flex justify-content-between">
										<p style="margin-top:15px">Page @{{paginate.currentPage}} of @{{ paginate.lastPage}}</p>
										{{-- <div class="form-check">
		                            		<label class="form-check-label" title="Salect All product">
							                	<input type="checkbox" class="form-check-input" name="choose_all"> Choose All Product
							              	</label>

						            	</div> --}}

						            	<select class="form-control w-50" name="choose_all" style="margin-top:10px">
						            		<option value="">- Bulk Selection -</option>
						            		<option value="all">- All Product -</option>
						            		<option value="publish">- Published Only -</option>
						            		<option value="deselect">- Deselect All -</option>
						            	</select>
									</div>
									<nav aria-label="Page navigation example" style="margin-top:10px">
									 	<ul class="pagination">
									    	<li class="page-item" :class="[{'d-none' : paginate.currentPage == 1}]" ><a class="page-link"@click="goTo(paginate.currentPage - 1)"><i data-feather="chevron-left"></i></a></li>
									    	<template v-for="i in paginate.pages" :index="i">
									    		<li class="page-item " :class="[{ 'active' : i === paginate.currentPage }]"><a class="page-link" @click="goTo(i)">@{{ i }}</a></li>
									    	</template>

									    	<li class="page-item" v-if="paginate.currentPage !=  paginate.lastPage"><a class="page-link" @click="goTo(paginate.currentPage + 1)"><i data-feather="chevron-right"></i></a></li>
									  	</ul>
									</nav>

									<template v-for="product in selectedProducts">
										<input type="hidden" name="products[]" :value="product">
									</template>
                            	</div>
                            </div>
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
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <script type="text/javascript">
    	$(function(){
    		var param = '?publish=0';
    		var treeUrl = '{{ url("flash-sale/tree/".$flashsale->id) }}';
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

	         $('#chkPublishOnly').on('click',function () {
	         	let cxbx = $(this).is(':checked')
	         	if (cxbx) {
	         		param = '?publish=1';
	         	}else{
	         		param = '';
	         	}

	         	$('#product-tree').jstree(true).settings.core.data.url = treeUrl+param;
	         	// console.log(treeUrl.param);
	         	$('#product-tree').jstree(true).refresh();
	         })

	        $('#product-tree').jstree({
		        "core" : {
		            'data' : {
		                'url' : treeUrl,
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

		    // $("#form").on('submit',function(e){
	        //     e.preventDefault();
	        //     var selectedCategories = [];

	        //     //handle categories

	        //     var categories = $("#product-tree").jstree("get_selected",true);
	        //     $.each(categories,function(index,val){
	        //         selectedCategories.push(val.id);
	        //         // if(val.parent != '#') // index == 0 &&
	        //         // {
	        //         //     selectedCategories.push(val.parent);
	        //         // }
	        //         //
	        //         // if(selectedCategories.indexOf(val.id) == -1)
	        //         // {
	        //         //     selectedCategories.push(val.id);
	        //         // }

	        //     });

	        //     $.each(selectedCategories,function(index,val){
	        //         $('#prod-holder').append('<input type="hidden" name="products[]" value="'+val+'" />');
	        //     });

	        //     $('#form').off('submit');
	        //     $(this).submit();
	        // });

	        $('#type').on('change', function() {
	        	console.log('here');
	        	let value = $(this).val();

	        	if (value == 'FREE_ONGKIR') {
	        		$('#discount_value').hide();
	        	}else{
	        		$('#discount_value').show();
	        	}
	        })
		});
    </script>

	<script>
	  	const { createApp } = Vue

	  	createApp({
	    	data() {
	     		return {
	     			selectedProducts: [],
	     			products: [],
	     			paginate:{
	     				currentPage: 1,
	     				pages: [],
	     				lastPage: 0,
	     				total: 0
	     			},
	     			limit: 15,
	        		search: '',
	        		publish: false,
	        		select_all: false,
	      		}
	    	},
	    	mounted(){
	    		this.getListProduct()
	    	},
			watch: {
				search: function(newData, oldData) {
					if (newData.length > 2) {
	    				this.paginate.currentPage = 1;
						this.getListProduct();
					}else if(newData.length == 0){
						this.paginate.currentPage = 1;
						this.getListProduct();
					}
				},
				publish: function(newData, oldData) {
					this.paginate.currentPage = 1;
					this.getListProduct();
				},
				select_all: function(newData, oldData) {
					if (newData) {
						for (var i = 0; i < this.products.length; i++) {
	 						var product = this.products[i];

							if (!this.selectedProducts.includes(product.id)) {
								this.selectedProducts.push(product.id);
							}
	 					}
					}else{
						this.selectedProducts = [];
					}
				},
				limit: function(newData, oldData) {
					this.paginate.currentPage = 1;
					this.getListProduct();	
				}
			},
	    	methods: {
	    		async getListProduct() {
	    			var url = encodeURI(`/flash-sale/product/{{$flashsale->id}}?page=`+this.paginate.currentPage);

	    			if (this.search.length > 2) {
	    				url += '&search='+this.search;
	    			}
	    			if (this.publish) {
	    				url += '&publish=1';
	    			}
	    			url += '&limit='+this.limit;
	    			

					await axios({
						method: 'get',
						url: url,
					})
					.then((r)=>{
						if (r.data.success) {
							this.products = r.data.products.items;
							this.paginate.currentPage = r.data.products.currentPage;
	     					this.paginate.lastPage = r.data.products.lastPage;
	     					this.paginate.total = r.data.products.total;

	     					var pages = [];

	     					for (var i = 0; i < r.data.products.items.length; i++) {
	     						var product = r.data.products.items[i];

	     						if (product.state.selected) {
									if (!this.selectedProducts.includes(product.id)) {
										this.selectedProducts.push(product.id);
										console.log('run')
									}
	     						}
	     					}

	     					for (var i = this.paginate.currentPage - 2; i <= this.paginate.currentPage+2; i++) {
	     						if (i > 0 && i <= this.paginate.lastPage) {
	     							pages.push(i)
	     						}
	     					}
	     					this.paginate.pages = pages;
						}
					})
					.catch()
				},
				showPublish(){
					console.log('here');
				},
				selectAll(){
					
				},
				checkInArray(item, dataArr){
					return dataArr.includes(item.id);
				},
				selectItem(i){
					if (this.selectedProducts.includes(i)) {
						const index = this.selectedProducts.indexOf(i);
						if (index > -1) {
						 	this.selectedProducts.splice(index, 1); 
						}
					}else{
						this.selectedProducts.push(i)
					}

				},
				goTo(i){
					this.paginate.currentPage = i;
					this.getListProduct()
				}
	    	}

	  	}).mount('#app')
	</script>
@endsection
