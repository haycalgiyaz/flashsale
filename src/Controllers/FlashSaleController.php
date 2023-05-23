<?php

namespace Haycalgiyaz\Flashsale\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Haycalgiyaz\Flashsale\Resources\ProductCollection;
use Haycalgiyaz\Flashsale\Resources\ProductPaginationResource;
use Haycalgiyaz\Flashsale\Models\FlashSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use Storage;
use Image;

class FlashSaleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web','auth']);
    }

    public function index(Request $request)
    {
        return view('mineralcms.flashsale.flash-sale');
    }

    public function datatable()
    {
        return Datatables::eloquent(FlashSale::query())
        ->editColumn('is_publish',' {!! ($is_publish == 1 && strtotime($published_at) <= time() && strtotime($ended_at) >= time() ? "<span class=\'badge badge-success\'>Published</span>" : "<span class=\'badge badge-warning\'>Not Published</span>") !!} ')
        ->addColumn('action', function ($row) {
            return '<div class="btn-group">
                        <a href="'.url('flash-sale/form').'/'.$row->id.'" class="btn btn-xs btn-secondary" type="button" data-toggle="tooltip" title="Edit" ><i class="mdi mdi-lead-pencil" style="font-size:11px"></i></a>
                        <button class="btn btn-xs btn-danger" type="button" title="Remove" onclick="mineral_confirm(\''.$row->name.'\',\''.$row->id.'\')" > <i class="mdi mdi-delete-forever" style="font-size:11px"></i></button>
                    </div>';
        })
        ->editColumn('discount',function($row){
            $html = [];

            if ($row->is_discount_ammount) {
                if ($row->discount_percent) {
                    array_push($html, $row->discount_percent.'%');
                }else{
                    array_push($html, 'IDR '.number_format($row->discount_price));
                }
            }

            if ($row->is_discount_ongkir) {
                array_push($html, 'Free Ongkir');
            }

            return implode(' & ', $html);
        })
        ->editColumn('type',function($row){
            if ($row->type == 'FREE_ONGKIR') {
                return 'FREE ONGKIR';
            }else{
                return 'DISCOUNT';
            }
        })
        ->editColumn('excerpt',function($row){
            return substr($row->excerpt, 0, 60);
        })
        ->editColumn('created_at',function($row){
            return $row->created_at->format('Y-m-d H:i:s');
        })
        ->editColumn('updated_at',function($row){
            return $row->updated_at->format('Y-m-d H:i:s');
        })
        ->rawColumns(['action', 'is_publish'])
        ->toJson();
    }

    public function form(Request $request, $id = null)
    {
        if ($id) {
            $data = FlashSale::where('id', $id)->first();                
        }else{
            $data = new FlashSale;        
        }

        if (!$data) {
            return abort(404);
        }
        $package['flashsale'] = $data;

        return view('mineralcms.flashsale.flash-sale-form', $package);
    }

    public function doForm(Request $request, $id = null)
    {
        try {
            if ($id) {
                $flash = FlashSale::where('id', $id)->first();
            }else{
                $flash = new FlashSale;
            }

            $flash->name = $request->name;
            $flash->excerpt = $request->excerpt;
            $flash->type = $request->type;
            $flash->user_level = $request->user_level;
            $flash->minimum_qty = $request->minimum_qty;

            // discount ammount
            $flash->is_discount_ammount = ($request->is_discount_ammount == 'on' ? 1 : 0);
            $flash->discount_percent = ($request->discount_percent ? $request->discount_percent : 0);
            $flash->discount_price = ($request->discount_price ? $request->discount_price : 0);
            // $flash->maximum_discount = ($request->maximum_discount ? $request->maximum_discount : 0);
            // discount ongkir
            $flash->is_discount_ongkir = ($request->is_discount_ongkir == 'on' ? 1 : 0);
            // $flash->discount_ongkir_price = $request->discount_ongkir_price;
            // $flash->discount_ongkir_percent = $request->discount_ongkir_percent;
            $flash->is_free_ongkir = ($request->is_free_ongkir == 'on' ? 1 : 0);
            // $flash->maximum_ongkir_discount = ($request->maximum_ongkir_discount ? $request->maximum_ongkir_discount : 0);

            $flash->is_publish = ($request->input('is_publish') ? 1 : 0);
            $flash->published_at = date('Y-m-d H:i:s', strtotime($request->input('pdate')));
            $flash->ended_at = date('Y-m-d H:i:s', strtotime($request->input('edate')));
            
            $flash->save();

            if ($request->choose_all) {
                if ($request->choose_all == 'deselect') {
                    $flash->products()->sync([]);
                }else{
                    $product = Product::query();
                    if ($request->choose_all == 'publish') {
                        $product = $product->publish();
                    }
                    $flash->products()->sync($product->pluck('id'));
                }

            }else{
                $flash->products()->sync($request->products);
            }

        } catch (\Exception $e) {
            dd(($e->getMessage()));
        }


        return redirect()->back()->with('notif', 'Success Update Flash Sale');
    }

    public function productsTree(Request $request, $id = null)
    {
        $data = Product::withCount(['flashsale' => function($q) use ($id){
            $q->where('flash_sale_id', $id);
        }]);

        if ($request->has('publish') && $request->publish ==1 ) {
            $data = $data->publish();
        }

        // $data = $data->sortBy(function ($product, $key) {
        //     return $product->flashsale_count;
        // });

        if ($request->has('search')) {
            $data = $data->where('name', 'like', '%'.$request->search.'%');
        }

        $data = $data->orderBy('is_publish', 'desc')->get();

        $json = ProductCollection::collection($data);
        return response()->json($json);

        // return response([
        //     'success' => true,
        //     'products' => $json
        // ]);

        // $json = ProductCollection::collection($data);
    }

    public function getProductList(Request $request, $id = null)
    {
        $limit = $request->has('limit') ? $request->limit : 10;

        $products = Product::withCount(['flashsale' => function($q) use ($id){
            $q->where('flash_sale_id', $id);
        }]);

        if ($request->has('publish') && $request->publish ==1 ) {
            $products = $products->publish();
        }

        if ($request->has('search')) {
            $search = $request->search;

            if ($request->has('category') && $request->category) {
                $products = $products->whereHas('categories',function ($cat) use ($search){
                    $cat->where('name', 'like', '%'.$search.'%');
                });
            }else{
                $products = $products->where('name', 'like', '%'.$search.'%');
            }
        }

        // $products = $products->orderBy('flashsale_count', 'desc')->paginate($limit);
        $products = $products->orderBy('flashsale_count', 'desc')->take($limit)->get();

        $json = ProductCollection::collection($products);

        return response([
            'success' => true,
            'products' => $json
        ]);
    }

    public function create()
    {
        $flashs = FlashSale::all();
        $submit = 'Add';
        return view('mineralcms.flashsale.flash-sale', compact('flashs', 'submit'));
    }

    public function store()
    {
        $input = Request::all();
        FlashSale::create($input);
        return redirect()->route('flashsale.create');
    }

    public function edit($id)
    {
        $flashs = FlashSale::all();
        $task = $flashs->find($id);
        $submit = 'Update';
        return view('mineralcms.flashsale.flash-sale', compact('flashs', 'task', 'submit'));
    }

    public function update($id)
    {
        $input = Request::all();
        $task = FlashSale::findOrFail($id);
        $task->update($input);
        return redirect()->route('flashsale.create');
    }

    public function destroy(Request $request)
    {
        $flash = FlashSale::findOrFail($request->id);
        $flash->delete();
        return redirect()->back();
    }
}