<script>
	
	let btn_salir=document.querySelector(".btn-exit-system");
	btn_salir.addEventListener('click',function(e){
		e.preventDefault();
		Swal.fire({
			title: 'Deseas salir del sistema?',
			text: "La sesion se cerrara",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, salir!',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
				let url='<?php echo SERVERURL; ?>ajax/loginAjax.php';
				let token='<?php echo $lc->encryption($_SESSION['token_spm']); ?>';
				let usuario='<?php echo $lc->encryption($_SESSION['us_spm']); ?>';
				// let clave='< ?php echo $lc->encryption("comadreja apesta"); ?>';
				// let clave='< ?php echo $lc->decryption("cjZvN3pJWlVkcG43QmdKVTFSV3ZQQTJaMlZUY0g2WkpzN1RvUzRCdVZjVzBaTzhJNm02QVNaRVhKb1BXVU4zdg=="); ?>';
				// let clave='< ?php echo $lc->decryption($_SESSION['k']); ?>';
				// window.location="index.html";

				let datos = new FormData();
				datos.append("token",token);
				datos.append("usuario",usuario);

				fetch(url,{method: 'POST', body: datos})
				.then(respuesta => respuesta.json())
				.then(respuesta => {
					return alertas_ajax(respuesta);
				});
			}
		});
	});
</script>
