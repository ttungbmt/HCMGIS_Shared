<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <div class="w-full flex flex-row items-center">
        <div class="w-full nalingia-secret-field__wrapper">
          <input
              :id="field.name"
              :type="inputType"
              :dusk="field.attribute"
              class="w-full form-control form-input form-input-bordered mr-3"
              :class="errorClasses"
              :placeholder="field.name"
              v-model="value"
              :disabled="isReadonly"
          />
          <div class="flex flex-row">
            <button ref="copyButton" v-if="copyToClipboard" type="button" v-tooltip.click="__('Copy')"
                    class="nalingia-secret-field__action text-70 hover:text-primary mr-3">
              <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path
                    d="M17 7h2.25c.97 0 1.75.78 1.75 1.75v10.5c0 .97-.78 1.75-1.75 1.75H8.75C7.78 21 7 20.22 7 19.25V17H4.75C3.78 17 3 16.22 3 15.25V4.75C3 3.78 3.78 3 4.75 3h10.5c.97 0 1.75.78 1.75 1.75V7zm-2 0V5H5v10h2V8.75C7 7.78 7.78 7 8.75 7H15zM9 9v10h10V9H9z"/>
              </svg>
            </button>
            <button v-if="generator" type="button" v-tooltip.click="__('Generate')"
                    class="nalingia-secret-field__action text-70 hover:text-primary mr-3" @click="generateString">
              <svg class="fill-current" width="24" height="24" xmlns="http://www.w3.org/2000/svg"
                   xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 85.168 85.168">
                <path d="M61.696,14.999l-4.126,4.457c8.806,5.774,13.923,16.353,12.184,27.41c-1.146,7.288-5.063,13.694-11.027,18.037
                  c-5.206,3.791-11.43,5.615-17.777,5.252l1.09-1.144c-0.021-0.001-0.044,0.002-0.065,0.001l4.129-4.332l-3.813-3.639l-8.188,8.596
                  l-0.002-0.003l-3.533,3.71l3.811,3.636l0.002-0.001l8.593,8.189l3.536-3.71l-5.565-5.302c7.616,0.36,15.066-1.853,21.315-6.403
                  c7.261-5.286,12.028-13.084,13.424-21.956C77.741,34.694,71.897,22.14,61.696,14.999z"/>
                <path d="M15.415,38.302c1.146-7.288,5.063-13.694,11.027-18.037c5.206-3.791,11.43-5.615,17.777-5.252l-1.09,1.144
              c0.021,0.001,0.044-0.002,0.065-0.001l-4.129,4.332l3.813,3.639l8.188-8.596l0.002,0.003l3.533-3.71L50.79,8.188l-0.002,0.001
              L42.195,0l-3.536,3.71l5.565,5.302c-7.616-0.36-15.066,1.853-21.315,6.403c-7.261,5.286-12.028,13.084-13.424,21.956
              C7.425,50.475,13.27,63.029,23.47,70.17l4.126-4.457C18.793,59.937,13.676,49.359,15.415,38.302z"/>
              </svg>
            </button>
            <button v-tooltip.click="__('Show')" v-if="field.showMask" type="button"
                    class="nalingia-secret-field__action text-70 hover:text-primary" @mousedown="handleMouseDown"
                    @mouseup="handleMouseUp">
              <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path
                    d="M17.56 17.66a8 8 0 0 1-11.32 0L1.3 12.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95zm-9.9-1.42a6 6 0 0 0 8.48 0L20.38 12l-4.24-4.24a6 6 0 0 0-8.48 0L3.4 12l4.25 4.24zM11.9 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </template>
  </default-field>
</template>

<script>
import Clipboard from 'clipboard';
import {generate} from 'generate-password';
import {defaultTo} from 'lodash-es';

import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],
  props: ['resourceName', 'resourceId', 'field'],
  computed: {
    inputType: function () {
      return this.masked ? 'password' : 'text';
    },
    copyToClipboard: function () {
      return !!this.field.showCopyToClipboard;
    },
    generator: function () {
      return !!this.field.showGenerator;
    },
  },
  data() {
    return {
      value: this.field.value || '',
      masked: defaultTo(this.field.showMask, false),
      clipboardEl: null,
    };
  },
  mounted() {
    if (this.$refs.copyButton) {
      const clipboardEl = new Clipboard(this.$refs.copyButton, {
        text: () => this.value,
        action: () => 'copy'
      });

      clipboardEl.on('success', (e) => {
        this.$toasted.show(this.__('Copied!'), {type: 'success'});
      });
      clipboardEl.on('error', () => {
        this.$toasted.show(this.__('Error occured while copying!'), {type: 'error'});
      });
      this.clipboardEl = clipboardEl;
    }
  },
  destroyed() {
    if (this.clipboardEl) {
      this.clipboardEl.destroy();
    }
  },
  methods: {
    handleInputChange(event) {
      this.value = event.target.value;
    },
    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
    },
    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value
    },
    handleMouseDown() {
      this.masked = false;
    },
    handleMouseUp() {
      this.masked = true;
    },
    generateString() {
      this.value = generate(this.field.generatorOptions || {});
    },
  },
}
</script>