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
    document.getElementById('date_of_birth').addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        document.getElementById('age').value = age;
    });

    function capitalizeInput(input) {
        // Split the value by space, capitalize the first letter of each word, and then join it back together
        input.value = input.value.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
</script>

<script>
    const wrapper = document.getElementById('tableWrapper');
    const thead = document.getElementById('tableHead');

    wrapper.addEventListener('scroll', () => {
        if (wrapper.scrollTop > 0) {
            thead.classList.add('bg-white', 'shadow-md'); // bg kapag nag-scroll
        } else {
            thead.classList.remove('bg-white', 'shadow-md'); // transparent ulit
        }
    });
</script>