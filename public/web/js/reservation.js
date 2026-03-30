document.addEventListener('DOMContentLoaded', function() {

    const cateringSection = document.getElementById('cateringSection');
    const cateringFields = document.getElementById('cateringFields');
    const packageButtons = document.querySelectorAll('.select-btn, .select-btn-small');
    const addons = document.querySelectorAll('.mn-addon');
    const selectedInfo = document.getElementById('selectedInfo');
    const selectedPackageInput = document.getElementById('selectedPackageInput');
    const packagePriceInput = document.getElementById('packagePriceInput');
    const guestsInput = document.getElementById('guests');
    const dateInput = document.getElementById('date');
    const form = document.getElementById('reservationForm');

    let selectedAddons = [];

    // Set today's date as minimum
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;
    dateInput.value = today;

    // Show catering section by default
    cateringSection.style.display = 'block';
    cateringFields.style.display = 'block';

    // ─── Toast ────────────────────────────────────────────────
    function showToast(message, type = 'info', duration = 3000) {
        const colors = { info: '#17a2b8', success: '#28a745', warning: '#d4a017', error: '#dc3545' };
        const toast = document.createElement('div');
        toast.textContent = message;
        Object.assign(toast.style, {
            position: 'fixed', top: '20%', left: '50%',
            transform: 'translate(-50%, -50%)',
            background: colors[type] || colors.info,
            color: '#fff', padding: '12px 24px',
            borderRadius: '8px', boxShadow: '0 4px 20px rgba(0,0,0,0.4)',
            zIndex: 99999, fontFamily: 'sans-serif', fontSize: '15px',
            opacity: '0', transition: 'opacity 0.3s, transform 0.3s'
        });
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '1'; }, 10);
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    // ─── Group Item Selection Modal ───────────────────────────
    function openGroupSelectionModal(packageId, packageName, packagePrice, onConfirm) {
        const allData = window.allPackagesData || [];
        const pkg = allData.find(p => String(p.id) === String(packageId));

        if (!pkg) { onConfirm([], {}); return; }

        const groups = pkg.items.map((item) => {
            const options = item.label.split(' or ').map(s => s.trim()).filter(Boolean);
            return { group_id: item.group_id, label: item.label, options };
        });

        const choiceGroups = groups.filter(g => g.options.length > 1);
        const singleGroups = groups.filter(g => g.options.length === 1);

        if (choiceGroups.length === 0) {
            const singleSelections = {};
            singleGroups.forEach(g => { singleSelections[g.group_id] = g.options[0]; });
            onConfirm(singleGroups.map(g => g.options[0]), singleSelections);
            return;
        }

        let html = `
            <div class="gsm-header">
                <div class="gsm-package-badge">${packageName}</div>
                <h3 class="gsm-title">Personalise Your Menu</h3>
                <p class="gsm-subtitle">Select one option from each section below</p>
            </div>
            <div class="gsm-groups">
        `;

        choiceGroups.forEach((group, i) => {
            html += `
                <div class="gsm-group" data-group-index="${group.group_id}">
                    <div class="gsm-group-label">
                        <span class="gsm-group-number">${String(i + 1).padStart(2, '0')}</span>
                        <span class="gsm-group-text">Choose one</span>
                    </div>
                    <div class="gsm-options">
                        ${group.options.map((opt, j) => `
                            <label class="gsm-option" data-group="${group.group_id}" data-value="${opt}">
                                <input type="radio" name="gsm_group_${group.group_id}" value="${opt}" ${j === 0 ? 'checked' : ''}>
                                <span class="gsm-option-inner">
                                    <span class="gsm-radio-dot"></span>
                                    <span class="gsm-option-name">${opt}</span>
                                </span>
                            </label>
                        `).join('')}
                    </div>
                </div>
            `;
        });

        if (singleGroups.length > 0) {
            html += `
                <div class="gsm-included">
                    <div class="gsm-included-title"><i class="fas fa-check-circle"></i> Also included</div>
                    <div class="gsm-included-items">
                        ${singleGroups.map(g => `<span class="gsm-chip">${g.options[0]}</span>`).join('')}
                    </div>
                </div>
            `;
        }

        html += `</div>`;

        const modal      = document.getElementById('groupSelectionModal');
        const body       = modal.querySelector('.gsm-body');
        const confirmBtn = modal.querySelector('#gsmConfirmBtn');
        const closeBtn   = modal.querySelector('#gsmCloseBtn');

        body.innerHTML = html;
        modal.classList.add('gsm-active');
        document.body.style.overflow = 'hidden';

        body.querySelectorAll('.gsm-option input:checked').forEach(inp => {
            inp.closest('.gsm-option').classList.add('gsm-selected');
        });

        body.querySelectorAll('.gsm-option input[type=radio]').forEach(radio => {
            radio.addEventListener('change', function () {
                const groupId = this.closest('.gsm-group').dataset.groupIndex;
                body.querySelectorAll(`.gsm-option[data-group="${groupId}"]`).forEach(el => el.classList.remove('gsm-selected'));
                this.closest('.gsm-option').classList.add('gsm-selected');
            });
        });

        const handleConfirm = () => {
            const selections = {};
            const selectedNames = [];
            choiceGroups.forEach(group => {
                const checked = body.querySelector(`input[name="gsm_group_${group.group_id}"]:checked`);
                if (checked) { selections[group.group_id] = checked.value; selectedNames.push(checked.value); }
            });
            singleGroups.forEach(g => { selections[g.group_id] = g.options[0]; selectedNames.push(g.options[0]); });
            closeGsmModal();
            onConfirm(selectedNames, selections);
        };

        const closeGsmModal = () => {
            modal.classList.remove('gsm-active');
            document.body.style.overflow = '';
            confirmBtn.removeEventListener('click', handleConfirm);
            closeBtn.removeEventListener('click', closeGsmModal);
        };

        confirmBtn.addEventListener('click', handleConfirm);
        closeBtn.addEventListener('click', closeGsmModal);
        modal.addEventListener('click', function handler(e) {
            if (e.target === modal) { closeGsmModal(); modal.removeEventListener('click', handler); }
        });
    }

    // ─── Package Selection ────────────────────────────────────
    packageButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const packageId    = this.dataset.id;
            const packageName  = this.dataset.package;
            const packagePrice = parseFloat(this.dataset.price);
            const clickedBtn   = this;

            openGroupSelectionModal(packageId, packageName, packagePrice, function (selectedNames, selections) {
                document.getElementById('groupSelectionInput').value      = JSON.stringify(selections);
                document.getElementById('selectedPackageNameInput').value = packageName;
                selectedPackageInput.value                                = packageId;
                packagePriceInput.value                                   = packagePrice.toFixed(2);
                document.getElementById('selectedPackageIdInput').value   = packageId;

                selectedInfo.innerHTML = `
                    <span class="info-label">
                        <strong>Selected:</strong> ${packageName} — $${packagePrice.toFixed(2)} per person
                        ${selectedNames.length ? '<br><small style="color:var(--accent-gold);opacity:.8;">Menu: ' + selectedNames.join(', ') + '</small>' : ''}
                    </span>
                `;

                selectedAddons = [];
                addons.forEach(addon => {
                    addon.classList.remove('selected');
                    const tag = addon.querySelector('.addon-tag');
                    if (tag) tag.remove();
                });

                guestsInput.value = 15;

                packageButtons.forEach(btn => { btn.style.background = 'transparent'; btn.style.color = 'var(--accent-gold)'; });
                clickedBtn.style.background = 'var(--accent-gold)';
                clickedBtn.style.color      = 'var(--dark-bg)';

                updateTotalPrice();

                setTimeout(() => {
                    document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 350);
            });
        });
    });

    // ─── Add-on Selection ─────────────────────────────────────
    addons.forEach(addon => {
        addon.addEventListener('click', function () {
            if (!selectedPackageInput.value) { showToast("Please select a package first!", "warning"); return; }
            const addonName  = this.dataset.name;
            const addonPrice = parseFloat(this.dataset.price);

            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                const tag = this.querySelector('.addon-tag');
                if (tag) tag.remove();
                selectedAddons = selectedAddons.filter(a => a.name !== addonName);
            } else {
                this.classList.add('selected');
                selectedAddons.push({ name: addonName, price: addonPrice });
            }
            updateTotalPrice();
        });
    });

    // ─── Pickup / Delivery Toggle ─────────────────────────────
    const pdtBtns            = document.querySelectorAll('.pdt-btn');
    const addressBlock       = document.getElementById('addressshow');
    const deliveryTypeInput  = document.getElementById('deliveryTypeInput');
    const deliveryChargeNote = document.getElementById('deliveryChargeNote');
    const eventAddressInput  = document.getElementById('event_address');

    eventAddressInput.value = 'Self Pickup';

    pdtBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            pdtBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const type = this.dataset.type;
            deliveryTypeInput.value = type;
            if (type === 'delivery') {
                addressBlock.style.display = 'block';
                eventAddressInput.value    = '';
            } else {
                addressBlock.style.display = 'none';
                if (deliveryChargeNote) deliveryChargeNote.style.display = 'none';
                eventAddressInput.value    = 'Self Pickup';
            }
        });
    });

    // ─── Update Total Price ───────────────────────────────────
    function updateTotalPrice() {
        const basePrice   = parseFloat(packagePriceInput.value) || 0;
        let guests        = parseInt(guestsInput.value) || 15;
        if (guests < 15) guests = 15;

        const addonsTotal    = selectedAddons.reduce((sum, a) => sum + a.price, 0);
        const totalPerPerson = basePrice + addonsTotal;
        const total          = totalPerPerson * guests;

        const packageId = selectedPackageInput.value;
        const pkgName   = packageId
            ? (document.querySelector(`.select-btn[data-id="${packageId}"], .select-btn-small[data-id="${packageId}"]`)?.dataset?.package || packageId)
            : packageId;

        if (packageId) {
            selectedInfo.innerHTML = `
                <span class="info-label">
                    <strong>Selected:</strong> ${pkgName} — $${basePrice.toFixed(2)} per person
                    ${selectedAddons.length ? '<br><small style="color:var(--accent-gold);opacity:.8;">Add-ons: ' + selectedAddons.map(a => a.name).join(', ') + '</small>' : ''}
                    <br><strong>Guests:</strong> ${guests}
                    <br><strong>Total:</strong> $${total.toFixed(2)}
                </span>
            `;
        }

        document.getElementById('addonsInput').value    = JSON.stringify(selectedAddons);
        document.getElementById('totalPriceInput').value = total.toFixed(2);
    }

    // ─── Guests Validation ────────────────────────────────────
    guestsInput.addEventListener('blur', function () {
        const value = parseInt(this.value);
        if (value < 15 || isNaN(value)) {
            this.setCustomValidity("For catering events, minimum 15 guests are required");
            this.reportValidity();
        } else {
            this.setCustomValidity("");
        }
        updateTotalPrice();
    });
    guestsInput.addEventListener('input', updateTotalPrice);

    // ─── Flatpickr ────────────────────────────────────────────
    flatpickr(".theme-date", { dateFormat: "Y-m-d", minDate: "today", disableMobile: true });
    flatpickr("#time", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true, disableMobile: true });


    // ═══════════════════════════════════════════════════════════
    //  ORDER REVIEW MODAL
    //  Built from form data client-side — no extra backend call.
    //  "OK, Place Order" → single POST → success toast → reload.
    // ═══════════════════════════════════════════════════════════

    document.body.insertAdjacentHTML('beforeend', `
        <div id="orderReviewModal" class="orv-overlay">
            <div class="orv-modal">
                <button class="orv-x-close" id="orvCloseBtn" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="orv-body" id="orvBody"></div>
                <div class="orv-footer">
                    <button type="button" class="orv-back-btn" id="orvBackBtn">
                        <i class="fas fa-arrow-left"></i><span>Back</span>
                    </button>
                    <button type="button" class="orv-confirm-btn" id="orvConfirmBtn">
                        <span>OK, Place Order</span>
                        <i class="fas fa-check"></i>
                        <div class="orv-spinner"></div>
                    </button>
                </div>
            </div>
        </div>
    `);

    const reviewStyles = document.createElement('style');
    reviewStyles.textContent = `
        .orv-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(0,0,0,0.8); backdrop-filter:blur(7px);
            z-index:200000; align-items:center; justify-content:center; padding:20px;
        }
        .orv-overlay.orv-active { display:flex; animation:orvFadeIn 0.22s ease; }
        @keyframes orvFadeIn { from{opacity:0} to{opacity:1} }

        .orv-modal {
            position:relative;
            background: linear-gradient(160deg, #181111 0%, #1c1010 100%);;
            border:1px solid rgba(124, 212, 23, 0.28); border-radius:20px;
            width:100%; max-width:500px; max-height:88vh;
            display:flex; flex-direction:column;
            box-shadow:0 30px 80px rgba(0,0,0,0.65),0 0 0 1px rgba(124, 212, 23, 0.1);
            animation:orvSlideUp 0.3s cubic-bezier(0.34,1.56,0.64,1); overflow:hidden;
        }
        @keyframes orvSlideUp {
            from{transform:translateY(28px) scale(0.96);opacity:0}
            to{transform:translateY(0) scale(1);opacity:1}
        }
        .orv-x-close {
            position:absolute; top:15px; right:15px;
            width:33px; height:33px; border-radius:50%;
            border:1px solid rgba(149, 212, 23, 0.28); background:rgba(149, 212, 23, 0.07);
            color:rgba(165, 212, 23, 0.7); cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            font-size:13px; transition:all 0.2s; z-index:2;
        }
        .orv-x-close:hover { background:rgba(212,160,23,0.2); color:#d4a017; transform:rotate(90deg); }

        .orv-body {
            overflow-y:auto; flex:1; padding:28px 28px 8px;
            scrollbar-width:thin; scrollbar-color:rgba(152, 212, 23, 0.3) transparent;
        }
        .orv-body::-webkit-scrollbar{width:4px}
        .orv-body::-webkit-scrollbar-thumb{background:rgba(161, 212, 23, 0.3);border-radius:4px}

        .orv-badge {
            display:inline-block; font-size:11px; font-weight:700;
            letter-spacing:0.12em; text-transform:uppercase;
            color:#74ac43; background:rgba(139, 212, 23, 0.12);
            border:1px solid rgba(158, 212, 23, 0.25);
            padding:4px 12px; border-radius:20px; margin-bottom:10px;
        }
        .orv-title    { font-size:22px; font-weight:700; color:#fff; margin:0 0 4px; }
        .orv-subtitle { font-size:13px; color:rgba(255,255,255,0.4); margin:0 0 18px; }

        .orv-table {
            display:flex; flex-direction:column;
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(255,255,255,0.07);
            border-radius:14px; overflow:hidden; margin-bottom:22px;
        }
        .orv-row {
            display:flex; justify-content:space-between; align-items:flex-start;
            padding:11px 16px; gap:16px;
            border-bottom:1px solid rgba(255,255,255,0.05); font-size:13.5px;
        }
        .orv-row:last-child { border-bottom:none; }
        .orv-head {
            padding:7px 16px !important;
            font-size:10px !important; font-weight:700 !important;
            letter-spacing:0.1em; text-transform:uppercase;
            color:rgba(255,255,255,0.28); background:rgba(255,255,255,0.02);
            border-bottom:1px solid rgba(255,255,255,0.05);
        }
        .orv-total {
            background:#6bc71b1a;
                border-top: 1px solid rgba(133, 212, 23, 0.2) !important;
        }
        .orv-lbl { color:rgba(255,255,255,0.45); font-weight:500; white-space:nowrap; flex-shrink:0; }
        .orv-val  { color:rgba(255,255,255,0.88); font-weight:500; text-align:right; word-break:break-word; }
        .orv-total .orv-lbl, .orv-total .orv-val {
    color: #74ac43;
    font-weight: 700;
    font-size: 14px;
}

        .orv-footer {
            padding:16px 28px 24px; display:flex; gap:12px; flex-shrink:0;
            background:linear-gradient(to top,rgba(28,16,16,1) 60%,transparent);
        }
        .orv-back-btn {
            flex:0 0 auto; display:flex; align-items:center; gap:7px;
            padding:13px 20px; border:1.5px solid rgba(255,255,255,0.15);
            border-radius:12px; background:transparent;
            color:rgba(255,255,255,0.55); font-size:14px; font-weight:600;
            cursor:pointer; transition:all 0.18s;
        }
        .orv-back-btn:hover { border-color:rgba(255,255,255,0.35); color:#fff; }

        .orv-confirm-btn {
            flex:1; display:flex; align-items:center; justify-content:center; gap:10px;
            padding:13px 20px;
            background: #74ac438c;
            color:#e7e6e6; font-size:15px; font-weight:700; letter-spacing:0.04em;
            border:none; border-radius:12px; cursor:pointer;
            transition:transform 0.15s,box-shadow 0.2s;
            box-shadow:0 4px 20px rgba(34, 55, 14, 0.2);
        }
        .orv-confirm-btn:hover  {transform: translateY(-2px);
    box-shadow: 0 8px 30px #347e0973;}
        .orv-confirm-btn:active { transform:translateY(0); }
        .orv-confirm-btn:disabled { opacity:0.6; pointer-events:none; }

        .orv-spinner {
            width:16px; height:16px; border-radius:50%;
            border:2px solid rgba(255,255,255,0.3); border-top-color:#fff;
            animation:orvSpin 0.7s linear infinite; display:none; flex-shrink:0;
        }
        @keyframes orvSpin { to{transform:rotate(360deg)} }
        .orv-confirm-btn.orv-loading .orv-spinner  { display:block; }
        .orv-confirm-btn.orv-loading span,
        .orv-confirm-btn.orv-loading .fa-check      { display:none; }

        @media(max-width:480px){
            .orv-body   { padding:20px 18px 8px; }
            .orv-footer { padding:14px 18px 22px; flex-direction:column; }
            .orv-back-btn { width:100%; justify-content:center; }
        }
    `;
    document.head.appendChild(reviewStyles);

    // ── refs ──────────────────────────────────────────────────
    const reviewOverlay = document.getElementById('orderReviewModal');
    const orvBody       = document.getElementById('orvBody');
    const orvBackBtn    = document.getElementById('orvBackBtn');
    const orvCloseBtn   = document.getElementById('orvCloseBtn');
    const orvConfirmBtn = document.getElementById('orvConfirmBtn');

    const openReview  = () => { reviewOverlay.classList.add('orv-active');    document.body.style.overflow = 'hidden'; };
    const closeReview = () => { reviewOverlay.classList.remove('orv-active'); document.body.style.overflow = ''; };

    orvBackBtn.addEventListener('click', closeReview);
    orvCloseBtn.addEventListener('click', closeReview);
    reviewOverlay.addEventListener('click', e => { if (e.target === reviewOverlay) closeReview(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && reviewOverlay.classList.contains('orv-active')) closeReview();
    });

    // ── Build review table from form data ─────────────────────
    function buildReviewHTML() {
        const get = id => (document.getElementById(id)?.value || '').trim();

        const packageName  = get('selectedPackageNameInput');
        const packagePrice = parseFloat(get('packagePriceInput')) || 0;
        const guests       = parseInt(get('guests')) || 0;
        const packageTotal = packagePrice * guests;
        const addonsTotal  = selectedAddons.reduce((s, a) => s + a.price * guests, 0);
        const grandTotal   = packageTotal + addonsTotal;

        // Menu choices from hidden group-selection input
        let menuItems = '';
        try {
            const names = Object.values(JSON.parse(get('groupSelectionInput') || '{}')).filter(Boolean);
            if (names.length) menuItems = names.join(', ');
        } catch(e) {}

        const deliveryType = get('deliveryTypeInput');
        const venue        = deliveryType === 'delivery' ? (get('event_address') || '—') : 'Self Pickup';

        // Friendly date
        const rawDate = get('date');
        let niceDate = rawDate;
        try {
            if (rawDate) niceDate = new Date(rawDate + 'T00:00').toLocaleDateString('en-AU', {
                weekday:'short', day:'numeric', month:'long', year:'numeric'
            });
        } catch(e) {}

        // Helpers
        const row  = (lbl, val) => (!val && val !== 0) ? '' :
            `<div class="orv-row"><span class="orv-lbl">${lbl}</span><span class="orv-val">${val}</span></div>`;
        const head = lbl =>
            `<div class="orv-row orv-head">${lbl}</div>`;
        const tot  = (lbl, val) =>
            `<div class="orv-row orv-total"><span class="orv-lbl">${lbl}</span><span class="orv-val">${val}</span></div>`;

        return `
            <div class="orv-badge">Review Order</div>
            <h2 class="orv-title">Confirm Your Reservation</h2>
            <p class="orv-subtitle">Please review your details before placing the order.</p>
            <div class="orv-table">

                ${head('Customer Details')}
                ${row('Name',  get('name'))}
                ${row('Email', get('email'))}
                ${row('Phone', get('phone'))}

                ${head('Event Details')}
                ${row('Date',   niceDate)}
                ${row('Time',   get('time'))}
                ${row('Guests', guests)}
                ${row('Venue',  venue)}

                ${head('Package')}
                ${row('Selected',       packageName)}
                ${row('Price per head', '$' + packagePrice.toFixed(2))}
                ${menuItems ? row('Your menu', menuItems) : ''}

                ${selectedAddons.length ? head('Add-ons') : ''}
                ${selectedAddons.map(a =>
                    row(a.name, `$${(a.price * guests).toFixed(2)} <small style="opacity:.5">(${guests} × $${a.price})</small>`)
                ).join('')}

                ${get('special_requests') ? head('Special Requests') : ''}
                ${get('special_requests') ? row('Notes', get('special_requests')) : ''}

                ${head('Pricing Summary')}
                ${row('Package total', '$' + packageTotal.toFixed(2))}
                ${addonsTotal ? row('Add-ons total', '$' + addonsTotal.toFixed(2)) : ''}
                ${tot('Grand Total <small style="font-weight:400;font-size:10px;opacity:.55">(excl. GST)</small>',
                      '$' + grandTotal.toFixed(2))}
            </div>
        `;
    }

    // ─── Form submit → show review (no network call) ──────────
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const guestsValue = parseInt(guestsInput.value);
        if (guestsValue < 15 || isNaN(guestsValue)) {
            showToast('For catering events, minimum 15 guests are required', 'warning');
            guestsInput.focus();
            return;
        }
        if (!selectedPackageInput.value) {
            showToast('Please select a package first!', 'warning');
            return;
        }

        orvBody.innerHTML = buildReviewHTML();
        openReview();
    });

    // ─── "OK, Place Order" → POST to backend ──────────────────
    orvConfirmBtn.addEventListener('click', function () {
        orvConfirmBtn.classList.add('orv-loading');
        orvConfirmBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(() => {
            closeReview();

            // Hide the old order-confirmed modal if it somehow fires
            const oldModal = document.getElementById('orderConfirmationModal');
            if (oldModal) oldModal.style.display = 'none';

            showToast(' Reservation confirmed! We\'ll be in touch soon.', 'success', 3500);
            setTimeout(() => location.reload(), 2800);
        })
        .catch(err => {
            console.error(err);
            orvConfirmBtn.classList.remove('orv-loading');
            orvConfirmBtn.disabled = false;
            showToast('Something went wrong. Please try again.', 'error');
        });
    });
    

 let pkgSwiper = null;
