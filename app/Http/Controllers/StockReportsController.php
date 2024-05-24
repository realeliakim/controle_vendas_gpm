<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockReport;
use Illuminate\Http\Request;
use App\Http\Resources\StockReportResource;

class StockReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products = Product::all();
        $length = count($products);
        $report = StockReportResource::collection(StockReport::all());
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $data[$products[$i]->id] = [
                'id' => $products[$i]->id,
                'name' => $products[$i]->name,
                'stock' => $products[$i]->stock,
                'register' => [],
            ];
        }

        foreach ($report as $key => $value) {
            array_push($data[$value->product_id]['register'], [
                'action' => $value->action,
                'reaction' => $value->reaction,
            ]);
        }

        return view('stocks.index', compact('data'));
    }

}
