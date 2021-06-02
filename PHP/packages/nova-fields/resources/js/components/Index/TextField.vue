<template>
  <div :class="`text-${field.textAlign}`">
    <template v-if="hasValue">
      <div v-if="field.asHtml" v-html="field.value"></div>
      <a v-else-if="hasUrl" :href="field.url" class="no-underline dim text-primary font-bold" :target="target">{{ field.value }}</a>
      <router-link v-else-if="hasRouter" class="no-underline dim text-primary font-bold" :to="field.router" :target="target">{{ field.value }}</router-link>
      <button v-else-if="field.tooltip && tippyContent" :content="tippyContent" v-tippy>{{ field.value }}</button>
      <span v-else class="whitespace-no-wrap">{{ field.value }}</span>
    </template>
    <p v-else>&mdash;</p>
  </div>
</template>

<script>
import {defaultTo, isNil} from 'lodash-es'

export default {
  props: ['resourceName', 'field'],

  data: function (){
      return {
        target: defaultTo(this.field.target, '_self')
      }
  },

  computed: {
    /**
     * Determine if the field has a value other than null.
     */
    hasValue() {
      return this.field.value !== null
    },

    hasUrl() {
      return !isNil(this.field.url)
    },

    hasRouter() {
      return !isNil(this.field.router)
    },

    tippyContent() {
      return defaultTo(this.field.tooltip.content, this.field.value)
    }
  },
}
</script>
