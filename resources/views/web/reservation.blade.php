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
             
          <div class="swiper mn-packages-swiper">
    <div class="swiper-wrapper">
        @foreach ($catering['packages'] as $package)
            <div class="swiper-slide">
                <div class="package-item" style="flex: 1 1 220px;">
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
                            <li>{{ $item['label'] }}</li>
                        @endforeach
                    </ul>
                    <button class="select-btn" data-id="{{ $package['id'] }}" data-package="Package {{ $package['number'] }}" data-price="{{ $package['price'] }}">
                        <span>Select</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination mn-pkg-pagination"></div>
</div>

            <div class="special-occasions" style="margin-top: 50px;">
                <h3 class="occasions-title">Special Occasion Menus</h3>
               <div class="swiper mn-occasions-swiper">
    <div class="swiper-wrapper">
        @foreach ($catering['extras'] as $extra)
            <div class="swiper-slide">
                <div class="occasion-card" style="flex: 1 1 220px; padding: 15px; border-radius: 8px;">
                    <div class="occasion-header">
                        @php $titleParts = explode('·', $extra['title']); @endphp
                        <h4>
                            {{ $titleParts[0] }}
                            @if(isset($titleParts[1])) <i>{{ $titleParts[1] }}</i> @endif
                        </h4>
                        <span class="occasion-price">${{ $extra['price'] }} <small>pp</small></span>
                    </div>
                    <ul class="package-menu">
                        @foreach ($extra['items'] as $item)
                            <li>{{ $item['label'] }}</li>
                        @endforeach
                    </ul>
                    <button class="select-btn" data-id="{{ $extra['id'] }}" data-package="{{ $extra['title'] }}" data-price="{{ $extra['price'] }}">Select</button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination mn-occ-pagination"></div>
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
            <div class="form-section" >
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
                    {{-- Stores the group selections as JSON: { groupIndex: "selectedItemName", ... } --}}
                    <input type="hidden" name="package_group_items" id="groupSelectionInput">
                    <input type="hidden" name="package_id" id="selectedPackageIdInput">

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
    <input type="tel" name="customer_phone" id="phone"
           value="+61 "
           pattern="^\+61\s?4\d{8}$"
           placeholder="+61 4XXXXXXXX"
           required>
</div>
                        <div class="form-group">
                            <label>Guests <span class="required">*</span></label>
                            <input type="number" name="guest_count" id="guests" required placeholder="Enter number of guests" min="15" title="For catering events, minimum 15 guests are required">
                        </div>
                        <div class="form-group">
                            <label>Preferred Date <span class="required">*</span></label>
                            <input type="date" name="event_date" id="date" class="theme-date" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label>Preferred Time <span class="required">*</span></label>
                            <input type="text" name="event_time" id="time" placeholder="Select Time" class="theme-time">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label>Special Requests</label>
                        <textarea name="notes" id="special_requests" rows="4" placeholder="Tell us about dietary restrictions, allergies, special occasions, or seating preferences..."></textarea>
                    </div>

                   <div class="catering-fields" id="cateringFields" style="display: none;">
    <div class="catering-divider">
        <span>Event Details</span>
    </div>

    {{-- Pickup / Delivery Toggle --}}
    <div class="form-group">
        <label>Delivery Option <span class="required">*</span></label>
        <div class="pickup-delivery-toggle">
            <button type="button" class="pdt-btn active" id="btn-pickup" data-type="pickup">
                <i class="fas fa-shopping-bag"></i> Self Pickup
            </button>
            <button type="button" class="pdt-btn" id="btn-delivery" data-type="delivery">
                <i class="fas fa-truck"></i> Delivery
            </button>
        </div>
        <input type="hidden" name="delivery_type" id="deliveryTypeInput" value="pickup">
    </div>

    {{-- Address field (hidden until Delivery is selected) --}}
    <div id="addressshow" style="display:none;">
        <div class="form-group" style="margin-top:5%; margin-bottom:2%;" >
            <label>Event Venue Address</label>
            <input type="text" name="delivery_address" id="event_address" placeholder="Enter venue location">
           
        </div>
        <div class="delivery-info-note">
            <i class="fas fa-clock"></i>
            Delivery charges may vary based on your location. Our team will confirm the final fee after booking.
        </div>
    </div>
