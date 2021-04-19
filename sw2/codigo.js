// Alerta Básica
$("#btn1").click(function(){
    Swal.fire("Ejemplo de Sweet Alert 2");
});

// Alertas con tipos de iconos
$("#btn2").click(function(){
    Swal.fire({
        icon: 'error',/* success, warning, info -> son los valorees que puede tomar "Icon" */
        title: 'Oops...',
        text: 'Something went wrong!'
    });
});

// Alerta con imagen
$("#btn3").click(function(){
    Swal.fire({
       imageUrl:'img/Captura1.JPG',
       imageHeight: 200
    });
});

// Alerta con posicion
$("#btn4").click(function(){
    Swal.fire({
       position:'top-start', /* posibles valores: top-end, top, center, center-start, center-end, bottom, bottom-statrt, bottom-end */
       icon: 'success',
       title: 'Tu trabajo ha sido guardado',
       showConfirmButton:false,
       timer:2000
    });
});

// Alerta con animacion
$("#btn5").click(function(){
    Swal.fire({
      title: 'Animacion con animate.css',
      showClass:{
          popup: 'animate__animated animate__fadeInDown'
      }
    });
});

// Alerta con animacion
$("#btn6").click(function(){
    Swal.fire({
      title: 'Personalizando ancho, padding y backgrond.',
      padding:'5em',
      width:600,
      background: '#fff url(img/fondo1.png)',
      backdrop:`
        rgba(5,5,25,0.4)
        url("img/2.gif")
        bottom
        no-repeat
      `
    });
});

// Alerta progresivo
$("#btn7").click(function(){
    Swal.mixin({
        input: 'text',
        confirmButtonText: 'Next &rarr;',
        showCancelButton: true,
        progressSteps: ['1', '2', '3']
      }).queue([
        {
          title: 'Question 1',
          text: '¿Color favorito?'
        },
        {
            title:'Question 2',
            text: '¿Animal favorito?'
        },
        {
            title:'Question 3',
            text: '¿Pais de origen?'
        }
        
      ]).then((result) => {
        if (result.value) {
          const answers = JSON.stringify(result.value)
          Swal.fire({
            title: 'All done!',
            html: `
              Your answers:
              <pre><code>${answers}</code></pre>
            `,
            confirmButtonText: 'Lovely!'
          });
        }
    });
});

// Alert timer
let timerInterval;
$("#btn8").click(function(){
    Swal.fire({
        title: 'Auto close alert!',
        html: 'I will close in <b></b> milliseconds.',
        timer: 2000,
        timerProgressBar: true,
        willOpen: () => {
          Swal.showLoading()
          timerInterval = setInterval(() => {
            const content = Swal.getContent()
            if (content) {
              const b = content.querySelector('b')
              if (b) {
                b.textContent = Swal.getTimerLeft()
              }
            }
          }, 100)
        },
        onClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('I was closed by the timer')
        }
    });
      

});
