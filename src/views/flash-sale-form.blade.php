@extends(View::exists('layouts.app') ? 'layouts.app' : 'mineralcms.flashsale.app')

@section('title', 'Flash Sale')

@php
 $selectedProduct = [];
 foreach ($flashsale->products as $key => $value) {
 	array_push($selectedProduct, [
 		'id' => $value->id,
 		'name' => $value->name,
 		'is_publish' => $value->is_publish,
 		'selected' => 1
 	]);
 }

 $flash_sale = [
 	'id' => $flashsale->id,
 	'name' => $flashsale->name,
 	'discount_price' => $flashsale->discount_price,
 	'discount_percent' => $flashsale->discount_percent,
 	'user_level' => $flashsale->user_level,
 	'is_publish' => $flashsale->is_publish,
 	'published_at' => $flashsale->published_at,
 	'ended_at' => $flashsale->ended_at,
 	'minimum_qty' => $flashsale->minimum_qty,
 	'is_discount_ammount' => $flashsale->is_discount_ammount,
 	'is_discount_ongkir' => $flashsale->is_discount_ongkir,
 	'discount_ongkir_price' => $flashsale->discount_ongkir_price,
 	'discount_ongkir_percent' => $flashsale->discount_ongkir_percent,
 	'is_free_ongkir' => $flashsale->is_free_ongkir,
 	'maximum_discount' => $flashsale->maximum_discount,
 	'maximum_ongkir_discount' => $flashsale->maximum_ongkir_discount,
 ];

