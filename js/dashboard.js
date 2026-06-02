//ABRIR MODAL Y LLENAR DATOS
$('.updateBtn').click(function(){

        let id = $(this).data('id');
        let nombre = $(this).data('nombre');

        $('#cliente_id').val(id);
        $('#cliente_nombre').text(nombre);
});

//AUTOCOMPLETADO DE FECHAS

$('#duracion').change(function(){

    let duracion = $(this).val();
    let fechaActual = new Date();
    let fechaVencimiento = new Date(

        fechaActual.getTime() +
        duracion * 24 * 60 * 60 * 1000
    );

    let fechaInicio = fechaActual
        .toISOString()
        .split('T')[0];

    let fechaFin = fechaVencimiento
        .toISOString()
        .split('T')[0]

    $('#fecha_ini').val(fechaInicio);
    $('#fecha_fin').val(fechaFin);
});

//FETCH ACTUALIZAR MEMBRESIA

$('#updateMembershipForm').submit(async function(e){
    
    e.preventDefault();

    let formData = {

        id: $('#cliente_id').val(),
        fecha_ini: $('#fecha_ini').val(),
        fecha_fin: $('#fecha_fin').val()
    };

    try{

        let response = await fetch('/api/update_membership.php',{

            method: 'POST',
            headers: {
                'Content-Type':'application/json'
            },
            body: JSON.stringify(formData)
        });

        let data = await response.json()

        if(data.status === "success"){

            Toastify({
                text: data.message,
                duration:3000,
                gravity:"top",
                position:"right",

                style:{
                    background:
                    "linear-gradient(to right,#183B6B,#16BFFD)"
                }
            }).showToast();

            //CERRAR MODAL
            $('#updateMembershipModal').modal('hide');

            //RECARGAR TABLA
            setTimeout(()=> {
                location.reload();
            },1000);
        }else{

            Swal.fire({
                icon:'error',
                title:'Error',
                text:data.message,
                confirmButtonColor:'#183B6B'
            });
            console.log(data)
        }
    }catch(error){
        console.log(error);
    }
});

//AUTOLLENADO DE FECHAS DE PERSONAS
$('#duracionPersonas').change(function(){

    let duracion = $(this).val();
    let fechaActual = new Date();
    let fechaVencimiento = new Date(

        fechaActual.getTime() + 
        duracion * 24 * 60 * 60 * 1000
    );

    let fechaInicio = fechaActual
        .toISOString()
        .split('T')[0]

    let fechaFin = fechaVencimiento
        .toISOString()
        .split('T')[0]

    $('#fecha_ini_persona').val(fechaInicio);
    $('#fecha_fin_persona').val(fechaFin);
});

//FETCH PARA CREAR PERSONA
$('#createPersonForm').submit(async function(e){

    e.preventDefault();

    let formData = {

        nombre: $('#nombre').val(),
        folio: $('#folio').val(),
        fecha_ini: $('#fecha_ini_persona').val(),
        fecha_fin: $('#fecha_fin_persona').val()
    };

    try{

        let response = await fetch('/api/create_person.php',{
            
            method: 'POST',
            headers: {
                'Content-Type':'application/json'
            },

            body: JSON.stringify(formData)
        });

        let data = await response.json();

        if(data.status === 'success'){

            Toastify({

                text:data.message,
                duration:3000,
                gravity:"top",
                position:"right",

                style:{
                    background:
                    "linear-gradient(to right,#183B6B,#16BFFD)"
                }
            }).showToast();

            $('#addPersonModal').modal('hide');
            $('#createPersonForm')[0].reset();

            setTimeout(() =>{

                location.reload();
            },1000);

        }else{

            Swal.fire({

                icon:'error',
                title:'error',
                text:data.message,
                confirmButtonColor:'#183B6B'
            });

        }
    }catch(error){
        console.log(error);
    }
});