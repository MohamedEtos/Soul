<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Orders;
use App\Models\Order_items;
use App\Models\Order_addresses;
use App\Models\Product;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ar_SA'); // Arabic faker

        // Ensure we have products
        if (Product::count() == 0) {
            $this->command->info('No products found. Skipping order seeding.');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            // Create Order
            $subtotal = 0;
            $itemsData = [];

            // Random 1 to 5 items
            $itemCount = rand(1, 5);
            $randomProducts = Product::inRandomOrder()->limit($itemCount)->get();

            foreach ($randomProducts as $product) {
                $qty = rand(1, 3);
                $price = $product->price;
                $itemTotal = $price * $qty;
                $subtotal += $itemTotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $itemTotal,
                ];
            }

            $shippingCost = rand(0, 1) ? 50 : 0; // 50% chance of free shipping
            $total = $subtotal + $shippingCost;

            $statusOptions = ['done', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'];
            $paymentUserStatus = ['accepted', 'notaccepted', 'paid', 'unpaid'];
            $paymentMethods = ['cod', 'visa', 'wallet'];

            $order = Orders::create([
                'user_ip' => $faker->ipv4,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => $statusOptions[array_rand($statusOptions)],
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => $paymentUserStatus[array_rand($paymentUserStatus)],
            ]);

            // Create Order Items
            foreach ($itemsData as $item) {
                Order_items::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);
            }

            // Create Order Address
            Order_addresses::create([
                'order_id' => $order->id,
                'full_name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'governorate' => $faker->city, // Using city as governorate proxy
                'area' => $faker->streetName,
                'address' => $faker->address,
                'floor_number' => rand(1, 15),
                'building' => rand(1, 50),
                'note' => $faker->sentence,
            ]);
        }
    }
}
