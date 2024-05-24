<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\StockReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Requests\CreateOrderRequest;
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
     * Show the orders list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($user_id = null)
    {
        $user = User::find(Auth::user()->id);
        $salers = DB::select("CALL get_saler_list()");
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

        return view('orders.index', compact('orders', 'salers'));
    }


    /**
     * Orders filter.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getOrders(Request $request)
    {
        $user = User::find($request['user_id']);
        $orders = OrderResource::collection(
            Order::where('saler_id', $user->id)->get()
        )->paginate(6);
        $salers = DB::select("CALL get_saler_list()");
        return view('orders.index', compact('orders', 'salers'));
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

                    StockReport::create([
                        'action' => 'Venda Executada | Pedido id #'.$order->id,
                        'reaction' => '-'.$data['qnty_saled'][$i],
                        'product_id' => $product_id,
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
    public function view(int $order_id)
    {
        try {
            $order = Order::find($order_id);

            if (!$order) {
                throw new ModelNotFoundException('Pedido não encontrado', 404);
            }
            $order_details = $order->products;
            $subtotal = [];
            foreach ($order_details as $key => $details) {
                $sub = $details->products->price_saled * $details->products->qnty_saled;
                array_push($subtotal, $sub);
            }
            $total = array_sum($subtotal);
            return view('orders.view', compact('order_details', 'total'));
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
    public function delete(int $order_id)
    {
        try {
            $order = Order::find($order_id);

            if (!$order) {
                throw new ModelNotFoundException('Pedido com id #'.$order_id. ' não encontrado', 404);
            }

            $products = $order->products;
            DB::beginTransaction();
                $order->products()->detach();
                foreach ($products as $product) {
                    $product_id = $product->id;
                    $in_stock = $product->products->qnty_saled;
                    $prod_table = Product::find($product_id);
                    $stock_in_base = $prod_table->stock;
                    $prod_table->update([
                        'stock' => $stock_in_base + $in_stock,
                        'available' => true,
                    ]);
                    StockReport::create([
                        'action' => 'Venda Cancelada | Pedido id #'.$order_id,
                        'reaction' => '+'.$in_stock,
                        'product_id' => $product_id,
                    ]);
                }
                $order->delete();
            DB::commit();
            return redirect()->to(route('orders'))->with('success', 'Pedido '. $order_id .' deletado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return response()->apiException($e->getMessage(), $status_code);
        }
    }
}
