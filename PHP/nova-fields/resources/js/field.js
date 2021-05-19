import VueTippy, { TippyComponent } from "vue-tippy";

Nova.booting((Vue, router, store) => {
    Vue.use(VueTippy)
    Vue.component('tippy', TippyComponent);

    Vue.component('index-nova-email-field', require('./components/email/IndexField'));
    Vue.component('detail-nova-email-field', require('./components/email/DetailField'));
    Vue.component('form-nova-email-field', require('./components/email/FormField'));

    Vue.component('index-nova-secret-field', require('./components/secret/IndexField'))
    Vue.component('detail-nova-secret-field', require('./components/secret/DetailField'))
    Vue.component('form-nova-secret-field', require('./components/secret/FormField'))

    Vue.component('index-nova-text-field', require('./components/text/IndexField'))
    Vue.component('detail-nova-text-field', require('./components/text/DetailField'))
    Vue.component('form-nova-text-field', require('./components/text/FormField'))

    Vue.component('index-nova-url-field', require('./components/url/IndexField'));
    Vue.component('detail-nova-url-field', require('./components/url/DetailField'));
    Vue.component('form-nova-url-field', require('./components/url/FormField'));

    Vue.component('detail-nova-key-value-field', require('./components/Detail/KeyValueField.vue'))
    Vue.component('form-nova-key-value-field', require('./components/Form/KeyValueField/KeyValueField.vue'))
})
