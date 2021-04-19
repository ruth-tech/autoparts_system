$("#signup").click(function(){
  $("#first").fadeOut("fast", function() {
    $("#second").fadeIn("fast");
  });
});
    
$("#signin").click(function() {
  $("#second").fadeOut("fast", function() {
    $("#first").fadeIn("fast");
  });
});
    
    
      
$(function() {
  $("form[name='login']").validate({
    rules: {
        
      txtUsuario: {
      required: true,
      },
      txtPassword: {
      required: true,
      }
    },
    messages: {
      email: "Por favor ingrese un nombre de usuario valido",
                    
      password: {
        required: "Por favor ingrese una contraseña",
                      
      }
                   
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});
             
    
    
$(function() {
      
  $("form[name='registration']").validate({
    rules: {
      firstname: "required",
      lastname: "required",
      email: {
        required: true,
      },
      password: {
        required: true,
        minlength: 15
      }
    },
        
    messages: {
      firstname: "Please enter your firstname",
      lastname: "Please enter your lastname",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 15 characters long"
      },
      email: "Please enter a valid email address"
    },
      
    submitHandler: function(form) {
      form.submit();
    }
  });
});

function alerta(mensaje){
  Swal.fire(mensaje);
  // Swal.fire({
  //   icon: 'error',/* success, warning, info -> son los valorees que puede tomar "Icon" */
  //   text: mensaje
  // });
}