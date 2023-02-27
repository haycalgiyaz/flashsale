<?php

namespace Haycalgiyaz\Flashsale\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductCollection;
use Haycalgiyaz\Flashsale\Models\FlashSale;
use Illuminate\Http\Request;
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
                        <a href="'.url('flash-sale/form').'/'.$row->id.'" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" title="Edit" ><i class="mdi mdi-lead-pencil" style="font-size:11px"></i></a>
                        <button class="btn btn-xs btn-danger" type="button" title="Remove" onclick="mineral_confirm(\''.$row->name.'\',\''.$row->id.'\')" > <i class="mdi mdi-delete-forever" style="font-size:11px"></i></button>
                    </div>';
        })
        ->editColumn('discount',function($row){
            if ($row->discount_price) {
                return 'Flat IDR '.$row->discount_price;
            }else{
                return $row->discount_percent.'%';
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
            $flash->discount_percent = ($request->discount_percent ? $request->discount_percent : 0);
            $flash->discount_price = ($request->discount_price ? $request->discount_price : 0);
            $flash->is_publish = ($request->input('is_publish') ? 1 : 0);
            $flash->published_at = date('Y-m-d H:i:s', strtotime($request->input('pdate')));
            $flash->ended_at = date('Y-m-d H:i:s', strtotime($request->input('edate')));
            
            $flash->save();

            $flash->products()->sync($request->products);

        } catch (\Exception $e) {
            dd(($e->getMessage()));
        }


        return redirect('flash-sale');
    }

    public function productsTree($id = null)
    {
        $data = Product::withCount(['flashsale' => function($q) use ($id){
            $q->where('flash_sale_id', $id);
        }])
        ->get();

        $json = ProductCollection::collection($data);

        return response()->json($json);
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

    public function destroy($id)
    {
        $flash = FlashSale::findOrFail($id);
        $task->delete();
        return redirect()->route('task.create');
    }

    public function testing()
    {

    }
}