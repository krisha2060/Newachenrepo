<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class HomeController extends Controller
{
    //
   public function index()
{
    $catering = [
        'packages' => [
            [
                'number' => '01',
                'price' => 24,
                'items' => [
                    'Furandana or Bhuteko Chiura',
                    'Chicken Choila or Chicken Chilli',
                    'Piro Aalu or Aalu Aachar',
                    'Prawn Cracker or Papad',
                    'Pulau or Jeera Rice',
                    'Chicken Curry or Goat Curry',
                    'Aalutama or Raajma or Aalu Cauli',
                    'Tomato Achar or Lalmon',
                ]
            ],
            [
                'number' => '02',
                'price' => 28,
                'items' => [
                    'Furandana or Bhuteko Chiura',
                    'Chicken Choila or Chicken Chilli',
                    'Piro Aalu or Aalu Aachar',
                    'Soyabean (masyora) Sadheko or Peanut Sadheko',
                    'Papad or Prawn Cracker',
                    'Pulau or Jeera Rice',
                    'Chicken Curry or Goat Curry',
                    'Raajma or Aalutama',
                    'Aalu Cauli',
                    'Tomato Achar',
                    'Lalmon',
                ]
            ],
            [
                'number' => '03',
                'price' => 30,
                'items' => [
                    'Furandana or Bhuteko Chiura',
                    'Chicken Choila or Chicken Chilli',
                    'Veg Chowmein',
                    'Piro Aalu or Aalu Aachar',
                    'Soyabean (masyora) Sadheko or Peanut Sadheko',
                    'Papad or Prawn Cracker',
                    'Pulau or Jeera Rice',
                    'Chicken Curry or Goat Curry',
                    'Fried Fish or Chicken Roast',
                    'Raajma or Aalutama or Aalu Cauli',
                    'Tomato Achar',
                    'Lalmon',
                ]
            ],
            [
                'number' => '04',
                'price' => 35,
                'items' => [
                    'Furandana or Bhuteko Chiura',
                    'Chicken Chilli',
                    'Chicken Choila',
                    'Piro Aalu or Aalu Aachar',
                    'Prawn Cracker or Papad',
                    'Soyabean (masyora) Sadheko',
                    'Peanut Sadheko',
                    'Pulau or Jeera Rice',
                    'Fried Fish or Chicken Roast',
                    'Chicken Curry or Goat Curry',
                    'Aalutama or Dal Fry or Raajma',
                    'Chicken or Veg Chowmein',
                    'Aalu Cauli',
                    'Tomato Achar',
                    'Lalmon',
                ]
            ],
        ],

                'extras' => [
            [
                'title' => 'Newa Mains Menu',
                'price' => 20,
                'items' => [
                    'Pulau or Jeera Rice',
                    'Goat Curry or Chicken Curry',
                    'Aalu Aachar or Tomato Aachar',
                    'Rajma or Aalu Tama',
                    'Cauli Aalu',
                    'Lalmon',
                ]
            ],
            [
                'title' => 'Samaye Baji Set',
                'price' => 30,
                'items' => [
                    'Baji (Chiura)',
                    'Laba-Mushya-Palu',
                    'Mass ko Bara',
                    'Anda',
                    'Bhuti',
                    'Saag(Palung)',
                    'Aalu Aachar',
                    'Chicken Choila',
                    'Thulo Sanya Macha',
                    'Khasi ko Masu',
                    'Aalu Tama',
                ]
            ],
            [
                'title' => 'Puja Package',
                'price' => 24,
                'items' => [
                    'Puri',
                    'Kheer',
                    'Aalu Kerau or Chana Aalu',
                    'Pulau or plain rice or Jeera Rice',
                    'Aalu Cauli',
                    'Aalu Achar',
                    'Fried Daal or Rajma',
                    
                ]
            ],
            [
                'title' => 'Kids Menu   Min 10 · Select any 2',
                'price' => 14,
                'items' => [
                    'Chicken Nuggets (4pcs) & Chips',
                    'Chicken Wingetts (2pcs)',
                    'Chicken Sausages & Chips',
                    'Chicken or Veg Chowmein',
                    'Creamy Chicken Pasta',
                ]
            ],
        ],

       'addons' => [
            ['name' => 'Veg Chowmein', 'price' => 6],
            ['name' => 'Chicken Chowmein', 'price' => 7],
            ['name' => 'Buff Chowmein', 'price' => 9],
            ['name' => 'Chicken Momo (10pcs)', 'price' => 15],
            ['name' => 'Chicken Roast', 'price' => 7],
            ['name' => 'Buff Choila', 'price' => 9],
            ['name' => 'Mutton Choila', 'price' => 9],
            ['name' => 'Fish Fry', 'price' => 9],
            ['name' => 'Mattar Paneer', 'price' => 8],
            ['name' => 'Buff Chilli', 'price' => 12],
            ['name' => 'Goat Bhutan', 'price' => 11],
            ['name' => 'Goat Fokso', 'price' => 12],
            ['name' => 'Palak Paneer', 'price' => 8],
            ['name' => 'Selroti (min 25pcs)', 'price' => 2],
            ['name' => 'Gajar ko Halwa ', 'price' => 4],
        ]
    ];

    return view('web.home', compact('catering'));
}

public function index1(Request $request)
{
    $allPackages = \DB::table('packages')
        ->where('is_active', 1)
        ->orderBy('id')
        ->get();

    $cateringPackages = [];
    $cateringExtras = [];

    // Fetch all package items in one query to preserve order
    $packageItems = \DB::table('package_items')
        ->join('items', 'package_items.item_id', '=', 'items.id')
        ->orderBy('package_items.package_id')
        ->orderBy('package_items.group_id')
        ->orderBy('package_items.id') // preserves insertion order
        ->get([
            'package_items.package_id',
            'package_items.group_id',
            'items.item_name'
        ]);

    foreach ($allPackages as $package) {
        $itemsArray = [];

        // Filter items for this package
        $itemsForPackage = $packageItems->where('package_id', $package->id);

        // Group by group_id
        $grouped = [];
        foreach ($itemsForPackage as $item) {
            $grouped[$item->group_id][] = $item->item_name;
        }

        // Join items in the same group with ' or '
       foreach ($grouped as $groupId => $groupItems) {
    $itemsArray[] = [
        'group_id' => $groupId,
        'label'    => implode(' or ', $groupItems),
    ];
}

        if ($package->id <= 4) { // main packages
            $cateringPackages[] = [
                'id' => $package->id,
                'number' => str_pad($package->id, 2, '0', STR_PAD_LEFT),
                'price' => $package->price_per_pax,
                'items' => $itemsArray
            ];
        } else { // extras / kids menu
            $cateringExtras[] = [
                'id' => $package->id,
                'title' => $package->package_name,
                'price' => $package->price_per_pax,
                'items' => $itemsArray
            ];
        }
    }

    // Hardcoded addons
    $addons = [
        ['name' => 'Veg Chowmein', 'price' => 6],
        ['name' => 'Chicken Chowmein', 'price' => 7],
        ['name' => 'Buff Chowmein', 'price' => 9],
        ['name' => 'Chicken Momo (10pcs)', 'price' => 15],
        ['name' => 'Chicken Roast', 'price' => 7],
        ['name' => 'Buff Choila', 'price' => 9],
        ['name' => 'Mutton Choila', 'price' => 9],
        ['name' => 'Fish Fry', 'price' => 9],
        ['name' => 'Mattar Paneer', 'price' => 8],
        ['name' => 'Buff Chilli', 'price' => 12],
        ['name' => 'Goat Bhutan', 'price' => 11],
        ['name' => 'Goat Fokso', 'price' => 12],
        ['name' => 'Palak Paneer', 'price' => 8],
        ['name' => 'Selroti (min 25pcs)', 'price' => 2],
        ['name' => 'Gajar ko Halwa ', 'price' => 4],
        
    ];

    $catering = [
        'packages' => $cateringPackages,
        'extras'   => $cateringExtras,
        'addons'   => $addons
    ];

    // ── EDIT MODE: load existing booking if ?edit=id is in URL ──────────────
    $editBooking = null;
    if ($request->filled('edit')) {
        $editId = (int) $request->input('edit');
        $editOrder = Order::with([
            'package',
            'addonItems',
            'ItemsList.item',
            'kidsPackage',
            'kidsOrderItems.item',
        ])->find($editId);

        if ($editOrder) {
            // Reconstruct selected menu items
            $menu1 = [];
            foreach ($editOrder->ItemsList as $sel) {
                if ($sel->item) $menu1[] = $sel->item->item_name;
            }
            // Reconstruct addons with price
            $addonItems = [];
            foreach ($editOrder->addonItems as $addon) {
                $addonItems[] = [
                    'name'  => $addon->item_name,
                    'price' => (float) $addon->price_per_pax,
                ];
            }
            // Kids items
            $kidsItems = [];
            foreach ($editOrder->kidsOrderItems as $k) {
                if ($k->item) $kidsItems[] = $k->item->item_name;
            }

            $editBooking = [
                'db_id'           => $editOrder->id,
                'booking_id'      => 'BK-' . str_pad($editOrder->id, 4, '0', STR_PAD_LEFT),
                'customer_name'   => $editOrder->customer_name,
                'customer_phone'  => $editOrder->customer_phone,
                'email'           => $editOrder->email,
                'guest_count'     => $editOrder->guest_count,
                'event_date'      => $editOrder->event_date,
                'event_time'      => $editOrder->event_time,
                'notes'           => $editOrder->notes,
                'delivery_address'=> $editOrder->delivery_address,
                'delivery_type'   => ($editOrder->delivery_address === 'Self Pickup') ? 'pickup' : 'delivery',
                'package_id'      => $editOrder->package_id,
                'menu1'           => $menu1,
                'addons'          => $addonItems,
                'kids_package_id' => $editOrder->kids_package_id,
                'kids_count'      => $editOrder->kids_count,
                'kids_items'      => $kidsItems,
            ];
        }
    }

    return view('web.reservation', compact('catering', 'editBooking'));
}
}
