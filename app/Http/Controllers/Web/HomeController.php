<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                'price' => 10,
                'items' => [
                    'Puri',
                    'Kheer',
                    'Aalu Kerau or Chana Aalu',
                    'Pulau or plain rice or Jeera Rice',
                    'Aalu Cauli',
                    'Aalu Achar',
                    'Fried Daal or Rajma',
                    'Gajar ko Haluwa (Dessert) +$4',
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
        ]
    ];

    return view('web.home', compact('catering'));
}

 public function index1()
{
    $catering = [
        'packages' => [
            [   'id' => 1,
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
            [   'id' => 2,
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
            [   'id' => 3,
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
            [   'id' => 4,
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
            [   'id' => 5,
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
            [   'id' => 6,
                'title' => 'Samaye Baji Set',
                'price' => 30,
                'items' => [
                    'Baji (Chiura)',
                    'Laba-Mushya-Palu',
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
            [   'id' => 7,
                'title' => 'Puja Package',
                'price' => 10,
                'items' => [
                    'Puri',
                    'Kheer',
                    'Aalu Kerau or Chana Aalu',
                    'Pulau or plain rice or Jeera Rice',
                    'Aalu Cauli',
                    'Aalu Achar',
                    'Fried Daal or Rajma',
                    'Gajar ko Haluwa (Dessert) +$4',
                ]
            ],
            [   'id' => 8,
                'title' => 'Kids Menu Min 10 Select any 2',
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
        ]
    ];

    return view('web.reservation', compact('catering'));
}
}
