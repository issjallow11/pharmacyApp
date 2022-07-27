<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    
    if ($request->sort =='-d') {
      $sales = Sale::orderBy('id', 'DSEC')->paginate(10);
    } else {
      $sales = Sale::paginate(10);
    }
    if($request->amount)
    {
      $order = $request->sort =='-id' ? 'DESC' : 'ASC';

      $sales = Sale::where('amount','LIKE', '%' . $request->amount. '%')
                    ->orderBy('id', $order)
                    ->paginate(10);
    }
    $response = [
            'paginate' => [
              'total' => $sales->total(),
              'per_page' => $sales->perPage(),
              'current_page' => $sales->currentPage(),
              'last_page' => $sales->lastPage(),
              'from' => $sales->firstItem(),
              'to' => $sales->lastItem()
            ], 'data' => $sales
    ];
    return response()->json([
        'status'=> 200,
        'result' => $response
    ]);

    // return $this->sendResponse($sales,'success');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'amount' => 'required',
    ]);

    try {
      //code...
      $sale = new Sale();
      $sale->product_id = $request->product_id;
      $sale->amount = $request->amount;
      $sale->save();

      return response()->json([
          'status' => 200,
          'result' => $sale,
      ]);
    } catch (\Exception $e) {
      //throw $e;
      return response()->json([
        'status' => 'Error occured',
    ]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $sales = Sale::where('product_id',$id)->get();

    return $this->sendResponse($sales, 'Product received successfully');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Sale $sale)
  {
    $sale->update($request->all());

    return $this->sendResponse($sale,'Sale Updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Sale  $sale
   * @return \Illuminate\Http\Response
   */
  public function destroy(Sale $sale)
  {
    $sale->delete();

    return $this->sendResponse('success', 'sale deleted successfully');
  }

  public function product(Request $request)
  {
     $product = Product::all();

     return response()->json([
        'status' => 200,
        'result' => $product
     ]);
  }
}
