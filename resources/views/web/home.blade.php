@extends('layouts.web')




@section('content')
        <section class="hero-slider" id="home">
            <div class="slide active" style="background-image: url('{{ asset('web/images/photo3.JPG') }}');">
                <div class="container">
                    <div class="slide-content">
                        <h1 style="font-weight: 900;"><em>Welcome</em> to<br>NEWA CHEN</h1>
                        <p>"A Taste To Remember"</p>
                        <div class="slide-buttons">
                            <a href="#menu" class="btn-underline">View Menus</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: url('{{ asset('web/images/DSC07155.JPG') }}');">
                <div class="container">
                    <div class="slide-content">
                         <h1 style="font-weight: 900;"><em>Welcome</em> to<br>NEWA CHEN</h1>
                        <p>"A Taste To Remember"</p>
                        <div class="slide-buttons">
                            <a href="#menu" class="btn-underline">View Menus</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: url('{{ asset('web/images/photo2.JPG') }}');">
                <div class="container">
                    <div class="slide-content">
                         <h1 style="font-weight: 900;"><em>Welcome</em> to<br>NEWA CHEN</h1>
                        <p>"A Taste To Remember"</p>
                        <div class="slide-buttons">
                            <a href="#menu" class="btn-underline">View Menus</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: url('{{ asset('web/images/DSC07145.JPG') }}');">
                <div class="container">
                    <div class="slide-content">
                         <h1 style="font-weight: 900;"><em>Welcome</em> to<br>NEWA CHEN</h1>
                        <p>"A Taste To Remember"</p>
                        <div class="slide-buttons">
                            <a href="#menu" class="btn-underline">View Menus</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: url('{{ asset('web/images/photo1.JPG') }}');">
                <div class="container">
                    <div class="slide-content">
                         <h1 style="font-weight: 900;"><em>Welcome</em> to<br>NEWA CHEN</h1>
                        <p>"A Taste To Remember"</p>
                        <div class="slide-buttons">
                            <a href="#menu" class="btn-underline">View Menus</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>

        <section class="about-section" id="about">
        
            <div class="about-bg-overlay">

            </div>
            <div class="about-inner container">
                <div class="about-deco-line"></div>
                <div class="about-content-wrap">
                    <div class="about-left">
                        <span class="subtitle">ABOUT US</span>
                        <h2 class="about-s">A Taste of <em>Nepal,</em><br>A Place Called Home</h2>
                    
                    </div>
                    <div class="about-right">
                        <p class="about-lead">At Newa Chen & Catering Services, we bring the rich flavours of traditional Newari and Nepalese cuisine to your table.</p>
                        <p class="about-body">Every dish is prepared with authentic recipes, fresh ingredients, and the same care you would find in a Newari home. From comforting classics to festive favourites, our menu is inspired by the culture, celebrations, and memories of Nepal.</p>
                        <p class="about-body">Whether you're dining with us or hosting a special event, we focus on quality, consistency, and true taste in every bite. From dine-in meals to catering for special occasions, we bring consistency, quality, and tradition to every plate.</p>
                        <p class="about-closing">At Newa Chen, food is more than a meal — it's a connection to <span class="about-highlight">tradition, family, and home.</span></p>
                        <a href="#menu" class="btn-underline about-cta">Explore Our Menu</a>
                    </div>
                </div>
                <div class="about-deco-line"></div>
            </div>
        </section>

        <section class="menu-section" id="menu">
        <div class="container">
                   <div class="section-title">
      <span class="subtitle">Our Menus</span>
    </div>

    <!-- Sticky pill switcher -->
    <div class="mn-tab-sticky">
      <div class="mn-pill-track">
        <button class="mn-pill active" data-tab="catering">Catering</button>
        <button class="mn-pill" data-tab="restaurant">Restaurant</button>
      </div>
    </div> 
    
    
        <div class="mn-panel" id="tab-catering">
        <div class="mn-catering">
            <div class="mn-catering__header">
                <span class="subtitle">Catering</span>
                <h3>Newa Catering Menu</h3>
                <p>Minimum 15 people (For Package 4 minimum 25 guests)</p>
                <br>
                <a href="{{ route('reservation') }}" class="btn-underline">Book Catering Now</a>
            </div>

            {{-- 4 packages side by side --}}
           <div class="mn-pkgs">
                @foreach($catering['packages'] as $pkg)
                    <div class="mn-pkg">
                        <div class="mn-pkg__top">
                            <div class="mn-pkg__num">{{ $pkg['number'] }}</div>
                            <div class="mn-pkg__price">${{ $pkg['price'] }} </div>
                        </div>
                        <ul>
                            @foreach($pkg['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            {{-- Special menus below --}}
            <h3 class="occasions-title">Special Occasions</h3>
            <div class="mn-extras">
                @foreach($catering['extras'] as $extra)
                    <div class="mn-extra">
                        <div class="mn-extra__head">
                            <h2>{{ $extra['title'] }}</h2>
                            <span class="mn-extra__price">${{ $extra['price'] }} <small>pp</small></span>
                        </div>
                        <ul>
                            @foreach($extra['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            {{-- Add-ons --}}
            <h3 class="occasions-title">Extra Add-ons Min 15 people</h3>
            <div class="mn-addons">
                <div class="mn-addons__grid">
                    @foreach($catering['addons'] as $addon)
                        <div class="mn-addon">
                            {{ $addon['name'] }}<b>${{ $addon['price'] }} pp</b>
                        </div>
                    @endforeach
                </div>
            </div>
            

        </div>
</div>

        
 <div class="mn-panel" id="tab-restaurant" style="display:none">
     
                <div class="section-title">
                   
                            <span class="subtitle"> <p> "Walk-in dining only · no online booking"</p>Our Restaurant Menu </span>
                            
                            
                             <p>Every dish is prepared with authentic recipes, fresh ingredients, and the same care you would find in a Newari home. From comforting classics to festive favourites, our menu is inspired by the culture, celebrations, and memories of Nepal.</p>                </div>

                    <div class="menu-grid">
                        <div class="menu-carousel" id="lunch-carousel">
                <div>
                <h1 style="display:flex; align-items:center; justify-content:space-between;">
                    <span class="menu-column">Lunch Menu</span>

                    <span style="text-align:center; cursor:pointer; line-height:1;" onclick="lunch.next()">
                        <img src="{{asset('web\images\arrowleft.png')}}" alt="Next" style="width:150px; display:block;">
                        <span style="font-size:15px; font-weight:500; margin-top:-8px; display:block;">
                           Next
                        </span>

                    </span>
                </h1>
            </div>
            <br>
                <div class="menu-page">
                    <h3></h3>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Choila Set <h5> Choila(Chicken/Buff)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$18/$20</span>
                        </div>
                        <p class="menu-description">Choice of Chicken or Buff Choila served with Alu Aachar and Chuira</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Bhutan Set</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$20</span>
                        </div>
                        <p class="menu-description">Twice cooked Goat Tripe and Intestine, Served with Aalu Aachar and Chuira</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Chicken Sausage(2 pcs)</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$12</span>
                        </div>
                        <p class="menu-description">Deep Fried sausages served with house sauce.</p>
                    </div>
                    
                    
                </div>

                <!-- Page 2 -->
                <div class="menu-page">
                    <h3></h3>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">MOMO</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price"></span>
                        </div>
                        <p class="menu-description">Nepalese style steamed dumpling with fillings of vegetable/chicken/buff mince with garlic, ginger, coriander and Nepalese spices served with home made sauce.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Steamed MOMO <h5>(Veg/Chicken/Buff)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$14/$16/$18</span>
                        </div>
                        <p class="menu-description"></p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Jhol MOMO <h5>(Veg/Chicken/Buff)</h5> </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$15/$17/$19</span>
                        </div>
                        <p class="menu-description"></p>
                    </div>
                
                </div>

                <!-- Page 3 -->
                <div class="menu-page">
                    <h3></h3>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Chowmien <h5>Veg/Chicken/Buff</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$15/$17/$19</span>
                        </div>
                        <p class="menu-description">Nepalese style stir-fried noodle sautéed with veggies, garlic and flavouring of Nepalese herbs and spices.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Fried Chicken <h5>Veg/Chicken/Buff</h5> </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$14/$16/$18</span>
                        </div>
                        <p class="menu-description">Stir fried steamed rice with mixed vegetables, spices and Nepalese herbs.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Newa Chen Samaya Baji Set <h5>Chicken/Buff</h5> </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$25/$27</span>
                        </div>
                        <p class="menu-description">Baji, choila, aalu aachar, aalutama, plainbara, bhuti, laba-mushya-palu, palung, khen and nhya..</p>
                    </div>
                    </div>
                    <!-- Page 4 -->
                <div class="menu-page">
                    <h3>KIDS MENU</h3> 
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Chowmien <h5>Veg/Chicken</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$10/$13</span>
                        </div>
                        <p class="menu-description"></p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Nuggets and chips<h5>Nuggets (5pieces) </h5> </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$12</span>
                        </div>
                        <p class="menu-description"></p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Chips  </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$8</span>
                        </div>
                        <p class="menu-description"></p>
                    </div>
                
                </div>
                
                

            <!--<div style="display:flex; justify-content:space-between; align-items:center;">
                <img src="/images/arrow1.png" alt="Prev" style="cursor:pointer; width:150px;" onclick="prevPage()">
                <img src="/images/arrowleft.png" alt="Next" style="cursor:pointer; width:150px;" onclick="nextPage()">
            </div>-->
            <!-- Add more pages as needed -->
            </div>


            <div class="image-grid">
                <img src="{{asset('web\images\DSC07441.JPG')}}" alt="Food">
                
                <div>
                    <img src="{{asset('web\images\DSC07441.JPG')}}" alt="Food">
                    <img src="{{asset('web\images\DSC07221.JPG')}}" alt="Food">
                </div>
            </div>
                        </div>

                        


            <div class="menu-grid">
                <div class="image-grid">
                    <img src="{{asset('web\images\DSC07189.JPG')}}" alt="Food">                 
                    <img src="{{asset('web\images\DSC07160.JPG')}}" alt="Food">
                </div>

                <div class="menu-carousel" id="drinks-carousel">
                    <div>
                        <h1 style="display:flex; align-items:center; justify-content:space-between;">
                            <span class="menu-column">Drinks</span>

                                <span style="text-align:center; cursor:pointer; line-height:1;" onclick="drinks.next()">
                                    <img src="{{asset('web\images\arrowleft.png')}}" alt="Next" style="width:150px; display:block;">
                                <span style="font-size:15px; font-weight:500; margin-top:-8px; display:block;">
                                Next
                                </span>
                            </span>
                        </h1>
                    </div>
                    <br>
                    <div class="menu-page">
                    <h2>COLD BEVERAGES</h2>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Soft Drinks <h5> (Coke, Fanta, Sprite)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$3</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Mango Lassi <h5> (Apple, Mango, Orange)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$7</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Juice</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$4</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Sparkling Water <h5> (500 ML)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$4</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Bottle of Water <h5> (600 ML)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$3</span>
                        </div>
                    </div>       
                </div>

                <div class="menu-page">
                    <h2>HOT BEVERAGES</h2>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Cardamom Tea <h5> (Coke, Fanta, Sprite)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$4</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">House Coffee <h5> (Apple, Mango, Orange)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$4</span>
                        </div>
                    </div>   
                </div>

                <div class="menu-page">
                    <h2>BEER SELECTION</h2>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Barasinghe Pilsner</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$10</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Barasinghe 8</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$4</span>
                        </div>
                    </div>
                        <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Nepal Ice</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$10</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Nepal Ice Strong</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$4</span>
                        </div>
                    </div>     
                </div>

                <div class="menu-page">
                <h2>BEER SELECTION</h2>
                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Mustang-Blue</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$10</span>
                    </div>
                </div>
                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Mustang-Red</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$12</span>
                    </div>
                </div>
                    <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Corona</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$9</span>
                    </div>
                </div>
                        <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Non Alcoholic Beer</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$7</span>
                    </div>
                </div>   
            </div>

                <div class="menu-page">
                <h2>SPIRITS</h2>
                <p class="menu-description">30ml-served on the rocks or coke/lemonade</p>

            
                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Bandipur-Biended Matt Scotch Whiskey</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$12</span>
                    </div>
                </div>
                    <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Khukuri Spiced Rum</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$9</span>
                    </div>
                </div>

                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Old Durbar - Black Chimney </span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$10</span>
                    </div>
                </div>
            
                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Old Durbar - Two Continents</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$10</span>
                    </div>
                </div>      
            </div>


            <div class="menu-page">
                <h2>SPIRITS</h2>
                <p class="menu-description">30ml-served on the rocks or coke/lemonade</p>

            
                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">8848 Vodka </span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$10</span>
                    </div>
                </div>
                    <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Gurkhas & Guns</span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$10</span>
                    </div>
                </div>

                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">JACK DANIEL'S Old No.7 Tennessee Whiskey </span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$10</span>
                    </div>
                </div>    
            </div>


            <!-- Page 2 -->
            <div class="menu-page">
                <h2>WINES</h2>
                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">Red wine <h5>(per serve/ Bottle)</h5></span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$8/$35</span>
                    </div>
                    <p class="menu-description"></p>
                </div>
                <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">White wine<h5>(per serve/ Bottle)</h5> </span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$8/$35</span>
                    </div>
                    <p class="menu-description"></p>
                </div>
                    <div class="menu-item">
                    <div class="menu-header">
                        <span class="menu-title">CHYANG <h5>(Rice Wine) 750ml </h5> </span>
                        <div class="menu-dots"></div>
                        <span class="menu-price">$19</span>
                    </div>
                    <p class="menu-description"></p>
                </div>
            
            </div>

        

        <!--<div style="display:flex; justify-content:space-between; align-items:center;">
            <img src="/images/arrow1.png" alt="Prev" style="cursor:pointer; width:150px;" onclick="prevPage()">
            <img src="/images/arrowleft.png" alt="Next" style="cursor:pointer; width:150px;" onclick="nextPage()">
        </div>-->
        <!-- Add more pages as needed -->
        </div>
                    </div>


                        <div class="menu-grid">
                        

            <div class="menu-carousel" id="dinner-carousel">
                <div>
                <h1 style="display:flex; align-items:center; justify-content:space-between;">
                    <span class="menu-column">Dinner Menu</span>

                    <span style="text-align:center; cursor:pointer; line-height:1;" onclick="dinner.next()">
                        <img src="{{asset('web\images\arrowleft.png')}}" alt="Next" style="width:150px; display:block;">
                        <span style="font-size:15px; font-weight:500; margin-top:-8px; display:block;">
                           Next
                        </span>
                    </span>
                </h1>
            </div>
            <br>
                <div class="menu-page">
                    <h3></h3>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Chicken Sausage <h5> (2 pieces)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$12</span>
                        </div>
                        <p class="menu-description">Deep fried sausages served with house sauce.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Peanut Sadheko</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$10</span>
                        </div>
                        <p class="menu-description">Peanut tossed in spices, roasted mustard oil, diced tomato, onion, cucumber, lemon juice and herbs.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Bhatmas Sadheko</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$10</span>
                        </div>
                        <p class="menu-description">Crispy soyabean tossed in spices, roasted mustard oil, diced tomato, onion, cucumber, lemon juice and herbs.</p>
                    </div>
                        <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Piro aalu</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$9</span>
                        </div>
                        <p class="menu-description">Nepali style boiled potato with spices, herbs and chilli.</p>
                    </div>
                    
                    
                    
                </div>

                <!-- Page 2 -->
                <div class="menu-page">
                    <h3></h3>
                <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Kachila</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$15</span>
                        </div>
                        <p class="menu-description">Special meat delicacy of Newars. Marinated raw buffalo mince with various spices tossed with roasted mustard oil and herbs</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Mixed Aachar</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$9</span>
                        </div>
                        <p class="menu-description">Traditional Nepali pickle made from potatoes, carrot, radish, cucucumber, chilli, sesame tossed with Himalayan spices and herbs.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Aalutama </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$9</span>
                        </div>
                        <p class="menu-description">Hot, sour and spicy soup made from potatoes, fermented bamboo shoot and black eyed beans.
            </p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Choila <h5>(chicken/buff)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$15/$17</span>
                        </div>
                        <p class="menu-description">Smokey magic of open fire grilling spiced meat tossed with roasted mustard oil and herbs.
            </p>
                    </div>
                
                </div>

                <!-- Page 3 -->
                <div class="menu-page">
                    <h3></h3>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Sanyakhuna</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$12</span>
                        </div>
                        <p class="menu-description">Spicy dried fish jelly.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Bhuttan </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$17</span>
                        </div>
                        <p class="menu-description">Twiced cooked Goat tripe and intestines, stir fried with spices and herbs.
            </p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Fokso</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$18</span>
                        </div>
                        <p class="menu-description">Goat lungs filled with spicy batter, sliced and wok fried to make it crispy served with signature house sauce.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Pangra.</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$$15</span>
                        </div>
                        <p class="menu-description">Stir fried chicken giblet with tomato, onion, chilli, spices and herbs.</p>
                    </div>
                    </div>
                    <!-- Page 4 -->
                <div class="menu-page">
                    <h3></h3> 
                
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Wo (Bara)</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price"></span>
                        </div>
                        <p class="menu-description">Nepali style Authentic pancake made from ground black lentils served with alutama or Khasi ko jhol ($2).
            </p>
                
                        <div class="menu-header">
                            <span class="menu-title">Plain </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$13</span>
                        </div>
                
                        <div class="menu-header">
                            <span class="menu-title">Masu bara <h5>(chicken mince/buff mince)       </h5> </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$16/$18</span>
                        </div>
                        <p class="menu-description"> <h4> ADD Egg <span class="menu-price"> +$3</span></h4></p>
                    </div>
                        <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Side of steamed rice</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$5</span>
                        </div>
                    
                        <div class="menu-header">
                            <span class="menu-title">Side of Small Chuira/Large Chuira</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$5/$8</span>
                        </div>
                    </div>
                
                </div>



                <!-- Page 5 -->
                <div class="menu-page">
                    <h3></h3>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Chatamari <h5>Chicken/Buff/Veg </h5> </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$17/$19/$15</span>
                        </div>
                        <p class="menu-description">  A traditional Nepali rice crepe "Nepalese pizza", Topped with a savoury blend of minced meat, fresh vegetables, and aromatic spices. <h4> ADD Egg <span class="menu-price"> +$3</span></h4></p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Bhuttan </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$17</span>
                        </div>
                        <p class="menu-description">Twiced cooked Goat tripe and intestines, stir fried with spices and herbs.
            </p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Fokso</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$18</span>
                        </div>
                        <p class="menu-description">Goat lungs filled with spicy batter, sliced and wok fried to make it crispy served with signature house sauce.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Pangra.</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$15</span>
                        </div>
                        <p class="menu-description">Stir fried chicken giblet with tomato, onion, chilli, spices and herbs.</p>
                    </div>
                    </div>

                    <!-- Page 6 -->
                <div class="menu-page">
                    <h3>MO:MO</h3>
                    <p class="menu-description"> Nepalese style steamed dumpling with fillings of vegetable/chicken/buff mince with garlic, ginger, coriander and Nepalese spices served with home made sauce.</p>

                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Steamed MO:MO <h5>(Veg/Chicken/Buff)</h5></span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$14/$16/$18</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Jhol MO:MO </span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$17</span>
                        </div>
                        <p class="menu-description">Twiced cooked Goat tripe and intestines, stir fried with spices and herbs.
            </p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Fokso</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$18</span>
                        </div>
                        <p class="menu-description">Goat lungs filled with spicy batter, sliced and wok fried to make it crispy served with signature house sauce.</p>
                    </div>
                    <div class="menu-item">
                        <div class="menu-header">
                            <span class="menu-title">Pangra.</span>
                            <div class="menu-dots"></div>
                            <span class="menu-price">$15</span>
                        </div>
                        <p class="menu-description">Stir fried chicken giblet with tomato, onion, chilli, spices and herbs.</p>
                    </div>
                    </div>

            <!-- Add more pages as needed -->
            </div>
            <div class="cta-section">
                                <img src="{{asset('web\images\DSC07334.JPG')}}" alt="Dinner Dish">


                            
                            </div>
                        </div>
                        </div>






                        <div class="center-buttons">
                            <a href="#menu" class="btn-primary">View Full Menu</a>
                            <a href="{{ route('reservation') }}" class="btn-primary">Book Catering</a>
                        </div>
                    </div>
        </section>

       

        <section class="block-links">
            <div class="block-link">
                <img src="{{asset('web\images\DSC07155.JPG')}}" alt="Restaurant Interior">
            <div class="block-overlay">
    <span class="subtitle">Premium Catering</span>
    <h3>Book Our Catering Services</h3>
    <p>Prepared fresh for weddings, parties, corporate events, and special occasions.</p>
    <p><strong></strong><br>
    </p>
    <a href="{{ route('reservation') }}" class="btn-underline">Book Catering Now</a>
</div>
            </div>
            <!-- <div class="block-link1">
                <img src="{{asset('web\images\DSC07160.JPG')}}" alt="Reservation">
                <div class="block-overlay">
                    <span class="subtitle">Book Catering</span>
                    <h3>Reservation</h3>
                    <p></p>
                    <p><strong>BOOKING</strong><br>Email:<br>newa.catering.sydney@gmail.com</p>
                    <a href="{{ route('reservation') }}" class="btn-underline">Online Booking</a>
                </div>
            </div> -->
        </section>  
        
        

        <script>document.querySelectorAll('.mn-pill').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.mn-pill').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.mn-panel').forEach(p => p.style.display = 'none');
    this.classList.add('active');
    document.getElementById('tab-' + this.dataset.tab).style.display = 'block';

    // Scroll to the menu section top, offset by navbar height
    const menuSection = document.getElementById('menu');
    if (menuSection) {
      const navbarHeight = document.querySelector('header')?.offsetHeight || 140;
      const top = menuSection.getBoundingClientRect().top + window.scrollY - navbarHeight;
      window.scrollTo({ top: top, behavior: 'smooth' });
    }
  });
});</script>
@endsection
