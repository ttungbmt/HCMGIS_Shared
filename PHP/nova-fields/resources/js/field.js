import VueTippy, { TippyComponent } from "vue-tippy";

Nova.booting((Vue, router, store) => {
    Vue.use(VueTippy)
    Vue.component('tippy', TippyComponent);

    Vue.component('index-nova-email-field', require('./components/Index/EmailField'));
    Vue.component('detail-nova-email-field', require('./components/Detail/EmailField'));
    Vue.component('form-nova-email-field', require('./components/Form/EmailField/EmailField'));

    Vue.component('index-nova-secret-field', require('./components/Index/SecretField'))
    Vue.component('detail-nova-secret-field', require('./components/Detail/SecretField'))
    Vue.component('form-nova-secret-field', require('./components/Form/SecretField'))

    Vue.component('index-nova-text-field', require('./components/Index/TextField'))
    Vue.component('detail-nova-text-field', require('./components/Detail/TextField'))
    Vue.component('form-nova-text-field', require('./components/Form/TextField'))

    Vue.component('index-nova-url-field', require('./components/Index/UrlField'));
    Vue.component('detail-nova-url-field', require('./components/Detail/UrlField'));
    Vue.component('form-nova-url-field', require('./components/Form/UrlField/UrlField'));

    Vue.component('detail-nova-key-value-field', require('./components/Detail/KeyValueField'))
    Vue.component('form-nova-key-value-field', require('./components/Form/KeyValueField/KeyValueField'))

    Vue.component('index-html-field', require('./components/Form/HtmlField'));
    Vue.component('detail-html-field', require('./components/Form/HtmlField'));
    Vue.component('form-html-field', require('./components/Form/HtmlField'));

    Vue.component('response-excel-modal', require('./components/Modals/ResponseExcelModal'))
})
