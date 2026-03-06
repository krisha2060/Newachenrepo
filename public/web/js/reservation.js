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

   
    // Initialize variables for addons
   
    let selectedAddons = []; 

   
    // Set today's date as minimum
   
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;
    dateInput.value = today;

   
    // Show catering section by default
   
    cateringSection.style.display = 'block';
    cateringFields.style.display = 'block';

   
    // Package Selection
   
    packageButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Get package name and base price
            const packageId = this.dataset.id; 
            const packageName = this.dataset.package;
            const packagePrice = parseFloat(this.dataset.price);

            // Update selected package info display
            selectedInfo.innerHTML = `
                <span class="info-label">
                    <strong>Selected:</strong> ${packageName} - $${packagePrice.toFixed(2)} per person
                </span>
            `;

            // Update hidden form inputs
            selectedPackageInput.value = packageId;
            packagePriceInput.value = packagePrice.toFixed(2);

            // Reset selected add-ons
            selectedAddons = [];
            addons.forEach(addon => {
               addon.classList.remove('selected');
                const tag = addon.querySelector('.addon-tag');
                if(tag) tag.remove();
            });

            // Set guests to minimum 15
            guestsInput.value = 15;

           
            packageButtons.forEach(btn => {
                btn.style.background = 'transparent';
                btn.style.color = 'var(--accent-gold)';
            });
            this.style.background = 'var(--accent-gold)';
            this.style.color = 'var(--dark-bg)';

            
            setTimeout(() => {
                document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);

            // Update total price display
            updateTotalPrice();
            document.getElementById('selectedPackageIdInput').value = packageId;

        });
    });


    function showToast(message, type = 'info', duration = 3000) {
    const colors = {
        info: '#17a2b8',
        success: '#28a745',
        warning: '#ffc107',
        error: '#dc3545'
    };

    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.position = 'fixed';
    toast.style.top = '20%';
    toast.style.left = '50%';
    toast.style.transform = 'translate(-50%, -50%)';
    toast.style.background = colors[type] || colors.info;
    toast.style.color = '#fff';
    toast.style.padding = '12px 20px';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
    toast.style.zIndex = 9999;
    toast.style.fontFamily = 'sans-serif';
    toast.style.fontSize = '16px';
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s, transform 0.3s';

    document.body.appendChild(toast);

    // animate in
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translate(-50%, -50%) scale(1)';
    }, 10);

    // hide after duration
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translate(-50%, -50%) scale(0.9)';
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

   
    // Add-on Selection / Price Update
   
    addons.forEach(addon => {
        addon.addEventListener('click', function() {
     
    if (!selectedPackageInput.value) {
        showToast("Please select a package first!", "warning"); 
        return; // stop addon selection
    }
  // Get addon name and price from dataset
            const addonName = this.dataset.name;
            const addonPrice = parseFloat(this.dataset.price);

            if(this.classList.contains('selected')) {
                // Deselect addon
                this.classList.remove('selected');
                const tag = this.querySelector('.addon-tag');
                if(tag) tag.remove();
                selectedAddons = selectedAddons.filter(a => a.name !== addonName);
            } else {
                // Select addon
                this.classList.add('selected');
                const tag = document.createElement('span');
               tag.classList.add('addon-tag');
            tag.innerText = 'Selected';
                //this.appendChild(tag);
                selectedAddons.push({ name: addonName, price: addonPrice });                   }
               // document.getElementById('addonsInput').value = JSON.stringify(selectedAddons);

            updateTotalPrice();
        });
    });

   
  
   
  // Update total price function
function updateTotalPrice() {
    const basePrice = parseFloat(packagePriceInput.value) || 0;

    // Determine number of guests
    let guests = parseInt(guestsInput.value) || 15;
    if(guests < 15) guests = 15; // minimum guests

    // Total addons per person
    const addonsTotal = selectedAddons.reduce((sum, a) => sum + a.price, 0);

    // Total per person
    const totalPerPerson = basePrice + addonsTotal;

    // Total overall
    const total = totalPerPerson * guests;

    // Update display
    selectedInfo.innerHTML = `
        <span class="info-label">
            <strong>Selected:</strong> ${selectedPackageInput.value} - $${basePrice.toFixed(2)} per person
            ${selectedAddons.length ? '<br><small>Add-ons: ' + selectedAddons.map(a=>a.name).join(', ') + '</small>' : ''}
            <br><strong>Guests:</strong> ${guests}
            <br><strong>Total:</strong> $${total.toFixed(2)}
        </span>
    `;

    //  Update hidden inputs
    document.getElementById('addonsInput').value = JSON.stringify(selectedAddons);
    document.getElementById('totalPriceInput').value = total.toFixed(2);
}

