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
                submitPin(); // Call submitPin when pin is full
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

        fetch('/savings/validate-passkey', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    passkey: enteredPin
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to validate PIN');
                return response.json();
            })
            .then(data => {
                if (data.valid) {
                    window.location.href = '/savings';
                } else {
                    alert('Invalid PIN. Please try again.');
                    pin = [];
                    updateBoxes();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });

        // reset after a short delay
        setTimeout(() => {
            pin = [];
            updateBoxes();
            pinModal.classList.add("hidden");
        }, 300);
    }

    // Open modal buttons
    document.querySelectorAll('.openPinModalBtn').forEach(btn => {
        btn.onclick = () => pinModal.classList.remove("hidden");
    });

    // Close modal by clicking outside content
    pinModal.onclick = (e) => {
        if (e.target === pinModal) pinModal.classList.add("hidden");
    };

    // Cancel button
    cancelPinBtn.onclick = () => {
        pin = [];
        updateBoxes();
        pinModal.classList.add("hidden");
    };

    // --- KEYBOARD SUPPORT ---
    document.addEventListener('keydown', (e) => {
        if (pinModal.classList.contains('hidden')) return; // only active when modal open

        // Allow digits 0-9
        if (e.key >= '0' && e.key <= '9') {
            addDigit(e.key);
        }

        // Backspace to remove last digit
        if (e.key === 'Backspace') {
            removeDigit();
        }

        // Enter to submit if full
        if (e.key === 'Enter' && pin.length === maxLength) {
            submitPin();
        }
    });
</script>

<!-- SAVE PIN -->
<script>
    const savePinModal = document.getElementById('savePin');
    const savePinInput = document.getElementById('savePinInput');
    const savePinTitle = document.getElementById('savePinTitle');

    let firstSavePin = null;
    let isConfirmingSavePin = false;

    savePinInput.addEventListener('input', () => {
        const value = savePinInput.value.replace(/\D/g, '');

        savePinInput.value = value;

        if (value.length !== 4) return;

        // FIRST ENTRY
        if (!isConfirmingSavePin) {
            firstSavePin = value;
            isConfirmingSavePin = true;
            savePinInput.value = '';
            savePinTitle.textContent = 'Confirm your passkey';
            return;
        }

        // CONFIRMATION
        if (value !== firstSavePin) {
            alert('Passkey does not match. Try again.');
            firstSavePin = null;
            isConfirmingSavePin = false;
            savePinInput.value = '';
            savePinTitle.textContent = 'Enter your passkey';
            return;
        }

        // SAVE TO DB
        fetch('/savings/save-passkey', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    passkey: value
                })
            })
            .then(() => location.reload());
    });

    // auto focus kapag lumabas
    const observer = new MutationObserver(() => {
        if (!savePinModal.classList.contains('hidden')) {
            savePinInput.focus();
        }
    });

    observer.observe(savePinModal, {
        attributes: true
    });
</script>

<!-- CHECK PASSKEY IF NULL TO SHOW THE SAVE PASSKEY -->
<script>
    fetch('/savings/check-passkey')
        .then(res => res.json())
        .then(data => {
            if (data.is_null) {
                document.getElementById('savePin').classList.remove('hidden');
            }
        });
</script>

<!-- SETTINGS -->
<script>
    const form = document.getElementById('settingsForm');
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    const inputs = form.querySelectorAll('input');

    const originalValues = {};

    inputs.forEach(input => {
        originalValues[input.name] = input.value;
    });

    editBtn.addEventListener('click', () => {
        inputs.forEach(input => {
            input.removeAttribute('readonly');
        });

        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
    });

    cancelBtn.addEventListener('click', () => {
        inputs.forEach(input => {
            input.value = originalValues[input.name];

            input.setAttribute('readonly', true);
        });

        saveBtn.classList.add('hidden');
        editBtn.classList.remove('hidden');
    });
</script>

