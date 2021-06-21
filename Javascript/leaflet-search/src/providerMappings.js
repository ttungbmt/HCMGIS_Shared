import {
    AlgoliaProvider,
    BingProvider,
    EsriProvider,
    GoogleProvider,
    HereProvider,
    LocationIQProvider,
    OpenCageProvider,
    OpenStreetMapProvider
} from 'leaflet-geosearch'

import Map4DProvider from './providers/Map4DProvider'

export default {
    'algolia': AlgoliaProvider,
    'bing': BingProvider,
    'esri': EsriProvider,
    'google': GoogleProvider,
    'here': HereProvider,
    'locationiq': LocationIQProvider,
    'opencage': OpenCageProvider,
    'openstreetmap': OpenStreetMapProvider,
    'map4d': Map4DProvider,
}

