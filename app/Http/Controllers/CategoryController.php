<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = Category::query();

        if (!empty($kode)) {
            $data_search->where('kode', $kode);
        }

        if (!empty($nama)) {
            $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        $data_search = $data_search
            ->select('kode', 'nama')
            ->orderBy('id')
            ->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    
    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = Category::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('category.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = Category::where('kode', $kode)->first();
        $data['item'] = MasterItem::where('kode', $kode)->first();
        return view('category.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $req = $request;
        if ($method == 'new') {
            $data_item = new Category;
            $kode = Category::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = Category::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->kode = $kode;

        $data_item->save();

        return redirect('category');
    }

public function item(Request $request)
{
    $jenis = $request->jenis;

    $data = MasterItem::where('jenis', $jenis)->get();

    return response()->json([
        'status' => 200,
        'data' => $data
    ]);
}

public function printout($kode)
{
    $category = Category::where('kode', $kode)->firstOrFail();

    $items = MasterItem::where('jenis', $category->nama)
        ->orderBy('id')
        ->get();

    $pdf = Pdf::loadView('category.single.printout', [
        'category' => $category,
        'items' => $items,
    ]);

    return $pdf->stream(
        'category-' . $category->kode . '.pdf'
    );
}
}
