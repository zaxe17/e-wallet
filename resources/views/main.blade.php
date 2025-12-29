<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayNoy - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="m-0 p-0 h-screen selection:bg-green-200">

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
    document.addEventListener("DOMContentLoaded", () => {
        // Open the corresponding modal when a button is clicked
        document.querySelectorAll('.openModalBtn').forEach(btn => {
            btn.onclick = () => {
                const modalId = btn.getAttribute('data-target');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove("hidden");
                }
            };
        });

        // Close the modal when clicking outside the modal content
        document.querySelectorAll('.modal').forEach(modal => {
            modal.onclick = (e) => {
                if (e.target === modal) {
                    modal.classList.add("hidden");
                }
            };
        });

        // Cancel button hides the corresponding modal
        document.querySelectorAll('.cancelBtn').forEach(btn => {
            btn.onclick = () => {
                const modalId = btn.getAttribute('data-target');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add("hidden");
                }
            };
        });
    });
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

<!-- PIN -->
<script>
    let pin = [];
    const maxLength = 4;
    const boxes = document.querySelectorAll('.pin-box');
    const pinModal = document.getElementById('pinModal');
    const cancelPinBtn = document.getElementById('cancelPinBtn');

    // Function to update the displayed PIN boxes
    function updateBoxes() {
        boxes.forEach((box, index) => {
            if (index < pin.length) {
                box.classList.add('bg-[#485349]', 'text-white');
                box.textContent = pin[index]; // SHOW NUMBER
            } else {
                box.classList.remove('bg-[#485349]', 'text-white');
                box.textContent = '';
            }
        });
    }

    // Function to add a digit to the pin array
    function addDigit(num) {
        if (pin.length < maxLength) {
            pin.push(num);
            updateBoxes();

            if (pin.length === maxLength) {
                submitPin(); // Call the submitPin function when the pin is full
            }
        }
    }

    // Function to remove a digit from the pin array
    function removeDigit() {
        pin.pop();
        updateBoxes();
    }

    // Function to handle the PIN submission
    function submitPin() {
        const enteredPin = pin.join('');
        console.log('Entered PIN:', enteredPin);

        // Sending the entered PIN to the backend for validation
        fetch('/validate-passkey', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // CSRF token
                },
                body: JSON.stringify({
                    passkey: enteredPin
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to validate PIN');
                }
                return response.json();
            })
            .then(data => {
                if (data.valid) {
                    // Redirect to savings page if PIN is valid
                    window.location.href = '/savings';
                } else {
                    alert('Invalid PIN. Please try again.');
                    pin = []; // Reset the PIN input
                    updateBoxes();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });

        setTimeout(() => {
            pin = [];
            updateBoxes();
            pinModal.classList.add("hidden");
        }, 300);
    }

    // Open the PIN modal when the button is clicked
    document.querySelectorAll('.openPinModalBtn').forEach(btn => {
        btn.onclick = () => pinModal.classList.remove("hidden");
    });

    // Close the modal when clicking outside the modal content
    pinModal.onclick = (e) => {
        if (e.target === pinModal) pinModal.classList.add("hidden");
    };

    // Cancel function to reset PIN and close the modal
    cancelPinBtn.onclick = () => {
        pin = []; // Clear the PIN input
        updateBoxes(); // Reset the displayed boxes
        pinModal.classList.add("hidden"); // Close the modal
    };
</script>