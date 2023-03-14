<template>
  <span>{{ fieldValue }}</span>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value
    },
  },
    mounted() {
       // this.field.value = new Intl.NumberFormat('sk-SK', { style: 'currency', currency: 'EUR' }).format( this.field.value )
      //console.log(this.field)
    },

}
</script>
