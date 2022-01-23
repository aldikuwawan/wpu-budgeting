const Toast = Swal.mixin({
  toast: true,
  position: 'top',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

const flasData = $('.flash-data').data('flashdata');
const flasDataError = $('.flash-data2').data('flashdata2');


if(flasData){
	Toast.fire({
      icon: 'success',
      title: flasData
    })
}

if(flasDataError){
	Toast.fire({
      icon: 'error',
      title: flasDataError
    })
}
