<?php

$json = file_get_contents('inventory_data.json');
$data = json_decode($json, true);

// Remove header
array_shift($data);

$script = "<?php\n\n";
$script .= "namespace App\Console\Commands;\n\n";
$script .= "use Illuminate\Console\Command;\n";
$script .= "use Modules\Category\Models\Category;\n";
$script .= "use Modules\Product\Models\Product;\n";
$script .= "use Modules\Product\Models\ProductCategory;\n";
$script .= "use Illuminate\Support\Str;\n\n";
$script .= "class PopulateInventory extends Command\n{\n";
$script .= "    protected \$signature = 'app:populate-inventory';\n";
$script .= "    protected \$description = 'Populate inventory from embedded data';\n\n";
$script .= "    public function handle()\n    {\n";
$script .= "        \$data = [\n";

foreach ($data as $row) {
    if (count($row) < 5) continue;
    
    $category = addslashes((string)$row[0]);
    $subcategory = addslashes((string)$row[1]);
    $product = addslashes((string)$row[2]);
    $qty = addslashes((string)$row[3]);
    $price = addslashes((string)$row[4]);
    
    // Convert out of stock to 0
    if (strtoupper($qty) === 'OUT OF STOCK') {
        $qty = 0;
    } else {
        $qty = (int)$qty;
    }
    
    // Clean price
    if ($price === '—' || $price === '-' || empty($price)) {
        $price = 0;
    } else {
        // Remove currency symbols and commas
        $price = preg_replace('/[^0-9.]/', '', $price);
        $price = (float)$price;
    }
    
    $script .= "            ['$category', '$subcategory', '$product', $qty, $price],\n";
}

$script .= "        ];\n\n";

$script .= <<<'PHP'
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE products AUTO_INCREMENT = 1192;');
        $this->info("Starting inventory population...");
        
        foreach ($data as $row) {
            $catName = $row[0];
            $subCatName = $row[1];
            $prodName = $row[2];
            $qty = $row[3];
            $price = $row[4];
            
            // Get or create parent category
            $parentCat = Category::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName), 'status' => 1]
            );
            
            // Get or create subcategory
            $subCat = null;
            if (!empty($subCatName)) {
                $subCat = Category::firstOrCreate(
                    ['name' => $subCatName, 'parent_id' => $parentCat->id],
                    ['slug' => Str::slug($subCatName), 'status' => 1]
                );
            }
            
            // Create Product
            $product = Product::firstOrCreate(
                ['name' => $prodName],
                [
                    'slug' => Str::slug($prodName) . '-' . time(),
                    'min_price' => $price,
                    'max_price' => $price,
                    'stock_qty' => $qty,
                    'status' => 1,
                    'created_by' => 1
                ]
            );
            
            // Attach categories
            $catIds = [$parentCat->id];
            if ($subCat) {
                $catIds[] = $subCat->id;
            }
            $product->categories()->syncWithoutDetaching($catIds);
        }
        
        $this->info("Inventory populated successfully!");
    }
}
PHP;

file_put_contents('app/Console/Commands/PopulateInventory.php', $script);
echo "Command generated!";
