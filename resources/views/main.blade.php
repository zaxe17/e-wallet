<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayNoy - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="m-0 p-0 h-screen">

    @yield('content')

</body>

</html>

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('accountForm');
    const fields = form.querySelectorAll('input[required], select[required]');
    let formSubmitted = false;

    function validateField(field) {
        const parent = field.closest('.flex-col');
        const errorMsg = parent.querySelector('.error-msg');

        let valid = false;

        if (field.type === 'radio') {
            const name = field.name;
            valid = form.querySelector(`input[name="${name}"]:checked`) !== null;
        } else if (field.tagName.toLowerCase() === 'select') {
            valid = field.value.trim() !== '';
        } else {
            valid = field.value.trim() !== '';
        }

        if (formSubmitted) {
            if (!valid) {
                field.classList.add('ring-2', 'ring-red-500');
                field.classList.remove('ring-emerald-500');
                errorMsg?.classList.remove('hidden');
            } else {
                field.classList.remove('ring-red-500');
                field.classList.add('ring-2', 'ring-emerald-500');
                errorMsg?.classList.add('hidden');
            }
        } else {
            field.classList.remove('ring-red-500', 'ring-emerald-500');
            errorMsg?.classList.add('hidden');
        }
    }

    fields.forEach(field => {
        if (field.type !== 'radio') {
            field.addEventListener('input', () => validateField(field));
            field.addEventListener('change', () => validateField(field));
        } else {
            const name = field.name;
            const radios = form.querySelectorAll(`input[name="${name}"]`);
            radios.forEach(r => r.addEventListener('change', () => validateField(field)));
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        formSubmitted = true;
        fields.forEach(field => validateField(field));
    });
});
</script>
 -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const dobInput = document.getElementById('date_of_birth');
        const ageInput = document.getElementById('age');

        if (dobInput && ageInput) {
            dobInput.addEventListener('change', function() {
                const dob = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }

                ageInput.value = age;
            });
        }

        window.capitalizeInput = function(input) {
            input.value = input.value.replace(/\b\w/g, char => char.toUpperCase());
        };

        const wrapper = document.getElementById('tableWrapper');
        const thead = document.getElementById('tableHead');

        if (wrapper && thead) {
            wrapper.addEventListener('scroll', () => {
                if (wrapper.scrollTop > 0) {
                    thead.classList.add('bg-white', 'shadow-md');
                } else {
                    thead.classList.remove('bg-white', 'shadow-md');
                }
            });
        }

    });
</script>

<script>
    const openBtn = document.getElementById('openModal');
    const modal = document.getElementById('modalOverlay');
    const cancelBtn = document.getElementById('cancelBtn');

    if (openBtn && modal && cancelBtn) {
        openBtn.onclick = () => modal.classList.remove("hidden");

        modal.onclick = (e) => {
            if (e.target === modal) modal.classList.add("hidden");
        };

        cancelBtn.onclick = () => modal.classList.add("hidden");
    }
</script>

<script>
    function toggleSavingsVisibility() {
        const amountElement = document.getElementById('savingsAmount');
        const hiddenElement = document.getElementById('savingsHidden');
        const toggleIcon = document.getElementById('toggleSavings');
        
        if (amountElement && hiddenElement && toggleIcon) {
            if (amountElement.classList.contains('hidden')) {
                // Show amount
                amountElement.classList.remove('hidden');
                hiddenElement.classList.add('hidden');
                toggleIcon.style.setProperty('--svg', 'url("https://api.iconify.design/mdi/eye.svg")');
            } else {
                // Hide amount
                amountElement.classList.add('hidden');
                hiddenElement.classList.remove('hidden');
                toggleIcon.style.setProperty('--svg', 'url("https://api.iconify.design/mdi/eye-off.svg")');
            }
        }
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBtn = document.getElementById('addBtn');
    const savingsForm = document.getElementById('savingsForm');
    const pinModal = document.getElementById('pinModal');
    const pinCancelBtn = document.getElementById('pinCancelBtn');
    const modalOverlay = document.getElementById('modalOverlay');

    // When Add button is clicked, validate and show PIN modal
    addBtn.addEventListener('click', function() {
        // Validate required fields
        const savingsAmount = document.getElementById('savings_amount');
        
        if (!savingsAmount.value) {
            alert('Please enter the savings amount');
            savingsAmount.focus();
            return;
        }

        // Transfer data to hidden fields
        document.getElementById('hidden_bank').value = document.getElementById('bank').value;
        document.getElementById('hidden_date_of_save').value = document.getElementById('date_of_save').value;
        document.getElementById('hidden_savings_amount').value = document.getElementById('savings_amount').value;
        document.getElementById('hidden_description').value = document.getElementById('description').value;
        document.getElementById('hidden_interest_rate').value = document.getElementById('interest_rate').value;

        // Hide first modal and show PIN modal
        modalOverlay.classList.add('hidden');
        pinModal.classList.remove('hidden');
    });

    // Cancel PIN modal
    pinCancelBtn.addEventListener('click', function() {
        pinModal.classList.add('hidden');
        modalOverlay.classList.remove('hidden');
    });
});
</script>