<script>
    import { optionsMerger, propsBinder, ControlMixin, OptionsMixin, findRealParent } from 'vue2-leaflet';
    import { control } from 'leaflet';
    import 'leaflet.locatecontrol'
    import 'leaflet.locatecontrol/dist/L.Control.Locate.css'

    /**
     * Add any custom component as a leaflet control-fullscrren
     */
    export default {
        name: 'LControlLocate',
        mixins: [ControlMixin, OptionsMixin],
        props: {
            position: {
                type: String,
                default: 'bottomright'
            },
            icon: String
        },
        mounted() {
            const options = optionsMerger({
                ...this.controlOptions,
                icon: this.icon
            }, this);

            this.mapObject = control.locate(options);
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