<script>
    import { optionsMerger, propsBinder, ControlMixin, OptionsMixin } from 'vue2-leaflet';
    import { control } from 'leaflet';
    import {findRealParent} from "vue2-leaflet";
    /**
     * Add any custom component as a leaflet control-scale
     */
    export default {
        name: 'LControlScale',
        mixins: [ControlMixin, OptionsMixin],
        props: {
            maxWidth: {
                type: Number,
                default: 100,
            },
            metric: {
                type: Boolean,
                default: true,
            },
            imperial: {
                type: Boolean,
                default: true,
            },
            updateWhenIdle: {
                type: Boolean,
                default: false,
            },
        },
        mounted() {
            const options = optionsMerger(
                {
                    ...this.controlOptions,
                    maxWidth: this.maxWidth,
                    metric: this.metric,
                    imperial: this.imperial,
                    updateWhenIdle: this.updateWhenIdle,
                },
                this
            );
            this.mapObject = control.scale(options);
            propsBinder(this, this.mapObject, this.$options.props);
            this.parentContainer = findRealParent(this.$parent);
            this.mapObject.addTo(this.parentContainer.mapObject);
            this.$nextTick(() => {
                /**
                 * Triggers when the component is ready
                 * @type {object}
                 * @property {object} mapObject - reference to leaflet map object
                 */
                this.$emit('ready', this.mapObject);
            });
        },
        render() {
            return null;
        },
    };
</script>