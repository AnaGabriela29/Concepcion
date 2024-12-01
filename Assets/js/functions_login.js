$(document).ready(function(){   
    $('.flip').click(function(e) {
        e.preventDefault();
        $('.flip-container').toggleClass('flipped');
    });
});
if(document.getElementById('basic2')){
	document.getElementById('basic2').addEventListener('click', function(){
		let icon= this.querySelector('i');
		icon.classList.toggle('bi-eye-fill');
		icon.classList.toggle('bi-eye-slash-fill');
		document.getElementById('txtPassword').getAttribute('type')=='password'?document.getElementById('txtPassword').setAttribute('type', 'text'):document.getElementById('txtPassword').setAttribute('type', 'password')
	})
}

//funcion para realizar la animacion de carga
function mostrarSpinner() {
    document.getElementById('loading').style.display = 'flex';
}
  
function ocultarSpinner() {
    document.getElementById('loading').style.display = 'none';
}

var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
	if(document.querySelector("#formLogin")){
		let formLogin = document.querySelector("#formLogin");
		formLogin.onsubmit = function(e) {
			e.preventDefault();

			let strEmail = document.querySelector('#txtEmail').value;
			let strPassword = document.querySelector('#txtPassword').value;

			if(strEmail == "" || strPassword == "")
			{
				Swal.fire("Por favor", "Escribe usuario y contraseñaa.", "error");
				return false;
			}else{
				mostrarSpinner();

				const ajaxUrl = base_url + '/Login/loginUser';
				const formData = new FormData(formLogin);

				fetch(ajaxUrl, {
				method: 'POST',
				body: formData
				})
				.then(response => response.json()) // Parse the JSON response
				.then(objData => {
				if (objData.status) {
					ocultarSpinner();
					window.location = base_url + '/dashboard';					
				} else {
					ocultarSpinner();
					Swal.fire("Atención", objData.msg, "error");
					document.querySelector('#txtPassword').value = "";
				}
				})
				.catch(error => {
				Swal.fire("Atención", "Error en el proceso", "error");
				console.error('Error:', error); // Log the error for debugging
				ocultarSpinner();
				});

			}
		}
	}

	if(document.querySelector("#formRecetPass")){		
		let formRecetPass = document.querySelector("#formRecetPass");
		formRecetPass.onsubmit = function(e) {
			e.preventDefault();			
			let strEmail = document.querySelector('#txtEmailReset').value;
			if(strEmail == "")			{
				Swal.fire("Error", "Escribe tu correo electrónico.", "error");
				return false;
			}else{
				mostrarSpinner();
				let ajaxUrl = base_url + '/Login/resetPass';
				let formData = new FormData(formRecetPass);

				fetch(ajaxUrl, {
					method: 'POST',
					body: formData
				})
				.then(response => {
					if (!response.ok) {
						throw new Error('Error en el proceso');
					}
					return response.json();
				})
				.then(objData => {
					if (objData.status) {
						ocultarSpinner();
						Swal.fire({
							title: "",
							text: objData.msg,
							icon: "success",
							confirmButtonText: "Aceptar"
						}).then(result => {
							if (result.isConfirmed) {
								window.location = base_url;
							}
						});
					} else {
						ocultarSpinner();
						Swal.fire("Atención", objData.msg, "error");
					}
				})
				.catch(error => {
					ocultarSpinner();
					Swal.fire("Atención", error.message, "error");
				})
				.finally(() => {
					ocultarSpinner();
				});
					
			}
		}
	}

	if (document.querySelector("#formCambiarPass")) {
		let formCambiarPass = document.querySelector("#formCambiarPass");
		formCambiarPass.onsubmit = async function (e) {
			e.preventDefault();
	
			let strPassword = document.querySelector('#txtPassword').value;
			let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
			let idUsuario = document.querySelector('#idUsuario').value;
	
			if (strPassword === "" || strPasswordConfirm === "") {
				Swal.fire("Por favor", "Escribe la nueva contraseña.", "error");
				return false;
			} else {
				if (strPassword.length < 5) {
					Swal.fire("Atención", "La contraseña debe tener un mínimo de 5 caracteres.", "info");
					return false;
				}
				if (strPassword !== strPasswordConfirm) {
					Swal.fire("Atención", "Las contraseñas no son iguales.", "error");
					return false;
				}
				
				mostrarSpinner();
	
				let formData = new FormData(formCambiarPass);
				let requestOptions = {
					method: 'POST',
					body: formData,
				};
	
				try {
					let response = await fetch(`${base_url}/Login/setPassword`, requestOptions);
					if (response.ok) {
						let objData = await response.json();
						if (objData.status) {
							ocultarSpinner();
							Swal.fire({
								title: "",
								text: objData.msg,
								icon: "success",
								confirmButtonText: "Iniciar sesión",
							}).then((result) => {
								if (result.isConfirmed) {
									window.location = `${base_url}/login`;
								}
							});
						} else {
							ocultarSpinner();
							Swal.fire("Atención", objData.msg, "error");
						}
					} else {
						ocultarSpinner();
						Swal.fire("Atención", "Error en el proceso", "error");
					}
				} catch (error) {
					ocultarSpinner();
					Swal.fire("Atención", "Error en el proceso", "error");
				} finally {
					ocultarSpinner();
				}
			}
		}
	}
	

}, false);