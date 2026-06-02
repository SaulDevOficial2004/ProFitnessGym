const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', async function(e){

    e.preventDefault();

    let telefono = document.getElementById('telefono').value;

    let password = document.getElementById('password').value;

    try{

        let response = await fetch('api/login_api.php', {
            method: 'POST',

            headers:{
                'Content-Type':'application/json'
            },

            body: JSON.stringify({
                
                telefono: telefono,
                password: password

            })
        });

        let data = await response.json();

        if(data.status === "success"){

            Toastify({

                text: data.message,
                duration: 3000,
                gravity: "top",
                position: "right",

                style:{
                    background:
                    "linear-gradient(to right,#183B6B,#16BFFD)"
                }
            }).showToast();

            setTimeout(() => {
                window.location.href = "pagina.php";
            }, 1500);
        }else{
            
            Swal.fire({
                icon:'error',
                title:'Error',
                text:data.message,
                confirmButtonColor:'#183B6B'
            });

        }
    }catch(error){
        console.log(error);
    }
});