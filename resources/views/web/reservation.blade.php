@extends('layouts.web')
@section('content')

<!-- Hero Section -->
<section class="reservation-hero">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <span class="subtitle">Experience Tradition</span>
            <h1><em>Reserve</em> Your<br>Special Moment</h1>
            <p>"A Taste To Remember"</p>
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
                <p class="intro-text">Curated menus for gatherings of 15 or more guests. (For Package 4 minimum 25 guests)</p>
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
                        <div>@if($package['number']==4)<span>( Minimum 25 guests )</span>@endif</div>
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
        @if($extra['id'] != 8)
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
            @endif
        @endforeach
    </div>
    <div class="swiper-pagination mn-occ-pagination"></div>
</div>
            </div>

            {{-- Add-ons --}}
            <h3 class="occasions-title">Extra Add-ons</h3>
          <div class="mn-addons__grid">
    @foreach($catering['addons'] as $addon)
        @php $isQtyAddon = str_contains($addon['name'], 'Selroti'); @endphp
        <div class="mn-addon" data-price="{{ $addon['price'] }}" data-name="{{ $addon['name'] }}" data-quantity-addon="{{ $isQtyAddon ? 'true' : 'false' }}" data-min-qty="{{ $isQtyAddon ? 25 : 1 }}">
            
            <div class="mn-addon-label">{{ $addon['name'] }}</div>

            <div class="mn-addon-bottom">
                @if($isQtyAddon)
                    <div class="addon-qty-controls">
                        <button type="button" class="addon-qty-btn" data-action="decrease" aria-label="Decrease quantity">-</button>
                         <div class="addon-qty-divider1"></div>
                        <input type="number" class="addon-qty-input" value="25" min="25" step="1" aria-label="Selroti quantity">
                        <div class="addon-qty-divider"></div>
                        <button type="button" class="addon-qty-btn" data-action="increase" aria-label="Increase quantity">+</button>
                    </div>
                @endif

                <div class="mn-addon-price">
                    <b>${{ $addon['price'] }} {{ $isQtyAddon ? 'pp' : 'pp' }}</b>
                </div>
            </div>

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

                    <input type="hidden" name="kids_package_id" id="kidsPackageIdInput" value="">
<input type="hidden" name="kids_package_total" id="kidsPackageTotalInput" value="">
{{-- optional but useful for order confirmation display --}}
<input type="hidden" name="kids_count" id="kidsCountInput" value="">
<input type="hidden" name="kids_items" id="kidsItemsInput" value="">

                    <input type="hidden" name="edit_booking_id" id="editBookingIdInput" value="">

<div id="kidsBannerWrap" style="display:none; margin-top:2px;">
    <div class="kids-addon-banner" id="kidsBanner">
        <div class="kids-addon-icon">🧒</div>
        <div class="kids-addon-text">
            <div class="kids-addon-title">Add a Kids Package?</div>
            <div class="kids-addon-sub" id="kidsBannerSub">Min 10 kids · Choose any 2 items · Runs alongside your main booking</div>
        </div>
        <button type="button" class="kids-addon-cta" id="kidsAddonCta">Add +</button>
    </div>
    <div class="kids-selected-badge" id="kidsSelectedBadge" style="display:none;">
        <span class="kids-badge-dot"></span>
        <span id="kidsSelectedBadgeText">Kids package added</span>
        <span class="kids-badge-edit" id="kidsEditLink">Edit</span>
    </div>
