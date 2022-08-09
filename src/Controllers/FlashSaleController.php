<?php

namespace Mineralcms\Flashsale\Controllers;

use App\Http\Controllers\Controller;
use Request;
use Mineralcms\Flashsale\Models\FlashSale;

class FlashSaleController extends Controller
{
    public function index()
    {
        return redirect()->route('flashsale.create');
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