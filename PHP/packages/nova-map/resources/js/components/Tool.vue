<template>
    <loading-card class="rounded flex flex-col overflow-hidden" :loading="loading" :style="style">
        <l-map class="z-10" ref="map" v-bind="mapOptions" v-if="!loading">
            <l-manager :layers="layers" :controls="controls"></l-manager>
            <feature-info :layers="layers"></feature-info>
        </l-map>
    </loading-card>
</template>

<script>
    import FeatureInfo from './FeatureInfo'
    import {getBounds} from '@ttungbmt/vue-leaflet-helper'
    import {formatLayers} from '../utils/utils'

    export default {
        name: 'NovaMap',
        props: ['tool',],
        components: {
            'feature-info': FeatureInfo
        },
        data() {
            return {
                loading: true,
                style: {
                    height: '500px'
                },
                mapOptions: {
                    zoom: 11,
                    center: [10.240095, 106.373147],
                    bounds: undefined,
                    options: {
                        zoomControl: false
                    }
                },
                controls: {},
                layers: []
            }
        },
        computed: {},
        mounted() {
            this.handleResizeCard()
        },
        async created() {
            await this.getData();
            this.loading = false
        },
        methods: {
            getData() {
                return window.axios
                    .get('/nova-vendor/nova-map/data')
                    .then(response => response.data)
                    .then(({config, layers, controls, boundary, extent}) => {
                        this.layers = formatLayers(layers, boundary)
                        this.controls = controls

                        this.mapOptions = Object.assign(this.mapOptions, config)
                        extent && this.$set(this.mapOptions, 'bounds', getBounds(extent))
                    })
                    .catch(e => {
                        console.log(e)
                        this.$toasted.show(
                            this.__('Error reading data. Please check your logs'),
                            {type: 'error'}
                        );
                    });
            },
            updateMapSize() {
                this.$nextTick(() => {
                    this.$refs.map.mapObject.invalidateSize()
                })
            },
            handleResizeCard() {
                let hContent = window.innerHeight,
                    hHeader = document.querySelector('.h-header').clientHeight,
                    subSize = 20

                this.style.height = (hContent - (hHeader + subSize)) + 'px'
            },
        }
    }
</script>