</div>

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
                        
                        <div style="display: flex;">
                            <!-- Country Code -->
                            <span style="
                                padding: 8px 12px;
                                border-radius: 4px 0 0 4px;
                            ">
                                +61
                            </span>

                            <!-- Phone Input -->
                            <input 
                                type="tel" 
                                name="customer_phone" 
                                id="phone"
                                pattern="^4\d{8}$"
                                placeholder="4XXXXXXXX"
                                required
                                style="
                                    flex: 1;
                                    padding: 8px;
                                "
                            >
                        </div>
                    </div>
                        <div class="form-group">
                            <label>Guests <span class="required">*</span></label>
                            <input type="number" name="guest_count" id="guests" required placeholder="Enter number of guests" >
                        </div>
                        <div class="form-group">
                            <label>Preferred Date <span class="required">*</span></label>
                            <input type="date" name="event_date" id="date" class="theme-date" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label>Preferred Time <span class="required">*</span></label>
                            <input type="time" name="event_time" id="time" placeholder="Select Time" class="theme-time" >
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

                {{-- Kids Package Add-on Banner --}}

            </div>
        </div>
    </div>
</section>

<!-- Information Cards -->
<section class="info-section">
    <div class="container">
        <div class="info-grid">
               <div class="info-block">
                <div class="info-icon"><i class="fas fa-info-circle"></i></div>
                <h3>Cancellation Policy</h3>
                <div class="info-details">
                    <p>• Cancellations must be made at least 3 days in advance to be eligible for a full refund.</p>
                    <p>• A 25% cancellation fee will be deducted from the deposit.</p>
                  
                </div>
            </div>
                <div class="info-block">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3>Visit Us</h3>
                <div class="info-details">
                    <p><strong>Phone</strong> +61 451 211 959</p>
                    <p><strong>Email</strong> newa.catering.sydney@gmail.com</p>
                    <p><strong>Location</strong> 5/296 Camden Valley Way, Narellan, NSW, Australia, 2567</p>
                </div>
            </div>
            <div class="info-block">
                <div class="info-icon"><i class="fas fa-utensils"></i></div>
                <h3>Catering Services</h3>
                <div class="info-details">
                    <p>. Booking must be made at least one week in advance</p>
                    <p>. 50% deposit is required to secure your booking</p>
                    <p>. Kindly note that the remaining balance must be paid one day prior to your booking date.</p>
                    <p>. Delivery charges will apply depending on location</p>
                    <!-- <p><strong>Flexible Scheduling:</strong> We operate based on your event timing.</p> -->
                    <!-- <p><strong>Custom Menu Options:</strong> We can adjust our menu according to your dietary requirements. Prices may vary based on customization.</p> -->
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

