<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class OrdersController extends Controller
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
     * Show the products list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $orders = '';
        switch($user->user_type_id) {
            case 1:
                $orders = OrderResource::collection(
                    Order::all()->sortDesc()
                )->paginate(6);
                break;
            case 2:
                $orders = OrderResource::collection(
                    Order::where('saler_id', $user->id)->get()
                )->paginate(6);
                break;
            default:
                $orders = OrderResource::collection(
                    Order::where('customer_id', $user->id)->get()
                )->paginate(6);
                break;
        }

        return view('orders.index', compact('orders'));

        //return view('orders.index');
        //$data = Order::all();
        //$orders = OrderResource::collection($data);
        //return response()->json($orders);
        //$p = $orders->products;
        //return $collection;
        //$orders = json_decode($collection);
        /*OrderResource::collection(
                    Order::searchOrFilter(
                        $request->only([
                            'search'
                        ]))->orderBy('id', 'desc')->get()
                )->paginate(6);*/


    }


    /**
     * Show the products list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getOrders(int $user_id)
    {
        $user = User::find($user_id);
        if ($user->user_type_id === 1) {
            return OrderResource::collection(
                Order::all()->sortDesc()
            )->paginate();
        }

        if ($user->user_type_id === 2) {
            return OrderResource::collection(
                Order::where('saler_id', $user->id)->get()
            )->paginate(6);
        }

        if ($user->user_type_id === 3) {
            return OrderResource::collection(
                Order::where('customer_id', $user->id)->get()
            )->paginate(6);
        }


        /*$data = Order::all();
        $orders = OrderResource::collection($data);
        return response()->json($orders);
        //$p = $orders->products;
        //return $collection;
        //$orders = json_decode($collection);
        /*OrderResource::collection(
                    Order::searchOrFilter(
                        $request->only([
                            'search'
                        ]))->orderBy('id', 'desc')->get()
                )->paginate(6);
        return view('orders.index', ['orders' => $orders]);
        */
    }




    /**
    * Show products in store.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function showStore()
    {
        $section_id = Auth::user()->section_id;
        $products = DB::select("CALL get_product_by_section($section_id)");
        $customers = DB::select("CALL get_customer_list()");

        return view('orders.show_store', compact(array('products','customers')));
    }


    /**
     * Create a product
     *
     * @param App\Http\Requests\CreateOrderRequest $request
     */
    public function create(CreateOrderRequest $request)
    {
        try {
            DB::beginTransaction();
                $saler = Auth::user();
                $data = $request->validated();
                $lenght = count($data['product_id']);

                $order = Order::create([
                    'saler_id' => $saler->id,
                    'customer_id' => $data['customer_id'],
                ]);

                for ($i = 0; $i < $lenght; $i++){
                    $product_id = $data['product_id'][$i];
                    $product = Product::firstWhere('id', $product_id);
                    if (!$product) {
                        throw new BadRequestException("Produto não existe", 400);
                    }
                    $order->products()->attach([$product->id =>
                        [
                            'price_saled' => $data['price_saled'][$i],
                            'qnty_saled'  => $data['qnty_saled'][$i],
                        ],
                    ]);
                    $stock_update = $product->stock - $data['qnty_saled'][$i];
                    $available = true;
                    if ($stock_update < 1) {
                        $available = false;
                    }
                    $product->update([
                        'stock' => $stock_update,
                        'available' => $available,
                    ]);
                }
            DB::commit();
            return redirect()->to(route('orders'))->with('success', 'Pedido realizado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
    * View a product.
    *
    * @param int $product_id
    */
    public function view(int $product_id)
    {
        try {
            $product = Product::find($product_id);

            if (!$product) {
                throw new ModelNotFoundException('Usuário não encontrado', 404);
            }

            $product = ProductResource::make($product);
            return view('products.view', compact('product'));
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
    * Update an user.
    * @param   int  $product_id
    * @param   App\Http\Requests\CreateProductRequest	$request
    */
    public function update(CreateProductRequest $request, int $product_id)
    {
        try {
            $product = Product::find($product_id);

            if (!$product) {
                throw new ModelNotFoundException('Produto não encontrado', 404);
            }
            $data = $request->validated();

            if ($data['stock'] === '0') {
                $data['available'] = false;
            }
            $data['price'] = str_replace(".","", $data['price']);
            $data['price'] = str_replace(",",".", $data['price']);
            $product->update($data);
            return redirect()->to(route('products'))->with('success', 'Produto '. $product->name .' atualizado com sucesso');
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }

    /**
    * Delete a product.
    *
    * @param  int $product_id
    */
    public function delete(int $product_id)
    {
        try {
            $product = Product::find($product_id);

            if (!$product) {
                throw new ModelNotFoundException('Produto com id #'.$product_id. ' não encontrado', 404);
            }

            $product->delete();
            return redirect()->to(route('products'))->with('success', 'Produto '. $product_id .' deletado com sucesso');
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }
}
