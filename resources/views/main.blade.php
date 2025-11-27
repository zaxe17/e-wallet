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
<!-- SIGNUP -->
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

<!-- MODAL OPEN -->
<script>
    const modal = document.getElementById('modalOverlay');
    const cancelBtn = document.getElementById('cancelBtn');

    document.querySelectorAll('.openModalBtn').forEach(btn => {
        btn.onclick = () => modal.classList.remove("hidden");
    });

    modal.onclick = (e) => {
        if (e.target === modal) modal.classList.add("hidden");
    };

    cancelBtn.onclick = () => modal.classList.add("hidden");
</script>

<!-- EYE BUTTON -->
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
        const addForm = document.getElementById('addForm');
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