{{-- ══ KIDS PACKAGE MODAL ══ --}}
<div id="kidsModal" class="kids-modal-overlay">
    <div class="kids-modal">
        <button class="kids-modal-x" id="kidsModalClose" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>

        <div class="kids-modal-head">
            <div class="kids-modal-head-icon">🧒</div>
            <div>
                <div class="kids-modal-badge">Optional Add-on</div>
                <h3 class="kids-modal-title" id="kidsModalTitle">Kids Package</h3>
                <p class="kids-modal-sub" id="kidsModalSub">Loading...</p>
            </div>
        </div>

        <div class="kids-step-dots">
            <div class="kids-dot active" id="kdot0"></div>
            <div class="kids-dot" id="kdot1"></div>
            <div class="kids-dot" id="kdot2"></div>
        </div>

        <div class="kids-modal-body" id="kidsModalBody">

            {{-- Step 0: Pick 2 items --}}
            <div class="kids-step" id="kstep0">
                <div class="kids-step-label">Choose 2 items <span id="kidsPickCount">(0 / 2 selected)</span></div>
                <div class="kids-limit-note">Select exactly 2 — your 2nd pick moves you forward automatically.</div>
                <div class="kids-choice-list" id="kidsChoiceList">
                    {{-- Populated by JS from window.kidsPackageItems --}}
                </div>
            </div>

            {{-- Step 1: Or-variant (shown only if needed) --}}
            <div class="kids-step" id="kstep1" style="display:none;">
                <div class="kids-step-label" id="kidsOrLabel">Pick one option</div>
                <div class="kids-limit-note">One of your selected items has a variant — choose which you prefer.</div>
                <div class="kids-or-opts" id="kidsOrOpts"></div>
            </div>

            {{-- Step 2: Kids count --}}
            <div class="kids-step" id="kstep2" style="display:none;">
                <div class="kids-step-label">Number of kids</div>
                <div class="kids-count-row">
                    <div>
                        <div class="kids-count-main">Kids attending</div>
                        <div class="kids-count-hint">Minimum 10 required</div>
                    </div>
                    <div class="kids-counter">
                        <button type="button" class="kids-counter-btn" id="kidsMinusBtn">−</button>
                        <span class="kids-counter-val" id="kidsCountDisplay">10</span>
                        <button type="button" class="kids-counter-btn" id="kidsPlusBtn">+</button>
                    </div>
                </div>
                <div class="kids-price-preview">
                    <div>
                        <div class="kids-preview-label">Kids package total</div>
                        <div class="kids-preview-breakdown" id="kidsBreakdown">Loading...</div>
                    </div>
                    <div class="kids-preview-total" id="kidsPreviewTotal">--</div>
                </div>
            </div>
        </div>

        <div class="kids-modal-foot">
            <button type="button" class="kids-btn-back" id="kidsBtnBack" style="display:none;">
                <i class="fas fa-arrow-left"></i> Back
            </button>
            <button type="button" class="kids-btn-confirm" id="kidsBtnNext" disabled>
                Select 2 items to continue
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

    const kidsPackageData = @json(collect($catering['extras'])->firstWhere('id', 8));
    
    window.kidsPackageId = kidsPackageData?.id || null;
    window.kidsPackageName = kidsPackageData?.title || 'Kids Package';
    window.kidsPackagePrice = kidsPackageData?.price || 0;
    window.kidsPackageItems = kidsPackageData?.items || [];
    console.log('kids items:', JSON.stringify(window.kidsPackageItems));

    // Update banner subtitle with actual price from database
    if (window.kidsPackagePrice) {
        const bannerSub = document.getElementById('kidsBannerSub');
        if (bannerSub) {
            bannerSub.innerHTML = `$${window.kidsPackagePrice} per kid · Min 10 kids · Choose any 2 items · Runs alongside your main booking`;
        }
    }

    window.editBooking           = @json($editBooking ?? null);
    window.ORDER_UPDATE_BASE_URL = "{{ url('/orders') }}";
    window.ADMIN_DASHBOARD_URL   = "{{ route('admin.dashboard') }}";
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

    /* .addon-qty-controls {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
        margin-top: 12px;
    } */
/* 
    .addon-qty-input {
        width: 58px;
        padding: 0;
        border-radius: 10px;
        border: 1px solid rgba(148, 163, 184, .45);
        background: #f8fafc;
        color: #111827;
        font-weight: 700;
        text-align: center;
    } */
/* 
    .addon-qty-btn {
        width: 36px;
        height: 36px;
        border: 1px solid rgba(148, 163, 184, .45);
        border-radius: 12px;
        background: #fff;
        color: #111827;
        font-size: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease;
    } */

    /* .addon-qty-btn:hover {
        background: #f8fafc;
        border-color: rgba(148, 163, 184, .75);
    } */



        .form-grid {
    grid-template-columns: 1fr 1fr !important;
}

.form-group {
    min-width: 0 !important;
}

