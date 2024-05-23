<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductsController extends Controller
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
    public function index(Request $request)
    {
        $products = ProductResource::collection(
                    Product::all()->sortDesc()
                )->paginate(6);
        return view('products.index', compact('products'));
    }

    /**
     * Show the user creation form.
     *
     */
    public function showCreateForm()
    {
        return view('products.product_form');
    }


    /**
     * Create a product
     *
     * @param App\Http\Requests\CreateUserRequest $request
     */
    public function create(CreateProductRequest $request)
    {
        try {
            $data = $request->validated();

            if ($data['stock'] === '0') {
                $data['available'] = false;
            }
            $data['price'] = str_replace(".","", $data['price']);
            $data['price'] = str_replace(",",".", $data['price']);
            $product = Product::create($data);

            return redirect()->to(route('products'))->with('success', 'Produto '. $product->name .' criado com sucesso');
        } catch (\Exception $e) {
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
