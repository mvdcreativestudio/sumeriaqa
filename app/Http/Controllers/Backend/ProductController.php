<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BarcodeScannerController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Models\StockLimit;
use App\Models\SubCategory;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    use ImageUploadTrait;

    // Definir el valor predeterminado para notificar la cantidad
    const DEFAULT_NOTIFY_QTY = 20;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        $products = Product::all(); // Obtener todos los productos
        return $dataTable->render('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max: 600'],
            'long_description' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required'],
            'notify_quantity' => ['nullable'], // Agregado: Validar el campo notify_quantity
        ]);

        /** Handle the image upload */
        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        $product = new Product();
        $product->thumb_image = $imagePath;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->is_approved = 1;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->notify_quantity = $request->notify_quantity; // Nuevo: Asignar notify_quantity al producto
        $product->save();

        toastr('Created Successfully!', 'success');

        // Stock Limit
        $stockLimit = new StockLimit();
        $stockLimit->product_id = $product->id;
        $stockLimit->notify_quantity = $request->notify_quantity ?? self::DEFAULT_NOTIFY_QTY; // Utiliza notify_quantity si está presente, de lo contrario utiliza el valor predeterminado
        $stockLimit->save();

        // Verificar el límite de stock después de guardar $stockLimit
        if ($product->qty <= $stockLimit->notify_quantity) {
            // Realiza las acciones necesarias para procesar el stock
            // Ejemplo: enviar un correo electrónico al administrador
            $message = 'Product stock reached the limit: ' . $stockLimit->notify_quantity;
            mail('admin@example.com', 'Stock Limit Reached', $message);
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $subCategories = SubCategory::all();
        $childCategories = ChildCategory::all(); // Agrega esta línea para obtener las categorías hijas
        $product->load('stockLimit'); // Cargar la relación stockLimit


        return view('admin.product.edit', compact('product', 'categories', 'brands', 'subCategories', 'childCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:600'],
            'long_description' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required'],
            'notify_quantity' => ['required'], // Agregado: Validar el campo notify_quantity
        ]);

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->notify_quantity = $request->notify_quantity; // Nuevo: Asignar notify_quantity al producto
        $product->save();

        // Actualizar el límite de stock
        $stockLimit = $product->stockLimit;

        if (!$stockLimit) {
            // Si no existe un límite de stock, crea uno nuevo
            $stockLimit = new StockLimit();
            $stockLimit->product_id = $product->id;
        }

        $stockLimit->notify_quantity = $request->notify_quantity;
        $stockLimit->save();

        toastr('Updated Successfully!', 'success');

        // Verificar el límite de stock después de guardar $stockLimit
        if ($product->qty <= $stockLimit->notify_quantity) {
            // Realiza las acciones necesarias para procesar el stock
            // Ejemplo: enviar un correo electrónico al administrador
            $message = 'Product stock reached the limit: ' . $stockLimit->notify_quantity;
            mail('admin@example.com', 'Stock Limit Reached', $message);
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        toastr('Deleted Successfully!', 'success');

        return response()->json(['status' => 'success']);
    }

    public function quickLoad(Request $request)
    {
        $productsData = $request->input('products');

        foreach ($productsData as $productData) {
            $product = new Product();
            $product->name = $productData['name'];
            // Agrega los demás campos del producto según corresponda

            // Guarda el producto en la base de datos
            $product->save();
        }

        // Mostrar un mensaje o redirigir a una página de éxito
        toastr('Productos creados satisfactoriamente', 'success');

        return redirect()->route('admin.quickLoadForm');
    }

}