<!-- WIDRAWAL AND DEPOSIT -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Toggle Deposit/Withdrawal forms
        function setupModalTabs(modal) {
            const depositForm = modal.querySelector("#depositForm");
            const withdrawalForm = modal.querySelector("#withdrawalForm");
            const depositBtn = modal.querySelector("#depositBtn");
            const withdrawalBtn = modal.querySelector("#withdrawalBtn");

            if (!depositForm || !withdrawalForm || !depositBtn || !withdrawalBtn) return;

            depositForm.classList.remove("hidden");
            withdrawalForm.classList.add("hidden");
            depositBtn.classList.add("bg-[#485349]", "text-white");
            withdrawalBtn.classList.remove("bg-[#485349]", "text-white");
            withdrawalBtn.classList.add("text-[#485349]");

            depositBtn.addEventListener("click", () => {
                depositForm.classList.remove("hidden");
                withdrawalForm.classList.add("hidden");

                depositBtn.classList.add("bg-[#485349]", "text-white");
                withdrawalBtn.classList.remove("bg-[#485349]", "text-white");
                withdrawalBtn.classList.add("text-[#485349]");
            });

            withdrawalBtn.addEventListener("click", () => {
                withdrawalForm.classList.remove("hidden");
                depositForm.classList.add("hidden");

                withdrawalBtn.classList.add("bg-[#485349]", "text-white");
                depositBtn.classList.remove("bg-[#485349]", "text-white");
                depositBtn.classList.add("text-[#485349]");
            });
        }

        // Open modal & autofill deposit/withdrawal
        document.querySelectorAll(".openModalBtn").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.stopPropagation();

                const modal = document.getElementById(this.dataset.target);
                if (!modal) return;

                setupModalTabs(modal);

                // Fill the forms
                const data = {
                    bank: this.dataset.bank || "",
                    description: this.dataset.description || "",
                    interest_rate: this.dataset.interest || "",
                    date_of_save: this.dataset.date || "",
                    savings_amount: this.dataset.amount || "",
                    savingsno: this.dataset.savingsno || ""
                };

                modal.querySelectorAll("form").forEach(form => {
                    form.querySelectorAll("input").forEach(input => {
                        const name = input.getAttribute("name");
                        if (data[name] !== undefined) {
                            input.value = data[name];
                        }
                    });
                    // Save savingsno as hidden input
                    const hiddenInput = form.querySelector('input[name="savingsno"]');
                    if (hiddenInput) hiddenInput.value = data.savingsno;
                });

                // Show modal
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            });
        });

        // Cancel button
        document.querySelectorAll(".cancelBtn").forEach(btn => {
            btn.addEventListener("click", function() {
                const modal = document.getElementById(this.dataset.target);
                if (!modal) return;

                modal.querySelectorAll("form").forEach(form => form.reset());

                modal.classList.add("hidden");
                modal.classList.remove("flex");
            });
        });
    });
</script>

