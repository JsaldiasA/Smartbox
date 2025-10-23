function fntDelRiego(id){
    swal({
        title: "¿Está seguro de eliminar el registro?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
          swal("Registro eliminado.", {
            icon: "success",
          });
        } else {
          swal("Se ha cancelado la acción");
        }
    });
}




