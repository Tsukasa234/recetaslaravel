<template>
    <span> {{formatearFecha}}</span>
</template>

<script>
    export default {
        props: ['fecha'],
        // mounted() {
        //     console.log('se recibio el valor de ', this.fecha);
        // },
        computed: {
            formatearFecha(){
                return moment(this.fecha).locale('es').format('DD [de] MMMM [del] YYYY');
            }
        }
    }
</script>