<template>
    <input type="submit" class="btn btn-danger d-block w-100 mb-2 text-white text-uppercase" value="Eliminar" v-on:click="eliminarReceta">
</template>

<script>
    export default{
        props: ['recetaId'],
        methods:{
            eliminarReceta(){
                    this.$swal({
                        title: '¿Estas seguro?',
                        text: "¡o podras ser capaz de revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si,¡Borralo!',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const params = {
                                id: this.recetaId
                            }
                            axios.post(`/recetas/${this.recetaId}`, {params, _method: 'delete'})
                            .then(respuesta =>{
                                this.$swal(
                                '¡Eliminado!',
                                'La receta ha sido eliminada.',
                                'success'
                            )

                            this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                            })
                            .catch(error => {
                                console.login(error);
                            });
                            
                    }
                })
            }
        }
    }
</script>