@endphp
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
			<div class="card">
				<div class="card-body" >
					{{-- <h4 class="mb-4">General Information</h4> --}}
	                <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="name">Name</label>
	                            <input class="form-control" id="name" type="text" name="name" v-model="flash_sale.name" placeholder="Enter Name" required />
	                        </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="excerpt">Excerpt</label>
	                            <textarea class="form-control" name="excerpt" placeholder="Ringkasan Deskripsi" v-model="flash_sale.excerpt"></textarea>
	                        </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label for="name">Minimum Qty</label>
	                              <input type="number" name="minimum_qty" class="form-control" id="minimum_qty" placeholder="1" v-model="flash_sale.minimum_qty">
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

                    <div class="p-2" style="border: 1px solid #a9b5c9;">
	                    <div class="row">
	                    	<div class="col-md-12 mt-0">
	                    		<div class="form-group mb-0" style="height: 20px;">
	                    			<input type="checkbox" name="is_discount_ammount" v-model="flash_sale.is_discount_ammount" class="mr-1 my-auto" id="disc_price">
	                    			<label for="disc_price" style="font-weight: bold;">Discount Price</label>	
	                    		</div>
	                    	</div>
	                    </div>
	                    
	                    <div class="row mt-2 px-4 py-2" v-if="flash_sale.is_discount_ammount">
		                    <div class="col-6">
		                    	<div class="form-group">
		                            <label for="discount_price">Discount (IDR)</label>
		                            <input type="number" name="discount_price" class="form-control" id="discount_price" placeholder="10000" v-model="flash_sale.discount_price">
		                        </div>
		                    </div>
		                    <div class="col-6">
		                    	<div class="form-group">
		                            <label for="discount_percent">Discount (%)</label>
		                            <input type="number" name="discount_percent" class="form-control" id="discount_percent" placeholder="10" v-model="flash_sale.discount_percent">
		                        </div>
		                    </div>
		                    <div class="col-6">
		                    	<div class="form-group">
		                            <label for="maximum_discount">Maximum Discount</label>
		                            <input type="number" name="maximum_discount" class="form-control" id="maximum_discount" placeholder="10" v-model="flash_sale.maximum_discount">
		                        </div>
		                    </div>
		                </div>
                    </div>

                    <div class="p-2 mt-3 mb-2" style="border: 1px solid #a9b5c9;">
		                <div class="row">
	                    	<div class="col-md-12 mt-0">
	                    		<div class="form-group m-0" style="height: 20px">
	                    			<input type="checkbox" name="is_discount_ongkir" v-model="flash_sale.is_discount_ongkir" class="mr-1" id="showShipping">
	                    			<label for="showShipping" style="font-weight: bold">Discount Shipping</label>	
	                    		</div>
	                    	</div>
	                    </div>

	                    <div class="row mt-2 px-4 py-2" v-if="flash_sale.is_discount_ongkir">
		                    <div class="col-6">
		                    	<div class="form-group">
		                            <label for="discount_ongkir_price">Discount Ongkir (IDR)</label>
		                            <input type="number" name="discount_ongkir_price" class="form-control" id="discount_ongkir_price" placeholder="10000" v-model="flash_sale.discount_ongkir_price">
		                        </div>
		                    </div>
		                    <div class="col-6">
		                    	<div class="form-group">
		                            <label for="discount_ongkir_percent">Discount Ongkir (%)</label>
		                            <input type="number" name="discount_ongkir_percent" class="form-control" id="discount_ongkir_percent" placeholder="10" v-model="flash_sale.discount_ongkir_percent">
		                        </div>
		                    </div>
		                    <div class="col-6">
		                    	<div class="form-group">
		                            <label for="maximum_ongkir_discount">Maximum Discount</label>
		                            <input type="number" name="maximum_ongkir_discount" class="form-control" id="maximum_ongkir_discount" placeholder="10" v-model="flash_sale.maximum_ongkir_discount">
		                        </div>
		                    </div>
		                    <div class="col-6" style="margin: auto;">
		                    	<div class="form-group mb-0" style="height: 15px">
		                            <label for="discount_ongkir_percent mb-0">Free Ongkir</label>
		                            <input type="checkbox" name="is_free_ongkir" v-model="flash_sale.is_free_ongkir" class="ml-2">
		                        </div>
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
                        	<div class="px-2 pt-2" style="border: 1px solid #bfbfbf">
	                        	{{-- <div class="px-2 pb-2"> --}}
		                            <input type="text" class="form-control" placeholder="Search Product" v-model="search">
		                        {{-- </div> --}}

						        {{-- Product Area --}}
		                        <div class="mt-1" v-if="products.length > 0">
		                        	<ul class="list-group ">
									 	{{-- <li class="list-group-item active">Cras justo odio</li> --}}
									  	<template v-for="product in products">
									  		<li :class="'list-group-item d-flex justify-content-between' + classActive(product)" @click="select(product)">
									  			@{{product.name}}
									  		</li>
									  	</template>
									</ul>
		                        </div>
		                        <div class="mt-1" v-else>
		                        	<p class="text-center p-3" style="background-color: #d9d9d9;">Please search the product first</p>
		                        </div>

		                        <div class="d-flex justify-content-end">
			                        <div class="form-check">
						              	<label class="form-check-label mr-2 p-1">
						                	<input type="checkbox" class="form-check-input" name="publish_only" id="chkPublishOnly" v-model="publish"> Show publish only
						              	</label>
						            </div>
			                        <div class="form-check">
			                        	<button class="btn btn-sm btn-primary" type="button" @click="selectAll" :disabled="products.length == 0">
			                        		Select all product
			                        	</button>
						            </div>

		                        </div>
                        	</div>


	                        <div class="d-flex justify-content-between mb-2 mt-4">
	                        	<b>Selected Products</b>
	                        	<b>(@{{ selectedProducts.length }}) Product(s) are selected</b>
	                        </div>

	                        <div class="" v-if="selectedProducts.length > 0">
	                        	<ul class="list-group">
								 	{{-- <li class="list-group-item active">Cras justo odio</li> --}}
								  	<template v-for="product in selectedProducts">
								  		<li class="list-group-item d-flex justify-content-between" @click="deleteSelectedProduct(product)">
								  			@{{product.name}}
								  			<input type="hidden" name="products[]" :value="product.id">
								  			<i class="fa fa-trash"></i>
								  		</li>
								  	</template>
								</ul>
	                        </div>
	                        <div v-else>
	                        	<p class="text-center p-3" style="background-color: #d9d9d9;">No product are selected</p>
	                        </div>
                            {{-- <div id="product-tree" style="overflow-y:scroll; overflow-x:scroll; max-height: 500px;"></div>
                            <div id="prod-holder"></div> --}}
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

    {{-- <script type="text/javascript">
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
    </script> --}}
	<script>
		var  stored_product = JSON.parse('@json($selectedProduct)');
		var  flashSale = JSON.parse('@json($flash_sale)');

    	$(function(){
			$('.date-time').each(function() {
	            $('#datetimepicker').datetimepicker({
	                format: 'DD-MM-YYYY HH:mm',
	                defaultDate: $('#datetimepicker').data('date'),
	            });

	            $('#datetimepicker1').datetimepicker({
	                format: 'DD-MM-YYYY HH:mm',
	                defaultDate: $('#datetimepicker1').data('date'),
	            });
	        });
    	});

	  	const { createApp } = Vue

	  	createApp({
	    	data() {
	     		return {
	     			selectedProducts: [],
	     			products: [],
	     			limit: 15,
	        		search: '',
	        		publish: false,
	        		select_all: false,
	        		show_discount_price: false,
	        		show_discount_ongkir: false,
	     			flash_sale : {
	     				id : null,
					 	name : null,
					 	discount_price : null,
					 	discount_percent : null,
					 	user_level : null,
					 	is_publish : null,
					 	published_at : null,
					 	ended_at : null,
					 	minimum_qty : null,
					 	is_discount_ammount : true,
					 	is_discount_ongkir : true,
					 	discount_ongkir_price : null,
					 	discount_ongkir_percent : null,
					 	is_free_ongkir : null,
					 	maximum_discount : null,
					 	maximum_ongkir_discount : null,
	     			},
	      		}
	    	},
	    	mounted(){
	    		// this.getListProduct()
	    		this.selectedProducts = stored_product;
	    		this.flash_sale.id = flashSale.id;
				this.flash_sale.name = flashSale.name;
				this.flash_sale.discount_price = flashSale.discount_price;
				this.flash_sale.discount_percent = flashSale.discount_percent;
				this.flash_sale.user_level = flashSale.user_level;
				this.flash_sale.is_publish = flashSale.is_publish;
				this.flash_sale.published_at = flashSale.published_at;
				this.flash_sale.ended_at = flashSale.ended_at;
				this.flash_sale.minimum_qty = flashSale.minimum_qty;

				// this.flash_sale.is_discount_ammount = flashSale.is_discount_ammount;
				// this.flash_sale.is_discount_ongkir = flashSale.is_discount_ongkir;
				if (flashSale.is_discount_ammount) {
					this.flash_sale.is_discount_ammount = true;
				}
				if (flashSale.is_discount_ongkir) {
					this.flash_sale.is_discount_ongkir = true;
				}
				if (flashSale.is_free_ongkir) {
					this.flash_sale.is_free_ongkir = true;
				}
				this.flash_sale.discount_ongkir_price = flashSale.discount_ongkir_price;
				this.flash_sale.discount_ongkir_percent = flashSale.discount_ongkir_percent;
				this.flash_sale.maximum_discount = flashSale.maximum_discount;
				this.flash_sale.maximum_ongkir_discount = flashSale.maximum_ongkir_discount;
	    	},
			watch: {
				search: function(newData, oldData) {
					if (newData.length > 2) {
						this.getListProduct();
					}else{
						this.products = []
					}
				},
				publish: function(newData, oldData) {
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
	    			var url = encodeURI(`/flash-sale/products/{{$flashsale->id}}?limit=10`);

	    			if (this.search.length > 2) {
	    				url += '&search='+this.search;
	    			}
	    			if (this.publish) {
	    				url += '&publish=1';
	    			}

					await axios({
						method: 'get',
						url: url,
					})
					.then((r)=>{
						if (r.data.success) {
							this.products = r.data.products;
						}
					})
					.catch()
				},
				showPublish(){
					console.log('here');
				},
				select(product){
					if (!this.checkSelected(product)) {
						this.selectedProducts.push({
							id:product.id,
							name:product.name
						});
					}else{
						this.selectedProducts.splice(this.selectedProducts.findIndex(e => e.id === product.id), 1)
					}
				},
				deleteSelectedProduct(product){
					if (this.checkSelected(product)) {
						this.selectedProducts.splice(this.selectedProducts.findIndex(e => e.id === product.id), 1)
					}
				},
				selectAll(){
					for (var i = this.products.length - 1; i >= 0; i--) {
						this.select(this.products[i]);
					}
				},
				classActive(product){
					if (this.checkSelected(product)) {
						return ' active'
					}else{
						return ''
					}

				},
				checkSelected(product){
					if (this.selectedProducts.find(e => e.id === product.id)) {
						return true;
					}else{
						return false;
					}
				}

	    	}

	  	}).mount('#app')
	</script>
@endsection
