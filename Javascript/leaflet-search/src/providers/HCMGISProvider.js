import JsonProvider from "./JsonProvider";

class HCMGISProvider extends JsonProvider {
    endpoint({query}) {
        const url = 'https://search.hcmgis.vn/search-address',
            params = {
                ...this.options.params,
                q: query
            }

        return this.getUrl(url, params);
    }

    parse({data}) {
        if (!data.hits) return [];

        return data.hits.map((r) => ({
            x: r._source.location.lon,
            y: r._source.location.lat,
            label: r._source.address_all,
            bounds: null, // CocCoc API does not provide bounds
            raw: r
        }));
    }
}

export default HCMGISProvider
