<script>
    import {optionsMerger, propsBinder, ControlMixin, OptionsMixin, findRealParent} from 'vue2-leaflet';
    import '@geoman-io/leaflet-geoman-free';
    import '@geoman-io/leaflet-geoman-free/dist/leaflet-geoman.css';
    import {PM, DomEvent} from "leaflet";
    import {get, transform} from "lodash-es";

    const options = (new PM.Toolbar).options

    const props = transform({
        drawMarker: Boolean,
        drawCircleMarker: Boolean,
        drawPolyline: Boolean,
        drawRectangle: Boolean,
        drawPolygon: Boolean,
        drawCircle: Boolean,
        editMode: Boolean,
        dragMode: Boolean,
        cutPolygon: Boolean,
        removalMode: Boolean,
        oneBlock: Boolean,
        drawControls: Boolean,
        editControls: Boolean,
        customControls: Boolean,
        optionsControls: Boolean,
        pinningOption: Boolean,
        snappingOption: Boolean,
    }, (result, value, key) => {
        result[key] = {
            type: value,
            default: get(options, key, false)
        }
        return result
    }, {})

    /**
     * Add any custom component as a leaflet control-fullscrren
     */
    export default {
        name: 'LControlGeoman',
        mixins: [ControlMixin, OptionsMixin],
        props,
        mounted() {
            const options = optionsMerger({
                ...this.controlOptions,
                ...transform(props, (result, value, key) => {
                    result[key] = this[key]
                }, {})
            }, this);

            this.parentContainer = findRealParent(this.$parent);
            this.mapObject = this.parentContainer.mapObject.pm;
            this.mapObject.remove = this.mapObject.removeControls
            DomEvent.on(this.parentContainer.mapObject, this.$listeners);
            propsBinder(this, this.mapObject, this.$options.props);
            this.mapObject.addControls(options);

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