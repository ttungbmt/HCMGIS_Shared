<script>
    import {optionsMerger, propsBinder, ControlMixin, OptionsMixin, findRealParent} from 'vue2-leaflet';
    import {control} from 'leaflet';
    import 'leaflet.polylinemeasure'
    import 'leaflet.polylinemeasure/Leaflet.PolylineMeasure.css'

    /**
     * Add any custom component as a leaflet control-fullscrren
     */
    export default {
        name: 'LControlMeasure',
        mixins: [ControlMixin, OptionsMixin],
        props: {
            clearMeasurementsOnStop: {
                type: Boolean,
                default: true
            },
            showBearings: Boolean,
            measureControlLabel: String,
            measureControlClasses: Array,
            showClearControl: Boolean,
            showUnitControl: Boolean,
        },
        mounted() {
            const options = optionsMerger({
                ...this.controlOptions,
                clearMeasurementsOnStop: this.clearMeasurementsOnStop,
                showBearings: this.showBearings,
                measureControlLabel: this.measureControlLabel,
                measureControlClasses: this.measureControlClasses,
                showClearControl: this.showClearControl,
                showUnitControl: this.showUnitControl,
            }, this);

            this.mapObject = control.polylineMeasure(options);
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