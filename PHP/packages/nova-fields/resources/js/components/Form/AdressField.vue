<template>
  <default-field :field="field" :show-help-text="showHelpText" :errors="errors">
    <template slot="field">
      <multiselect
          @input="handleChange"
          @search-change="tryToFetchOptions"
          track-by="value"
          label="label"
          ref="multiselect"
          :value="selected"
          :options="options"
          :internal-search="!field.apiUrl"
          :class="errorClasses"
          :disabled="isReadonly"
          :placeholder="field.placeholder || field.name"
          :max="max || field.max || null"
          :optionsLimit="field.optionsLimit || 1000"
          :limitText="count => __('novaMultiselect.limitText', { count: String(count || '') })"
          selectLabel=""
          :loading="isLoading"
          selectGroupLabel=""
          selectedLabel=""
          deselectLabel=""
          deselectGroupLabel=""
          :clearOnSelect="field.clearOnSelect || false"
      />
    </template>
  </default-field>
</template>
<script>
import Multiselect from 'vue-multiselect'
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resource', 'resourceName', 'resourceId', 'field'],

  components: {
    Multiselect
  },

  data() {
    return {
      isLoading: false,
      options: []
    }
  },

  mounted() {

  },
  computed: {
    selected() {
      return this.value || [];
    },
  },

  methods: {
    setInitialValue() {
      this.value = this.getValueFromOptions(this.field.value);
    },

    fill(formData) {
      formData.append(this.field.attribute, (this.value && this.value.value) || '');
    },

    handleChange(value) {
      this.value = value;
      !_.isEmpty(value.geom_value) && Nova.$emit(`map-geom-input`, value.geom_value);
    },

    fetchOptions: _.debounce(async function (search) {
      const {data} = await Nova.request().get(`${this.field.apiUrl}`, {params: {search}});
      // Response is not an array or an object
      if (typeof data !== 'object') throw new Error('Server response was invalid.');
      // Is array
      if (Array.isArray(data)) {
        this.options = data;
        this.isLoading = false;
        return;
      }
      // Nova resource response
      if (data.resources) {
        this.options = data.resources.map(v => ({
          value: v.id.value,
          label: v.title,
          geom_value: _.chain(v.fields).filter(i => i.attribute === 'geom').get('0.value').value()
        }));
        this.isLoading = false;
        return;
      }
      this.options = Object.entries(data).map(entry => ({label: entry[1], value: entry[0]}));
      this.isLoading = false;
    }, 500),

    tryToFetchOptions(query) {
      if (!this.field.apiUrl) return;
      if (query.length >= 1) {
        this.options = [];
        this.isLoading = true;
        try {
          this.fetchOptions(query);
        } catch (error) {
          console.error('Error performing search:', error);
        }
      } else {
        this.options = [];
      }
    },

    getValueFromOptions(value) {
      let options = this.field.options || [];

      return options.find(opt => String(opt.value) === String(value));
    },
  }
}
</script>