// Guests input validation
guestsInput.addEventListener('blur', function() {
    const value = parseInt(this.value);
    if (value < 15 || isNaN(value)) {
        this.setCustomValidity("For catering events, minimum 15 guests are required");
        this.reportValidity();
       // this.value = 15;
    } else {
        this.setCustomValidity("");
    }
    updateTotalPrice(); 
});
guestsInput.addEventListener('input', updateTotalPrice);

   
    // Guests input validation (min 15) 
   
    guestsInput.addEventListener('blur', function() {
        const value = parseInt(this.value);
        if (value < 15 || isNaN(value)) {
            this.setCustomValidity("For catering events, minimum 15 guests are required");
            this.reportValidity(); 
           // this.value = 15; 
        } else {
            this.setCustomValidity("");
        }
        updateTotalPrice();
        document.getElementById('addonsInput').value = JSON.stringify(selectedAddons);
document.getElementById('totalPriceInput').value = total.toFixed(2);
    });

   
    // Recalculate total if guests change manually
   
    guestsInput.addEventListener('input', updateTotalPrice);

  
      flatpickr(".theme-date", {
      dateFormat: "Y-m-d" ,
      minDate: "today" 
  });
  flatpickr("#time", {
      enableTime: true,  
      noCalendar: true,   
      dateFormat: "H:i",  
      time_24hr: true
  });

 
// AJAX form submission

form.addEventListener('submit', function(e) {
    e.preventDefault(); 
       const guestsValue = parseInt(guestsInput.value);
    if(guestsValue < 15 || isNaN(guestsValue)) {
        showToast('For catering events, minimum 15 guests are required', 'warning');
        guestsInput.focus();
        return;
    }

    const formData = new FormData(form); 

    // fetch(form.action, {
    //     method: 'POST',
    //     body: formData,
    //     headers: {
    //         'X-Requested-With': 'XMLHttpRequest',
    //     }
    // })
    // .then(response => response.json())
    // .then(data => {
    //     if(data.message) {
    //         showToast(data.message, 'success');
    //         setTimeout(() => {
    //         location.reload();
    //     }, 3000); // show success toast
    //         // form.reset(); // optional: clear form
    //         // selectedInfo.innerHTML = ''; // optional: reset selected package/addons
    //         // selectedAddons = []; // reset addon array
    //     }
    // })
    // .catch(error => {
    //     console.error(error);
    //     showToast("Something went wrong!", 'error'); // show error toast
    // });



    //new display 
    fetch(form.action, {
    method: 'POST',
    body: formData,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }
})
.then(response => response.json())
.then(data => {
   
    let orderInfo = `Customer: ${data.order_details.customer_name}\n` +
                    `Guests: ${data.order_details.guest_count}\n` +
                    `Package Total: $${data.order_details.package_total}\n` +
                    `Addon Total: $${data.order_details.addon_total}\n` +
                    `Grand Total: $${data.order_details.grand_total}\n`+
                    `Event Venue: ${data.event_venue}\n`+
                    `Event Date: ${data.event_date}\n` +
                    `Event Time: ${data.event_time}\n` ;


                    if(data.notes && data.notes.trim() !== ''){
                        orderInfo += `Special Requests: ${data.notes}\n`;
                    }

    if(data.addons && data.addons.length > 0){
        orderInfo += '\nAddons:\n';
        data.addons.forEach(a => {
            orderInfo += ` - ${a.item_name}: $${a.total_price}\n`;
        });
    }

   
    const modal = document.getElementById('orderConfirmationModal');
    const content = document.getElementById('orderConfirmationContent');
    const closeBtn = document.getElementById('closeConfirmationBtn');

   content.innerHTML = orderInfo.replace(/\n/g, "<br>"); 
    modal.style.display = 'flex';     

    
    closeBtn.onclick = () => { modal.style.display = 'none'; location.reload(); }

    
    modal.onclick = (e) => {
        if(e.target === modal) modal.style.display = 'none';
        location.reload(); 
    };

})
.catch(err => {
    console.error(err);
    showToast("Something went wrong!", 'error'); 
});
//end of new display
});

  
});
