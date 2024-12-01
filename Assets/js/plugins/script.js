//funcion para el sidebar pueda ocultarse y vizualizarce
const toggler = document.querySelector(".btn");
toggler.addEventListener("click",function(){
    document.querySelector("#sidebar").classList.toggle("collapsed");
    
});

//funcion para realizar la animacion de carga
function mostrarSpinner() {
    document.getElementById('loading').style.display = 'flex';
}
  
function ocultarSpinner() {
    document.getElementById('loading').style.display = 'none';
}
  
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
  });
  