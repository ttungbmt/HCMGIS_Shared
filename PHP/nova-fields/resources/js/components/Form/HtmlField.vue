<template>
  <div v-html="field.html" :class="computedClass"></div>
</template>

<script>
export default {
  props: ['resource', 'resourceName', 'resourceId', 'field'],
  mounted() {
    this.field.fill = this.fill
  },
  computed: {
    computedClass(){
      let classes = ''
      if(this.field.wrapperClasses) classes += ' ' + this.field.wrapperClasses

      return _.trim(classes)
    }
  },
  methods: {
    fill(formData) {
      // nothing to fill, we're just an html field
    }
  }
}
</script>