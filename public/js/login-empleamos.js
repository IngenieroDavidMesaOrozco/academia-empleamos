document.addEventListener('DOMContentLoaded', () => {

    const password = document.getElementById('password');
    const toggle = document.querySelector('.toggle-password');
    const owl = document.getElementById('owl');
    const pupils = document.querySelectorAll('.pupil');

    // El búho sigue el mouse
    document.addEventListener('mousemove', (e) => {

        const x = (e.clientX / window.innerWidth - 0.5) * 10;
        const y = (e.clientY / window.innerHeight - 0.5) * 10;

        pupils.forEach(p => {
            p.style.transform = `translate(${x}px, ${y}px)`;
        });

    });

    // Al escribir contraseña se tapa los ojos
    password.addEventListener('focus', () => {
        owl.classList.add('cover');
        owl.classList.remove('peek');
    });

    password.addEventListener('blur', () => {

        if(password.type === 'password'){
            owl.classList.remove('cover');
        }

    });

    // Mostrar / ocultar contraseña
    toggle.addEventListener('click', () => {

        const hidden = password.type === 'password';

        password.type = hidden ? 'text' : 'password';

        toggle.innerHTML = hidden
            ? '<i class="fa-solid fa-eye-slash"></i>'
            : '<i class="fa-solid fa-eye"></i>';

        if(hidden){
            owl.classList.remove('cover');
            owl.classList.add('peek');
        }else{
            owl.classList.remove('peek');
            owl.classList.add('cover');
        }

    });

    // Inputs activos
    document.querySelectorAll('.form-control').forEach(input => {

        input.addEventListener('focus', () => {
            input.parentElement.classList.add('active');
        });

        input.addEventListener('blur', () => {
            input.parentElement.classList.remove('active');
        });

    });

    // Efecto suave del logo
    const logo = document.querySelector('.logo-circle');

    if(logo){

        logo.addEventListener('mouseenter', () => {
            logo.style.transform = 'translateY(-2px) scale(1.02)';
            logo.style.boxShadow = '0 18px 36px rgba(0,0,0,.22)';
        });

        logo.addEventListener('mouseleave', () => {
            logo.style.transform = 'translateY(0) scale(1)';
            logo.style.boxShadow = '0 12px 30px rgba(0,0,0,.18)';
        });

    }

});