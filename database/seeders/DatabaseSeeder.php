<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User Admin (Dipertahankan)
        User::create([
            'name' => 'Admin Toko Aira',
            'email' => 'admin@aira.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // 2. Kategori 
        $catRokok = Category::create(['name' => 'Rokok']);
        $catMie = Category::create(['name' => 'Mie Instan']);
        $catMinuman = Category::create(['name' => 'Minuman']);
        $catSnack = Category::create(['name' => 'Snack']);
        $catBiskuit = Category::create(['name' => 'Biskuit']);
        $catIceCream = Category::create(['name' => 'Es Krim']);
        $catPembersih = Category::create(['name' => 'Pembersih']);
        $catMandi = Category::create(['name' => 'Mandi']);
        $catMandiSampo = Category::create(['name' => 'Mandi/Sampo']);

        // 3. Data Produk
        $products = [
            // ROKOK
            ['name' => 'Rokok LA Bold', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 40000, 'min' => 5, 'stock' => 15, 'sold' => 120],
            ['name' => 'Rokok LA Ice', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 37000, 'min' => 10, 'stock' => 30, 'sold' => 270],
            ['name' => 'Rokok Sampoerna', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 37000, 'min' => 5, 'stock' => 25, 'sold' => 270],
            ['name' => 'Rokok Sampoerna 12', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 27000, 'min' => 6, 'stock' => 20, 'sold' => 270],
            ['name' => 'Rokok Sampoerna Evolution', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 45000, 'min' => 10, 'stock' => 18, 'sold' => 100],
            ['name' => 'Rokok New Max', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 29000, 'min' => 5, 'stock' => 12, 'sold' => 247],
            ['name' => 'Rokok Urban Mild', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 26000, 'min' => 5, 'stock' => 15, 'sold' => 150],
            ['name' => 'Rokok Surya 16', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 38000, 'min' => 5, 'stock' => 20, 'sold' => 210],
            ['name' => 'Rokok Surya 12', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 28000, 'min' => 8, 'stock' => 35, 'sold' => 120],
            ['name' => 'Rokok Djie Sam Soe Kuning', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 29000, 'min' => 7, 'stock' => 15, 'sold' => 110],
            ['name' => 'Rokok Djie Sam Soe Prem. 16', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 26000, 'min' => 4, 'stock' => 10, 'sold' => 90],
            ['name' => 'Rokok Esse Double', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 45000, 'min' => 3, 'stock' => 12, 'sold' => 120],
            ['name' => 'Rokok Esse Ice', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 44000, 'min' => 3, 'stock' => 12, 'sold' => 150],
            ['name' => 'Rokok Potenza Bold Z', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 28000, 'min' => 6, 'stock' => 18, 'sold' => 180],
            ['name' => 'Rokok Class Mild 20', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 35000, 'min' => 5, 'stock' => 15, 'sold' => 150],
            ['name' => 'Rokok Class Mild 16', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 31000, 'min' => 10, 'stock' => 25, 'sold' => 180],
            ['name' => 'Rokok Rocker Bold 20', 'cat' => $catRokok->id, 'unit' => 'Bungkus', 'price' => 21000, 'min' => 4, 'stock' => 15, 'sold' => 360],

            // MIE INSTAN
            ['name' => 'Indomie Goreng', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 119000, 'min' => 8, 'stock' => 20, 'sold' => 60],
            ['name' => 'Indomie Soto', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 119000, 'min' => 6, 'stock' => 15, 'sold' => 40],
            ['name' => 'Indomie Coto Makassar', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 118000, 'min' => 4, 'stock' => 10, 'sold' => 34],
            ['name' => 'Indomie Kaldu', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 108000, 'min' => 10, 'stock' => 25, 'sold' => 50],
            ['name' => 'Indomie Kari Ayam', 'cat' => $catMie->id, 'unit' => 'Karton', 'price' => 118000, 'min' => 4, 'stock' => 12, 'sold' => 35],
            ['name' => 'Sedaap Goreng', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 118000, 'min' => 6, 'stock' => 15, 'sold' => 40],
            ['name' => 'Sedaap Soto', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 113000, 'min' => 8, 'stock' => 18, 'sold' => 42],
            ['name' => 'Pop Mie Goreng', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 54300, 'min' => 5, 'stock' => 10, 'sold' => 15],
            ['name' => 'Pop Mie Baso', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 103000, 'min' => 4, 'stock' => 12, 'sold' => 30],
            ['name' => 'Pop Mie Ayam', 'cat' => $catMie->id, 'unit' => 'Dos', 'price' => 103000, 'min' => 5, 'stock' => 15, 'sold' => 40],

            // MINUMAN
            ['name' => 'Le Minerale 600ml', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 60000, 'min' => 6, 'stock' => 25, 'sold' => 70],
            ['name' => 'Le Minerale 1.500ml', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 70000, 'min' => 10, 'stock' => 35, 'sold' => 70],
            ['name' => 'Aqua 600ml', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 60000, 'min' => 12, 'stock' => 40, 'sold' => 60],
            ['name' => 'Aqua 1.500ml', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 70000, 'min' => 10, 'stock' => 25, 'sold' => 75],
            ['name' => 'Teh Kotak 500ml', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 90000, 'min' => 8, 'stock' => 18, 'sold' => 40],
            ['name' => 'Teh Pucuk 350ml', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 68000, 'min' => 5, 'stock' => 20, 'sold' => 30],
            ['name' => 'Susu Ultra Milk 200ml', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 125000, 'min' => 4, 'stock' => 12, 'sold' => 40],
            ['name' => 'Pulpy', 'cat' => $catMinuman->id, 'unit' => 'Lusin', 'price' => 163000, 'min' => 4, 'stock' => 10, 'sold' => 30],
            ['name' => 'Floridina', 'cat' => $catMinuman->id, 'unit' => 'Lusin', 'price' => 35000, 'min' => 3, 'stock' => 10, 'sold' => 25],
            ['name' => 'Lasegar Kaleng', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 145000, 'min' => 2, 'stock' => 10, 'sold' => 30],
            ['name' => 'Sprite Kaleng', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 115000, 'min' => 2, 'stock' => 8, 'sold' => 15],
            ['name' => 'Fanta Kaleng', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 115000, 'min' => 2, 'stock' => 8, 'sold' => 12],
            ['name' => 'Coca Cola Kaleng', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 115000, 'min' => 2, 'stock' => 8, 'sold' => 12],
            ['name' => 'Buah Vita Kotak', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 170000, 'min' => 3, 'stock' => 7, 'sold' => 12],
            ['name' => 'Kopiko 78 Botol', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 75000, 'min' => 3, 'stock' => 8, 'sold' => 15],
            ['name' => 'Golda Botol', 'cat' => $catMinuman->id, 'unit' => 'Lusin', 'price' => 40000, 'min' => 3, 'stock' => 8, 'sold' => 10],
            ['name' => 'Nescafe Kaleng', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 150000, 'min' => 4, 'stock' => 10, 'sold' => 15],
            ['name' => 'You C1000', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 185000, 'min' => 1, 'stock' => 5, 'sold' => 15],
            ['name' => 'Susu Beruang', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 300000, 'min' => 3, 'stock' => 12, 'sold' => 25],
            ['name' => 'Adem Sari Kaleng', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 152000, 'min' => 2, 'stock' => 8, 'sold' => 20],
            ['name' => 'Orange Water', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 160000, 'min' => 3, 'stock' => 8, 'sold' => 30],
            ['name' => 'Cincau Kaleng', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 50000, 'min' => 2, 'stock' => 6, 'sold' => 10],
            ['name' => 'Ichitan', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 155000, 'min' => 4, 'stock' => 12, 'sold' => 30],
            ['name' => 'GoodDay Botol', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 242000, 'min' => 2, 'stock' => 6, 'sold' => 15],
            ['name' => 'Cappucino', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 125000, 'min' => 3, 'stock' => 8, 'sold' => 12],
            ['name' => 'Kopi Kapal Api Sachet', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 280000, 'min' => 2, 'stock' => 10, 'sold' => 11],
            ['name' => 'Mizone', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 57000, 'min' => 8, 'stock' => 15, 'sold' => 15],
            ['name' => 'Kopi Abc Botol', 'cat' => $catMinuman->id, 'unit' => 'Dos', 'price' => 205000, 'min' => 2, 'stock' => 8, 'sold' => 15],

            // SNACK
            ['name' => 'Snack Qetela BBQ 30g', 'cat' => $catSnack->id, 'unit' => 'Dos', 'price' => 105000, 'min' => 3, 'stock' => 10, 'sold' => 25],
            ['name' => 'Snack Qetela Balado 60g', 'cat' => $catSnack->id, 'unit' => 'Dos', 'price' => 152500, 'min' => 6, 'stock' => 15, 'sold' => 35],
            ['name' => 'Snack Qetela Balado 180g', 'cat' => $catSnack->id, 'unit' => 'Dos', 'price' => 153000, 'min' => 3, 'stock' => 8, 'sold' => 20],
            ['name' => 'Snack CupCup', 'cat' => $catSnack->id, 'unit' => 'Dos', 'price' => 75000, 'min' => 3, 'stock' => 10, 'sold' => 20],
            ['name' => 'Wafer Top', 'cat' => $catSnack->id, 'unit' => 'Dos', 'price' => 115000, 'min' => 2, 'stock' => 6, 'sold' => 6],
            ['name' => 'Kacang Rosta', 'cat' => $catSnack->id, 'unit' => 'Bungkus', 'price' => 145000, 'min' => 1, 'stock' => 4, 'sold' => 15],

            // BISKUIT
            ['name' => 'Biskuit Nabati RCO 37g', 'cat' => $catBiskuit->id, 'unit' => 'Dos', 'price' => 110274, 'min' => 3, 'stock' => 12, 'sold' => 12],
            ['name' => 'Biskuit Nabati RCO 100g', 'cat' => $catBiskuit->id, 'unit' => 'Dos', 'price' => 128237, 'min' => 2, 'stock' => 6, 'sold' => 5],
            ['name' => 'Biskuit Nabati 16g', 'cat' => $catBiskuit->id, 'unit' => 'Dos', 'price' => 99292, 'min' => 1, 'stock' => 5, 'sold' => 6],
            ['name' => 'Biskuit Pillow', 'cat' => $catBiskuit->id, 'unit' => 'Dos', 'price' => 175000, 'min' => 2, 'stock' => 8, 'sold' => 10],
            ['name' => 'Biskuit Goriorio', 'cat' => $catBiskuit->id, 'unit' => 'Pack', 'price' => 87000, 'min' => 1, 'stock' => 5, 'sold' => 15],
            ['name' => 'Biskuit Gery', 'cat' => $catBiskuit->id, 'unit' => 'Dos', 'price' => 285000, 'min' => 1, 'stock' => 4, 'sold' => 10],
            ['name' => 'Wafer Nitto', 'cat' => $catBiskuit->id, 'unit' => 'Dos', 'price' => 295000, 'min' => 1, 'stock' => 4, 'sold' => 8],

            // ES KRIM
            ['name' => 'Aice Coklat Stick', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 127000, 'min' => 2, 'stock' => 8, 'sold' => 45],
            ['name' => 'Aice Miki-Miki Vanila', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 119000, 'min' => 2, 'stock' => 6, 'sold' => 30],
            ['name' => 'Aice Miki-Miki Choco', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 119000, 'min' => 2, 'stock' => 6, 'sold' => 35],
            ['name' => 'Aice Sweet Corn', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 192000, 'min' => 2, 'stock' => 5, 'sold' => 25],
            ['name' => 'Aice 2 Color Coklat', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 114000, 'min' => 2, 'stock' => 6, 'sold' => 30],
            ['name' => 'Aice Chocolate Crispy', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 168000, 'min' => 2, 'stock' => 8, 'sold' => 40],
            ['name' => 'Aice Choco Sundae Cup', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 140000, 'min' => 2, 'stock' => 7, 'sold' => 20],
            ['name' => 'Aice Strawb. Sundae Cup', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 140000, 'min' => 2, 'stock' => 7, 'sold' => 18],
            ['name' => 'Aice Coklat Max Cone', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 155000, 'min' => 2, 'stock' => 5, 'sold' => 15],
            ['name' => 'Aice 3in1 Color', 'cat' => $catIceCream->id, 'unit' => 'Dos', 'price' => 235000, 'min' => 2, 'stock' => 4, 'sold' => 10],

            // PEMBERSIH & MANDI
            ['name' => 'Sabun cuci SoftKlin', 'cat' => $catPembersih->id, 'unit' => 'Dos', 'price' => 112000, 'min' => 5, 'stock' => 15, 'sold' => 30],
            ['name' => 'Rinso Anti Noda Sachet', 'cat' => $catPembersih->id, 'unit' => 'Dos', 'price' => 195000, 'min' => 3, 'stock' => 10, 'sold' => 25],
            ['name' => 'Daia Putih 280g', 'cat' => $catPembersih->id, 'unit' => 'Dos', 'price' => 165000, 'min' => 4, 'stock' => 12, 'sold' => 20],
            ['name' => 'Sunlight Jeruk Nipis', 'cat' => $catPembersih->id, 'unit' => 'Dos', 'price' => 145000, 'min' => 5, 'stock' => 15, 'sold' => 35],
            ['name' => 'Mama Lemon Lemon', 'cat' => $catPembersih->id, 'unit' => 'Dos', 'price' => 142000, 'min' => 4, 'stock' => 10, 'sold' => 28],
            ['name' => 'Sabun Lifebuoy Merah', 'cat' => $catMandi->id, 'unit' => 'Pack', 'price' => 48000, 'min' => 5, 'stock' => 20, 'sold' => 50],
            ['name' => 'Sabun Lux Putih', 'cat' => $catMandi->id, 'unit' => 'Pack', 'price' => 52000, 'min' => 5, 'stock' => 18, 'sold' => 45],
            ['name' => 'Sabun Giv Biru', 'cat' => $catMandi->id, 'unit' => 'Pack', 'price' => 42000, 'min' => 5, 'stock' => 15, 'sold' => 30],
            ['name' => 'Sunsilk Kuning Sachet', 'cat' => $catMandiSampo->id, 'unit' => 'Dos', 'price' => 185000, 'min' => 2, 'stock' => 8, 'sold' => 15],
            ['name' => 'Pantene Hitam Sachet', 'cat' => $catMandiSampo->id, 'unit' => 'Dos', 'price' => 190000, 'min' => 2, 'stock' => 6, 'sold' => 12],
            ['name' => 'Downy Mistique', 'cat' => $catPembersih->id, 'unit' => 'Dos', 'price' => 210000, 'min' => 3, 'stock' => 8, 'sold' => 10],
        ];

        // 4. Proses Insert Data
        foreach ($products as $p) {
            Product::create([
                'name' => $p['name'],
                'category_id' => $p['cat'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'min_stock' => $p['min'],
                'unit' => $p['unit'],
                'sales_frequency' => $p['sold'],
                'supplier_id' => null, 
            ]);
        }
    }
}