.form-group input,
.form-group textarea {
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



/* ══ KIDS PACKAGE ADD-ON ══════════════════════════════════ */
.kids-addon-banner {
    display: flex; align-items: center; gap: 18px;
    background: linear-gradient(135deg, #0e1a0e 0%, #111811 100%);
    border: 1px solid rgba(116,172,67,0.35); border-radius: 14px;
    padding: 20px 22px; cursor: pointer;
    transition: border-color 0.25s, transform 0.2s;
    position: relative; overflow: hidden;
}
.kids-addon-banner::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, rgba(116,172,67,0.45), transparent);
}
.kids-addon-banner:hover { border-color: rgba(116,172,67,0.65); transform: translateY(-2px); }
.kids-addon-icon { font-size: 40px; flex-shrink: 0; }
.kids-addon-text  { flex: 1; }
.kids-addon-title { font-size: 20px; font-weight: 600; color: var(--white); margin-bottom: 3px; }
.kids-addon-sub   { font-size: 15px; color: rgb(103, 156, 57); }
.kids-addon-cta {
    background: rgba(116,172,67,0.15); border: 1px solid rgba(116,172,67,0.45);
    color: #74ac43; font-size: 15px; font-weight: 600; letter-spacing: 1px;
    padding: 9px 18px; border-radius: 8px; cursor: pointer; white-space: nowrap;
    transition: background 0.2s; flex-shrink: 0;
}
.kids-addon-cta:hover { background: rgba(116,172,67,0.28); }

.kids-selected-badge {
    margin-top: 10px; padding: 10px 16px;
    background: rgba(116,172,67,0.07); border: 1px solid rgba(116,172,67,0.2);
    border-radius: 8px; display: flex; align-items: center; gap: 10px;
}
.kids-badge-dot   { width: 8px; height: 8px; border-radius: 50%; background: #74ac43; flex-shrink: 0; }
.kids-selected-badge span:nth-child(2) { font-size: 13px; color: rgba(255,255,255,0.7); flex: 1; }
.kids-selected-badge span:nth-child(2) strong { color: #74ac43; }
.kids-badge-edit  { font-size: 12px; color: var(--subtle-text); cursor: pointer;
                    text-decoration: underline; text-underline-offset: 3px; white-space: nowrap; }

/* Modal overlay */
.kids-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.82); backdrop-filter: blur(6px);
    z-index: 200001; align-items: center; justify-content: center; padding: 16px;
}
.kids-modal-overlay.kids-modal-active { display: flex; animation: kidsOverlayIn 0.22s ease; }
@keyframes kidsOverlayIn { from{opacity:0} to{opacity:1} }

