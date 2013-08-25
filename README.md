Geoplugin
===============

Module to return a user's geolocation information via the GeoPlugin service (http://www.geoplugin.com/).

Installation
-----

In your system/expressionengine/third_party directory run the following command (you can also manually extract the files into cl_geoplugin).

```
git clone https://github.com/cleverlever/cl_geoplugin.git
```

Usage
-----

### {exp:cl_geoplugin:locate}

Locates a user.

#### Parameters

+ ip_address (default: user's ip_address)

  An ip address to geolocate.

#### Variables

```
{ip}
{city}
{region} (two character state)
{area_code}
{dma_code}
{country_name}
{country_code}
{continent_code}
{latitude}
{longitude}
{currency_code}
{currency_symbol}
{currency_converter}
{nearby}
    {nearby_city}
    {nearby_region}
    {nearby_country_code}
    {nearby_latitude}
    {nearby_longitude}
{/nearby}
```

#### Examples

In your template this is how you'd get the current user's city and state.

```
{exp:cl_geoplugin:locate}
You are in {city}, {region}.
{/exp:cl_geoplugin:locate}
```

```
You are in Seattle, WA.
```

### {exp:cl_geoplugin:variable}

Returns any of the variables available via the {exp:cl_geoplugin:locate} tag pair.

#### Parameters

+ ip_address (default: user's ip_address)

  An ip address to geolocate.

#### Examples

In your template this is how you'd get the current user's currency symbol.

```
{exp:cl_geoplugin:currency_symbol}
```

```
$
```

### {exp:cl_geoplugin:is_nearby}

Returns true or false whether the specified ip_address is in the nearby list that GeoPlugin provides.

#### Parameters

+ ip_address (default: user's ip_address)

  An ip address to geolocate.

+ city (required if lat/long not set)

  A city you are trying to see if is nearby what was geolocated.

+ region (required if lat/long not set)

  A region (two character state) you are trying to see if is nearby what was geolocated.

+ country_code (required if lat/long not set)

  A country code (two character) you are trying to see if is nearby what was geolocated.

+ radius (default: 10)

  Distance in miles from the geolocated ip_address to find nearby locations.
  
+ limit (default: 100)

  Used to limit the results since we are comparing a listing. In dense areas you might need to set it even higher.
