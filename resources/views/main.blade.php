<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-wallet - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="m-0 p-0 h-screen">

    @yield('content')

</body>

</html>

<script>
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

        const bankSelect = document.getElementById('connected_bank');
        const otherInput = document.getElementById('other_bank');

        bankSelect.addEventListener('change', () => {
            if (bankSelect.value === 'Other') {
                otherInput.classList.remove('hidden');
                otherInput.required = true;
                bankSelect.removeAttribute('name');
            } else {
                otherInput.classList.add('hidden');
                otherInput.required = false;
                otherInput.value = '';
                otherInput.removeAttribute('name');
                bankSelect.setAttribute('name', 'connected_bank');
            }
        });
    });
</script>