<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\StockLimit;
use Illuminate\Console\Command;

class ProcessProductStock extends Command
{
    protected $signature = 'product:process-stock';
    protected $description = 'Process stock for all products';

    public function handle()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $stockLimit = StockLimit::where('product_id', $product->id)->first();

            if ($stockLimit && $product->qty <= $stockLimit->limit) {
                // Realiza las acciones necesarias para procesar el stock
                // Puedes enviar notificaciones, enviar correos electrónicos, etc.
                // Ejemplo: enviar un correo electrónico al administrador
                $message = 'Product stock reached the limit: ' . $stockLimit->limit;
                mail('admin@example.com', 'Stock Limit Reached', $message);
            }
        }

        $this->info('Product stock processed successfully.');
    }
}
