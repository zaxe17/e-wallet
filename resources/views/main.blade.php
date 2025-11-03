<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-wallet - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/scene.js', 'resources/js/animate.js'])
</head>

<body class="m-0 p-0 h-screen">
    <div class="w-full h-full fixed top-0 left-0">
        <div id="container3D" class="w-full h-full"></div>
        <div class="absolute top-0 z-[-2] h-screen w-screen bg-fuchsia-300 bg-[radial-gradient(#ffffff33_1px,#fce7f3_1px)] bg-size-[20px_20px]"></div>
    </div>

    @include('component.navbar')

    @yield('content')

</body>

</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('accountForm');
    const fields = form.querySelectorAll('input[required], select[required]');

    // ✅ Validation function (used in both input/select events and submit)
    function validateField(field) {
        const parent = field.closest('.flex-col');
        const errorMsg = parent.querySelector('.error-msg');
        const successMsg = parent.querySelector('.success-msg');

        let valid = false;

        if (field.type === 'radio') {
            const name = field.name;
            valid = form.querySelector(`input[name="${name}"]:checked`) !== null;
        } else if (field.tagName.toLowerCase() === 'select') {
            valid = field.value.trim() !== '';
        } else {
            valid = field.value.trim() !== '';
        }

        if (!valid) {
            field.classList.add('ring-2', 'ring-red-500');
            field.classList.remove('ring-2', 'ring-emerald-500');
            errorMsg?.classList.remove('hidden');
            successMsg?.classList.add('hidden');
        } else {
            field.classList.remove('ring-2', 'ring-red-500');
            field.classList.add('ring-2', 'ring-emerald-500');
            errorMsg?.classList.add('hidden');
            successMsg?.classList.remove('hidden');
        }
    }

    // ✅ Realtime validation (on input/select change)
    fields.forEach(field => {
        // For text, email, number, date, etc.
        if (field.type !== 'radio') {
            field.addEventListener('input', () => validateField(field));
            field.addEventListener('change', () => validateField(field)); // for selects/dates
        } else {
            // For radios, validate when any option is clicked
            const name = field.name;
            const radios = form.querySelectorAll(`input[name="${name}"]`);
            radios.forEach(r => r.addEventListener('change', () => validateField(field)));
        }
    });

    // ✅ Validate all on submit
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // remove in production
        fields.forEach(field => validateField(field));
    });
});
</script>