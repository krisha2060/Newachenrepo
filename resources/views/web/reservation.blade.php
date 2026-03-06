@extends('layouts.web')
@section('content')

<!-- Hero Section -->
<section class="reservation-hero">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <span class="subtitle">Experience Tradition</span>
            <h1><em>Reserve</em> Your<br>Special Moment</h1>
            <p>Join us for an unforgettable journey through authentic Newari cuisine</p>
        </div>
    </div>
    <div class="scroll-indicator">
        <span>Scroll to explore</span>
        <div class="scroll-line"></div>
    </div>
</section>



<!-- Main Content -->
<section class="reservation-content">
    <div class="container">
        
        <!-- Catering Packages Grid -->
        <div class="packages-wrapper" id="cateringSection" style="display: none;">
            <div class="section-intro">
                <span class="subtitle">For Special Occasions</span>
                <h2>Catering Packages</h2>
                <p class="intro-text">Curated menus for gatherings of 15 or more guests. All prices exclude GST.</p>
            </div>

            <!-- Main Packages -->
          <div class="premium-packages" style="display: flex; gap: 20px; flex-wrap: wrap;">
            @foreach ($catering['packages'] as $package)
                <div class="package-item" style="flex: 1 1 220px;">
                  <!--  <div class="package-badge">Package {{ $package['number'] }}</div>-->
                    <div class="package-top">
                        <h3>Package {{ $package['number'] }}</h3>
                        <div class="package-pricing">
                            <span class="price">${{ $package['price'] }}</span>
                            <span class="per">pp</span>
                        </div>
                    </div>
                    <div class="package-divider"></div>
                    <ul class="package-menu">
                        @foreach ($package['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                    <button class="select-btn" data-id="{{ $package['id'] }}"  data-package="Package {{ $package['number'] }}" data-price="{{ $package['price'] }}">
                        <span>Select</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            @endforeach
        </div>

   <div class="special-occasions" style="margin-top: 50px;">
        <h3 class="occasions-title">Special Occasion Menus</h3>
        <div class="occasion-packages" style="display: flex; gap: 20px; flex-wrap: wrap;">
            @foreach ($catering['extras'] as $extra)
            <div class="occasion-card" style="flex: 1 1 220px; padding: 15px; border-radius: 8px;">
                <div class="occasion-header">
                    @php
                        $titleParts = explode('·', $extra['title']);
                    @endphp
                    <h4>
                        {{ $titleParts[0] }} 
                        @if(isset($titleParts[1]))
                            <i>{{ $titleParts[1] }}</i>
                        @endif
                    </h4>
                    <span class="occasion-price">${{ $extra['price'] }} <small>pp</small></span>
                </div>
                    <ul class="package-menu">
                        @foreach ($extra['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                <button class="select-btn" data-id="{{ $extra['id'] }}" data-package="{{ $extra['title'] }}" data-price="{{ $extra['price'] }}">Select</button>
            </div>
            @endforeach
        </div>
    </div>

  {{-- Add-ons --}}
  <h3 class="occasions-title">Extra Add-ons Min 15 people</h3>
    <div class="mn-addons__grid">
        
        @foreach($catering['addons'] as $addon)
            <div class="mn-addon" data-price="{{ $addon['price'] }}" data-name="{{ $addon['name'] }}">
                {{ $addon['name'] }} <b>${{ $addon['price'] }} pp</b>
            </div>
        @endforeach
    </div>



        <!-- Reservation Form -->
        <div class="form-section">
            <div class="form-intro">
                <span class="subtitle">Your Details</span>
                <h2>Complete Your Reservation</h2>
                <div class="selected-info" id="selectedInfo">
                    <i class="fas fa-info-circle"></i>
                    <span class="info-label">No package selected</span>
                </div>
            </div>

            <form action="{{ route('orders.store') }}" method="POST" id="reservationForm" class="elegant-form">
                @csrf
                
                <input type="hidden" name="package_id" id="selectedPackageInput">
                <input type="hidden" name="package_price" id="packagePriceInput">
                <input type="hidden" name="addons" id="addonsInput">
                <input type="hidden" name="total_price" id="totalPriceInput">
                <input type="hidden" name="package_name" id="selectedPackageNameInput">
                


                <!-- Personal Information Grid -->
                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="customer_name" id="name" required placeholder="John Doe">
                    </div>
                    
                    <div class="form-group">
                        <label>Email Address <span class="required">*</span></label>
                        <input type="email" name="email" id="email" required placeholder="john@example.com">
                    </div>

                    <div class="form-group">
                        <label>Phone Number <span class="required">*</span></label>
                        <input type="tel" name="customer_phone" id="phone" required placeholder="+61 XXX XXX XXX">
                    </div>
                    
                    <div class="form-group">
                        <label>Number of Guests <span class="required">*</span></label>
                        
                            <input 
                                type="number" 
                                name="guest_count" 
                                id="guests" 
                                required 
                                placeholder="Enter number of guests"
                                min="15"
                                title="For catering events, minimum 15 guests are required"
                            >
                        
                    </div>

                    <div class="form-group">
                        <label>Preferred Date <span class=" required">*</span></label>
                        <input type="date" name="event_date" id="date" class="theme-date" required min="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div class="form-group">
                        <label>Preferred Time <span class="required">*</span></label>
                      <input type="text" name="event_time" id="time" placeholder="Select Time" class="theme-time">
                    </div>
                </div>

                <!-- Special Requests -->
                <div class="form-group full-width">
                    <label>Special Requests</label>
                    <textarea name="notes" id="special_requests" rows="4" placeholder="Tell us about dietary restrictions, allergies, special occasions, or seating preferences..."></textarea>
                </div>

                <!-- Catering Specific Fields -->
                <div class="catering-fields" id="cateringFields" style="display: none;">
                    <div class="catering-divider">
                        <span>Event Details</span>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Event Venue Address</label>
                            <input type="text" name="delivery_address" id="event_address" placeholder="Enter venue location">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-submit">
                    <button type="submit" class="submit-btn">
                        <span>Confirm Reservation</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <p class="terms-note">By confirming, you agree to our reservation terms and cancellation policy</p>
                </div>
            </form>
        </div>

    </div>
</section>

<!-- Information Cards -->
<section class="info-section">
    <div class="container">
        <div class="info-grid">
          <div class="info-block">
    <div class="info-icon">
        <i class="fas fa-utensils"></i>
    </div>
    <h3>Catering Services</h3>
    <div class="info-details">
        
        <p><strong>Flexible Scheduling:</strong> We operate based on your event timing.</p>
        <p><strong>Custom Menu Options:</strong> We can adjust our menu according to your dietary requirements. Prices may vary based on customization.</p>
    </div>
</div>

            <div class="info-block">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Visit Us</h3>
                <div class="info-details">
                    <p><strong>Phone</strong> +61 433 551 636</p>
                    <p><strong>Email</strong> newa.catering.sydney@gmail.com</p>
                    <p><strong>Location</strong> Sydney, Australia</p>
                </div>
            </div>

            <div class="info-block">
                <div class="info-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h3>Important Notes</h3>
                <div class="info-details">
                    <p>• Catering minimum 15 guests</p>
                    <p>• 24-hour cancellation notice</p>
                    <p>• Subject to availability</p>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="orderConfirmationModal" class="custom-modal">
    <div class="custom-modal-content">
        <h1>Order Confirmed!</h1>
        <h2>Your Order Details</h2>
        <div id="orderConfirmationContent">Your order details here</div>
        <button id="closeConfirmationBtn">Close</button>
    </div>
</div>

<script src="{{ asset('web/js/reservation.js') }}"></script>



<style>
    /* css for the modal popup */
    
#orderConfirmationModal.custom-modal {
    display: none;
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.5) !important;
    justify-content: center;
    align-items: center;
    z-index: 99999 !important;
}

/* Modal box */
#orderConfirmationModal .custom-modal-content {
    background-color: #3d2c2c !important;  
    color: #ffffff !important;
    padding: 20px !important;
    border-radius: 15px !important;
    max-width: 400px !important;
    width: 90% !important;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3) !important;
    text-align: center;

    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
    word-break: break-word !important;
}
#orderConfirmationModal .custom-modal-content p {
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-word;
    max-width: 100%;
}
/* Heading */
#orderConfirmationModal h2 {
    color: #8cdd09 !important;  
    margin-top: 0;
    font-size: 22px;
}

/* Button */
#orderConfirmationModal button {
    background-color: #f7f7f7 !important;
    color: #010101 !important;
    border: none !important;
    padding: 10px 20px !important;
    border-radius: 5px !important;
    cursor: pointer;
    margin-top: 5px !important;
}

#orderConfirmationModal button:hover {
    background-color: #cdcdce !important;
}
</style>
@endsection