</div>

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
    </div>
</section>

<!-- Information Cards -->
<section class="info-section">
    <div class="container">
        <div class="info-grid">
            <div class="info-block">
                <div class="info-icon"><i class="fas fa-utensils"></i></div>
                <h3>Catering Services</h3>
                <div class="info-details">
                    <p><strong>Flexible Scheduling:</strong> We operate based on your event timing.</p>
                    <p><strong>Custom Menu Options:</strong> We can adjust our menu according to your dietary requirements. Prices may vary based on customization.</p>
                </div>
            </div>
            <div class="info-block">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3>Visit Us</h3>
                <div class="info-details">
                    <p><strong>Phone</strong> +61 451 211 959</p>
                    <p><strong>Email</strong> newa.catering.sydney@gmail.com</p>
                    <p><strong>Location</strong> Sydney, Australia</p>
                </div>
            </div>
            <div class="info-block">
                <div class="info-icon"><i class="fas fa-info-circle"></i></div>
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

<!-- Order Confirmation Modal (existing) -->
<div id="orderConfirmationModal" class="custom-modal">
    <div class="custom-modal-content">
        <h1>Order Confirmed!</h1>
        <h2>Your Order Details</h2>
        <div id="orderConfirmationContent">Your order details here</div>
        <button id="closeConfirmationBtn">Close</button>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     GROUP SELECTION MODAL — New
════════════════════════════════════════════════════════════ -->
<div id="groupSelectionModal" class="gsm-overlay">
    <div class="gsm-modal">
        <button class="gsm-x-close" id="gsmCloseBtn" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
        <div class="gsm-body">
            <!-- Filled dynamically by JS -->
        </div>
        <div class="gsm-footer">
            <button type="button" id="gsmConfirmBtn" class="gsm-confirm-btn">
                <span>Confirm My Choices</span>
                <i class="fas fa-check"></i>
            </button>
        </div>
    </div>
</div>

<!-- Pass ALL package + extra data to JS -->
@php
    $allPackagesData = array_merge(
        array_map(fn($p) => ['id' => $p['id'], 'items' => $p['items']], $catering['packages']),
        array_map(fn($e) => ['id' => $e['id'], 'items' => $e['items']], $catering['extras'])
    );
@endphp
<script>
    window.allPackagesData = @json($allPackagesData);
    const cateringPackages = @json($catering['packages']);
</script>
<script src="{{ asset('web/js/reservation.js') }}"></script>
<style>
    /* ── Reservation page real-mobile fix ─────────────────── */
@media (max-width: 768px) {

    /* Prevent ANY horizontal overflow on the page */
    html, body {
        overflow-x: hidden !important;
        width: 100% !important;
        max-width: 100vw !important;
    }

    /* Fix the hero section width */
    .reservation-hero {
        width: 100% !important;
        max-width: 100vw !important;
        overflow: hidden !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    /* Hero overlay must not exceed viewport */
    .hero-overlay {
        width: 100% !important;
        max-width: 100% !important;
        left: 0 !important;
        right: 0 !important;
    }

    /* Container on reservation page */
    .reservation-content .container,
    .info-section .container {
        padding-left: 16px !important;
        padding-right: 16px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
    }

    /* Fix form section — remove the fixed margins */
    .form-section {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        box-sizing: border-box !important;
    }

  
    /* Packages wrapper */
    .packages-wrapper {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
        padding: 0 !important;
        box-sizing: border-box !important;
    }

    /* Selected info box — can overflow on small screens */
    .selected-info {
        width: 100% !important;
        box-sizing: border-box !important;
        text-align: left !important;
        padding: 12px 16px !important;
        word-break: break-word !important;
    }

    /* Add-ons grid */
    .mn-addons__grid {
        grid-template-columns: 1fr 1fr !important;
        gap: 10px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Info section cards */
    .info-grid {
        grid-template-columns: 1fr !important;
    }

    .info-block {
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Submit button */
    .submit-btn {
        width: 100% !important;
        box-sizing: border-box !important;
        padding: 16px 20px !important;
    }
}
</style>

@endsection