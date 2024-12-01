document.addEventListener('DOMContentLoaded', function(){
    const multipleCardsContainer = document.getElementById('multiple-cards');
    const users = JSON.parse(localStorage.getItem('usersData')) || [];

    if (users.length > 0) {
        // Crear páginas de 9 tarjetas cada una
        for (let i = 0; i < users.length; i += 9) {
            const pageContainer = document.createElement('div');
            pageContainer.classList.add('card-page');

            const pageUsers = users.slice(i, i + 9);
            pageUsers.forEach(user => {
                const card = document.createElement('div');
                card.classList.add('id-card', 'col-4');
                user.nombres = user.nombres.length > 16 ? acortarNombre(user.nombres) : user.nombres;
                let cardContent = `
                    <div class="mt-6 d-flex align-items-center flex-column">
                        <p class="m-0"><b>Unimat</b></p>
                        <small class="text-center">"Donde el futuro se forja hoy"</small>
                    </div>
                    <div class="id-card-header">
                        <img src="${base_url}/Assets/images/logo_unimat.webp" alt="Logo" class="id-card-logo">
                    </div>
                    <div class="id-card-content">
                        <p class='id-card-name m-0' ><b>${user.nombres}</b></p>
                        <p class="id-card-profession">${user.nombrerol}</p>
                    </div>
                    <div class="img-qr d-flex justify-content-center">
                        <img src="${user.qr}" alt="QR Code">
                    </div>
                    <div class="id-card-footer">
                        <b>Colegios UNIMAT </b><br>
                        <small><b>cañete</b></small>
                    </div>
                `;
                
                card.innerHTML = cardContent;
                pageContainer.appendChild(card);
            });

            multipleCardsContainer.appendChild(pageContainer);
        }
    }

    window.print();
});

function acortarNombre(nombreCompleto) {
    let nombresArray = nombreCompleto.split(' ');
    if (nombresArray.length > 1) {
        let primerNombre = nombresArray[0];
        let iniciales = nombresArray.slice(1).map(nombre => nombre.charAt(0) + '.').join(' ');
        return primerNombre + ' ' + iniciales;
    }
    return nombreCompleto; // En caso de que no haya un segundo nombre, retorna el nombre completo.
}