.kids-modal {
    position: relative; background: linear-gradient(160deg,#161212 0%,#181414 100%);
    border: 1px solid rgba(116,172,67,0.3); border-radius: 20px;
    width: 100%; max-width: 520px; max-height: 88vh;
    display: flex; flex-direction: column;
    box-shadow: 0 30px 80px rgba(0,0,0,0.7);
    animation: kidsModalUp 0.3s cubic-bezier(0.34,1.56,0.64,1); overflow: hidden;
}
@keyframes kidsModalUp {
    from{transform:translateY(24px) scale(0.97);opacity:0}
    to{transform:none;opacity:1}
}

.kids-modal-x {
    position: absolute; top: 15px; right: 15px; width: 33px; height: 33px;
    border-radius: 50%; border: 1px solid rgba(116,172,67,0.3);
    background: rgba(116,172,67,0.07); color: rgba(116,172,67,0.7);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    font-size: 13px; transition: all 0.2s; z-index: 2;
}
.kids-modal-x:hover { background: rgba(116,172,67,0.2); color: #74ac43; transform: rotate(90deg); }

.kids-modal-head {
    padding: 24px 24px 0; display: flex; align-items: flex-start; gap: 14px; flex-shrink: 0;
}
.kids-modal-head-icon {
    font-size: 24px; width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    background: rgba(116,172,67,0.1); border: 1px solid rgba(116,172,67,0.3);
    display: flex; align-items: center; justify-content: center;
}
.kids-modal-badge {
    display: inline-block; font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: #74ac43;
    background: rgba(116,172,67,0.12); border: 1px solid rgba(116,172,67,0.3);
    padding: 3px 10px; border-radius: 20px; margin-bottom: 7px;
}
.kids-modal-title { font-size: 20px; color: var(--white); font-family:'Cormorant Garamond',serif;
                    font-weight: 400; margin-bottom: 3px; }
.kids-modal-sub   { font-size: 12px; color: rgba(255,255,255,0.65); }

/* Step dots */
.kids-step-dots { display: flex; gap: 6px; justify-content: center; padding: 14px 0 0; flex-shrink: 0; }
.kids-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.15); transition: all 0.2s; }
.kids-dot.active { background: #74ac43; width: 20px; border-radius: 3px; }

/* Modal body */
.kids-modal-body {
    overflow-y: auto; flex: 1; padding: 20px 24px 0;
    scrollbar-width: thin; scrollbar-color: rgba(116,172,67,0.3) transparent;
}
.kids-modal-body::-webkit-scrollbar { width: 4px; }
.kids-modal-body::-webkit-scrollbar-thumb { background: rgba(116,172,67,0.3); border-radius: 4px; }

.kids-step-label {
    font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    color: rgba(116,172,67,0.8); margin-bottom: 10px; display: flex; align-items: center; gap: 8px;
}
.kids-step-label::after { content:''; flex:1; height:1px; background:rgba(116,172,67,0.15); }
.kids-step-label span   { color: rgba(255,255,255,0.65); text-transform: none; font-weight: 400;
                           font-size: 11px; letter-spacing: 0; }

.kids-limit-note {
    font-size: 12px; color: rgba(255,255,255,0.45); margin-bottom: 14px;
    padding: 8px 12px; background: rgba(255,255,255,0.03); border-radius: 8px;
}

/* Choice cards */
.kids-choice-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
.kids-choice-card {
    border: 1px solid rgba(255,255,255,0.08); border-radius: 10px;
    padding: 13px 16px; cursor: pointer; display: flex; align-items: center; gap: 14px;
    transition: all 0.18s; user-select: none;
}
.kids-choice-card:hover       { border-color: rgba(116,172,67,0.35); background: rgba(255,255,255,0.03); }
.kids-choice-card.kcc-selected{ border-color: rgba(116,172,67,0.55); background: rgba(116,172,67,0.07); }
.kids-choice-card.kcc-disabled{ opacity: 0.35; pointer-events: none; }
.kcc-dot {
    width: 18px; height: 18px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.25);
    flex-shrink: 0; position: relative; transition: border-color 0.18s;
}
.kcc-dot::after {
    content: ''; position: absolute; inset: 3px; border-radius: 50%; background: #74ac43;
    opacity: 0; transform: scale(0.4); transition: all 0.18s;
}
.kcc-selected .kcc-dot             { border-color: #74ac43; }
.kcc-selected .kcc-dot::after      { opacity: 1; transform: scale(1); }
.kcc-name     { font-size: 14px; color: rgba(255,255,255,0.65); transition: color 0.18s; }
.kcc-name em  { font-style: normal; color: rgba(255,255,255,0.3); font-size: 12px; }
.kcc-selected .kcc-name { color: var(--white); font-weight: 500; }

/* Or-pills */
.kids-or-opts { display: flex; gap: 8px; margin-bottom: 20px; }
.kids-or-pill {
    flex: 1; padding: 11px 12px; text-align: center;
    border: 1px solid rgba(255,255,255,0.1); border-radius: 8px;
    cursor: pointer; font-size: 13px; color: rgba(255,255,255,0.55); transition: all 0.18s;
}
.kids-or-pill:hover  { border-color: rgba(116,172,67,0.35); color: var(--white); }
.kids-or-pill.active { border-color: rgba(116,172,67,0.55); background: rgba(116,172,67,0.09);
                        color: var(--white); font-weight: 500; }

/* Count row */
.kids-count-row {
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 10px; padding: 14px 16px; margin-bottom: 16px;
}
.kids-count-main { font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 2px; }
.kids-count-hint { font-size: 11px; color: rgba(255,255,255,0.3); }
.kids-counter    { display: flex; align-items: center; gap: 14px; }
.kids-counter-btn {
    width: 32px; height: 32px; border-radius: 8px; border: 1px solid rgba(116,172,67,0.35);
    background: rgba(116,172,67,0.08); color: #74ac43; font-size: 18px;
    display: flex; align-items: center; justify-content: center; cursor: pointer;
    transition: background 0.18s; flex-shrink: 0;
}
.kids-counter-btn:hover    { background: rgba(116,172,67,0.22); }
.kids-counter-btn:disabled { opacity: 0.35; pointer-events: none; }
.kids-counter-val { font-size: 20px; color: var(--white); font-weight: 500; min-width: 28px; text-align: center; }

/* Price preview */
.kids-price-preview {
    display: flex; justify-content: space-between; align-items: center;
    padding: 13px 16px; background: rgba(116,172,67,0.06);
    border: 1px solid rgba(116,172,67,0.2); border-radius: 10px; margin-bottom: 14px;
}
.kids-preview-label     { font-size: 12px; color: rgba(255,255,255,0.4); margin-bottom: 3px; }
.kids-preview-breakdown { font-size: 11px; color: rgba(255,255,255,0.3); }
.kids-preview-total     { font-size: 20px; color: #74ac43; font-weight: 600;
                           font-family: 'Cormorant Garamond', serif; }
.kids-note-text { font-size: 12px; color: rgba(255,255,255,0.3); line-height: 1.6; margin-bottom: 20px; }

/* Footer */
.kids-modal-foot {
    padding: 14px 24px 24px; display: flex; gap: 10px; flex-shrink: 0;
    background: linear-gradient(to top, rgba(22,18,18,1) 50%, transparent);
}
.kids-btn-back {
    display: inline-flex; align-items: center; gap: 7px; padding: 12px 18px;
    border: 1px solid rgba(255,255,255,0.15); border-radius: 10px;
    background: transparent; color: rgba(255,255,255,0.5); font-size: 13px;
    cursor: pointer; transition: all 0.18s;
}
.kids-btn-back:hover { border-color: rgba(255,255,255,0.3); color: var(--white); }
.kids-btn-confirm {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 13px 20px; background: rgba(116,172,67,0.55);
    color: #e8e8e8; font-size: 14px; font-weight: 600; letter-spacing: 0.04em;
    border: none; border-radius: 10px; cursor: pointer; transition: all 0.2s;
}
.kids-btn-confirm:hover    { background: rgba(116,172,67,0.75); transform: translateY(-1px); }
.kids-btn-confirm:disabled { opacity: 0.4; pointer-events: none; }

@media (max-width: 480px) {
    .kids-modal-body { padding: 16px 18px 0; }
    .kids-modal-foot { padding: 12px 18px 22px; flex-direction: column; }
    .kids-addon-banner { flex-wrap: wrap; gap: 12px; }
    .kids-addon-cta { width: 100%; text-align: center; }
}
.mn-addon {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.mn-addon-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px; 
}

.addon-qty-controls {
    display: flex;
    align-items: center;
    border: 0.5px solid #aaa;
    border-radius: 8px;
    overflow: hidden;
}

.addon-qty-btn {
    width: 30px;
    height: 36px;
    border: none;
    background: white;
    font-size: 18px;
    cursor: pointer;
}

.addon-qty-btn:disabled {
    opacity: 0.35;
    cursor: not-allowed;
}

.addon-qty-divider1 {
    width: 1px;
    height: 20px;
    background: #272727;
    flex-shrink: 0;
}

.addon-qty-divider {
    width: 1px;
    height: 20px;
    background: #272727;
    flex-shrink: 0;
}

.addon-qty-input {
    width: 40px;
    height: 36px;
    border: none;
    background: white;
    text-align: center;
    font-size: 14px;
    font-weight: 500;
    padding: 0;
    margin: 0;
    outline: none;
    -moz-appearance: textfield;
}

.addon-qty-input::-webkit-outer-spin-button,
.addon-qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

.mn-addon-price {
    white-space: nowrap;
}
</style>

@endsection

