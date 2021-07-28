<template>
  <modal @modal-close="handleClose">
    <form
        slot-scope="props"
        class="bg-white rounded-lg shadow-lg overflow-hidden"
        style="width: 650px"
    >
      <slot>
        <div class="p-8">
          <heading :level="2" class="mb-6">{{ __('Validation Errors') }}</heading>

          <div>
            <div v-for="key in Object.keys(errors.all())" :key="key">
              <div v-for="(error, index) in errors.get(key)" :key="index">
                <p class="error-text pb-1 text-danger">{{ error }}</p>
              </div>
            </div>
          </div>
        </div>
      </slot>

      <div class="bg-30 px-6 py-3 flex">
        <div class="ml-auto">
          <button
              ref="cancelButton"
              type="button"
              data-testid="cancel-button"
              @click.prevent="handleClose"
              class="btn btn-default btn-primary"
          >
            {{ __('Cancel') }}
          </button>
        </div>
      </div>
    </form>
  </modal>
</template>

<script>
import {Errors, FormField} from 'laravel-nova'

export default {
  props: {
    data: {
      type: Object,
    },
  },

  data() {
    return {
      errors: new Errors(this.data.errors ? this.data.errors : [])
    }
  },

  /**
   * Mount the component.
   */
  mounted() {
    this.$refs.cancelButton.focus()
  },

  methods: {
    handleClose() {
      this.$emit('close')
      this.working = false
    },
  },
}
</script>