let occSwiper = null;

function initMobileSwipers() {
    if (window.innerWidth < 768) {
        if (!pkgSwiper) {
            pkgSwiper = new Swiper('.mn-packages-swiper', {
                slidesPerView: 1.18,
                spaceBetween: 10,
                centeredSlides: true,
                grabCursor: true,
                pagination: { el: '.mn-pkg-pagination', clickable: true },
                on: {
                    // Auto-advance once on load so user sees peek of next card
                    init: function () {
                        const sw = this;
                        setTimeout(() => {
                            sw.slideNext(400);
                            setTimeout(() => sw.slidePrev(400), 800);
                        }, 600);
                    }
                }
            });
        }
        if (!occSwiper) {
            occSwiper = new Swiper('.mn-occasions-swiper', {
                slidesPerView: 1.18,
                spaceBetween: 10,
                centeredSlides: true,
                grabCursor: true,
                pagination: { el: '.mn-occ-pagination', clickable: true },
                on: {
                    init: function () {
                        const sw = this;
                        setTimeout(() => {
                            sw.slideNext(400);
                            setTimeout(() => sw.slidePrev(400), 800);
                        }, 1000);
                    }
                }
            });
        }
    }
}

    initMobileSwipers();
    window.addEventListener('resize', initMobileSwipers);

});