<!-- DELETE BUTTON FOR SAVINGS -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        /* ================= OPEN MODAL ================= */
        document.querySelectorAll(".openModalBtn").forEach(btn => {
            btn.addEventListener("click", () => {
                const modal = document.getElementById(btn.dataset.target);
                if (!modal) return;

                const data = {
                    bank: btn.dataset.bank || "",
                    description: btn.dataset.description || "",
                    interest_rate: btn.dataset.interest || "",
                    date_of_save: btn.dataset.date || "",
                    savings_amount: btn.dataset.amount || "",
                    savingsno: btn.dataset.savingsno || ""
                };

                const form = modal.querySelector(".add-edit-form");
                const deleteForm = modal.querySelector(".delete-form");

                // Fill inputs
                form.querySelectorAll("input").forEach(input => {
                    if (data[input.name] !== undefined) {
                        input.value = data[input.name];
                    }
                });

                // Store original interest per modal
                modal.dataset.originalInterest = data.interest_rate || "0";

                // Set routes
                form.action = `/savings/update/${data.savingsno}`;
                deleteForm.action = `/savings/delete/${data.savingsno}`;

                // Reset UI state
                resetEditUI(modal);

                modal.classList.remove("hidden");
                modal.classList.add("flex");
            });
        });

        /* ================= DECIMAL INPUT FIX ================= */
        document.querySelectorAll("input[name='interest_rate']").forEach(input => {
            input.setAttribute("step", "any");
            input.setAttribute("inputmode", "decimal");

            input.addEventListener("input", (e) => {
                let value = e.target.value;

                // Remove invalid chars except first dot
                value = value.replace(/[^0-9.]/g, '');
                const firstDotIndex = value.indexOf('.');

                // Handle multiple dots (allow only one)
                if (firstDotIndex !== -1) {
                    const beforeDot = value.slice(0, firstDotIndex + 1);
                    const afterDot = value.slice(firstDotIndex + 1).replace(/\./g, '');
                    value = beforeDot + afterDot;
                }

                // Update input value only if it's different
                if (value !== e.target.value) {
                    e.target.value = value;
                }
            });
        });

        /* ================= CHANGE MODE ================= */
        document.addEventListener("click", e => {
            if (!e.target.classList.contains("changeBtn")) return;

            const modal = e.target.closest(".modal");
            const interest = modal.querySelector("input[name='interest_rate']");

            interest.removeAttribute("readonly");
            interest.classList.remove("bg-gray-200", "cursor-not-allowed");
            interest.focus();

            modal.querySelector(".saveSection").classList.remove("hidden");
            modal.querySelector(".deleteSection").classList.add("hidden");

            e.target.classList.add("hidden");
        });

        /* ================= CANCEL EDIT ================= */
        document.addEventListener("click", e => {
            if (!e.target.classList.contains("cancelEditBtn")) return;

            const modal = e.target.closest(".modal");
            const interest = modal.querySelector("input[name='interest_rate']");
            const changeBtn = modal.querySelector(".changeBtn");

            // Restore original value
            interest.value = modal.dataset.originalInterest;
            interest.setAttribute("readonly", true);
            interest.classList.add("bg-gray-200", "cursor-not-allowed");

            modal.querySelector(".saveSection").classList.add("hidden");
            modal.querySelector(".deleteSection").classList.remove("hidden");

            changeBtn.classList.remove("hidden");
        });

        /* ================= CLOSE MODAL ================= */
        document.querySelectorAll(".cancelBtn").forEach(btn => {
            btn.addEventListener("click", () => {
                const modal = btn.closest(".modal");
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            });
        });

        /* ================= RESET UI ================= */
        function resetEditUI(modal) {
            modal.querySelector(".saveSection").classList.add("hidden");
            modal.querySelector(".deleteSection").classList.remove("hidden");

            const interest = modal.querySelector("input[name='interest_rate']");
            const changeBtn = modal.querySelector(".changeBtn");

            interest.setAttribute("readonly", true);
            interest.classList.add("bg-gray-200", "cursor-not-allowed");
            changeBtn.classList.remove("hidden");
        }

    });
</script>

<!-- INPUT FOR TABLES -->
<script>
    document.addEventListener("click", (e) => {
        const editBtn = e.target.closest(".edit-btn");
        const cancelBtn = e.target.closest(".cancel-btn");

        if (!editBtn && !cancelBtn) return;

        const row = e.target.closest("tr");

        if (editBtn) {
            toggleEdit(row, true);
        }

        if (cancelBtn) {
            resetRow(row);
            toggleEdit(row, false);
        }
    });

    function toggleEdit(row, editing) {
        row.querySelectorAll(".text").forEach(el =>
            el.classList.toggle("hidden", editing)
        );

        row.querySelectorAll(".input").forEach(el =>
            el.classList.toggle("hidden", !editing)
        );

        row.querySelector(".edit-btn").classList.toggle("hidden", editing);
        row.querySelector(".save-btn").classList.toggle("hidden", !editing);
        row.querySelector(".cancel-btn").classList.toggle("hidden", !editing);
    }

    function resetRow(row) {
        row.querySelectorAll(".input").forEach(input => {
            input.value = input.defaultValue;
        });
    }
</script>

<!-- CONFIRMATION FOR DELETING RECORD -->
<script>
    // Modal elements
    const deleteModal = document.getElementById('deleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    let formToDelete = null; // store the form that triggered delete

    // When clicking a delete button in table
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            formToDelete = btn.closest('form'); // store the correct form
            deleteModal.classList.remove('hidden'); // show modal
        });
    });

    // Cancel button
    cancelDeleteBtn.addEventListener('click', () => {
        formToDelete = null;
        deleteModal.classList.add('hidden');
    });

    // Confirm button
    confirmDeleteBtn.addEventListener('click', () => {
        if (formToDelete) {
            formToDelete.submit(); // submit the correct form
        }
    });
</script>