function login() {
    jQuery.ajax({
        type: "POST",
        data: $("#login_form").serialize(),
        url: "Login/start",
        success: function (response) {
            if (response == "true") {
                    window.location.href = "MainMap";
            } else {                            
                alert(response);
            }
        }
    });
};        

function recuperar() {
    jQuery.ajax({
        type: "POST",
        data: $("#login_form").serialize(),
        url: "/Login/SendRecovery",
        success: function (response) {
            console.log(response);
            if (response == "true") {
                    alert("Te enviamos un correo electrónico de recuperación");
                    window.location.href = "/Login";
                    
            } else {                            
                alert("Error: Email no registrado en la DB.");
            }
        }
    });
};
