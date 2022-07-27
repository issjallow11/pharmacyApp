<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  protected $product = '';

   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->middleware('auth:api');
        $this->product = $product;
    }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    // $limit = $request->limit;
    // if ($request->sort == '-d') {
    //   $products = Product::orderBy('id', 'DSEC')->paginate($limit);
    // } else {
    //   $products = Product::paginate($limit);
    //   $product = Product::all();
    // }
    // if ($request->name || $request->strength || $request->purchase_price || $request->sales_price) {
    //   $order = $request->sort == '-id' ? 'DESC' : 'ASC';

    //   $products = Product::where('name', 'LIKE', '%' . $request->name . '%'
    //     or 'strength', 'LIKE', '%' . $request->strength . '%'
    //     or 'purchase_price', 'LIKE', '%' . $request->purchase_price . '%'
    //     or 'sales_price', 'LIKE', '%' . $request->sales_price . '%')
    //     ->orderBy('id', $order)
    //     ->paginate($limit);
    // }
    // $response = [
    //   'paginate' => [
    //     'total' => $products->total(),
    //     'per_page' => $products->perPage(),
    //     'current_page' => $products->currentPage(),
    //     'last_page' => $products->lastPage(),
    //     'from' => $products->firstItem(),
    //     'to' => $products->lastItem()
    //   ], 'data' => $products,
    //   'product' => $product
    // ];
    // return response()->json([
    //   'status' => 200,
    //   'result' => $response
    // ]);
    // return $this->sendResponse('success', $products);
    $products = $this->product->latest()->with('category', 'tags')->paginate(10);

    return $this->sendResponse($products, 'Product list');
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
      'name' => 'required',
      // 'unit' => 'required',
      'purchase_price' => 'required',
      'sales_price' => 'required',
      'category_id' => 'required',
      'type_id' => 'required',
    ]);

    try {

      $product = new Product();
      $product->name = $request->name;
      if ($request->image) {
        $imageName =  $request->image;
      }
      $product->purchase_price = $request->purchase_price;
      $product->sales_price = $request->sales_price;
      $product->unit = 'none';
      // $product->image = $imageName;
      $product->strength = $request->strength;
      $product->description = $request->description;
      $product->category_id = $request->category_id;
      $product->type_id = $request->type_id;
      $product->save();

      // return $this->sendResponse('success', $product);
      return response()->json([
        'status' => 200,
        'result' => $product
      ]);
    } catch (\Exception $e) {
      return $this->sendError('error', $e->getMessage());
    }
    //       $product->purchase_price = $request->purchase_price;
    //       $product->sales_price = $request->sales_price;
    //       $product->unit = $request->unit;
    //       $product->image = $imageName;
    //       $product->strength = $request->strenght;
    //       $product->description = $request->product;
    //       $product->category_id = $request->category;
    //       $product->save();

    //       return $this->sendResponse('success', $product);
    //     } catch (\Exception $e) {
    //       //throw $e;
    //       return $this->sendError('error', $e->getMessage());
    //     }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function show(Product $product)
  {
    return $this->sendResponse('success', $product);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Product $product)
  {
    $data = $request->validate([
      'name' => 'required',
      'purchase_price' => 'required',
      'sales_price' => 'required',
      'unit' => 'require',
    ]);

    try {
      //code...

      if ($request->image) {
        $imageName =  $request->image->store('img/products', 'public');
        $product->image = $imageName;
      }
      $product->name = $data['name'];
      $product->purchase_price = $data['purchase_price'];
      $product->sales_price = $data['sales_price'];
      $product->unit = $data['unit'];
      $product->save();

      return $this->sendResponse($product, 'success');
    } catch (\Exception $e) {
      //throw $e;
      return $this->sendError('error', 'error updating the product');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product)
  {
    try {
      //code...
      $product->delete();

      return $this->sendResponse('success', 'successfully deleted');
    } catch (\Exception $e) {
      //throw $e;
      return $this->sendError('error', 'error deleting product');
    }
  }
}
