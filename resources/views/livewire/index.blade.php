<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-8 grid-margin stretch-card">
                <!--weather card-->
                <div class="card card-weather">
                    <div class="card-body">
                        <div class="weather-date-location" >
                           <div class=" float-right" > <select class="w-1/2 white" name="type" id="" wire:model="tempUnit" wire:change="getWeatherDetails">
                            <option value="">Select Temperature unit </option>
                            <option value="metric">Celsius </option>
                            <option value="imperial">Fahrenheit</option>
                        </select>
                        <input type="text" id="location" name="location" class="w-1/2 rounded " ></div>
                            <h3>{{\Carbon\Carbon::now()->format('l')}}</h3>
                            <p class="text-gray"> <span class="weather-date">{{ \Carbon\Carbon::now()->format('g:i A')}} {{
                                \Carbon\Carbon::now()->format('l, M y')}}</span> <span class="weather-location"><h4>{{ isset($data["name"]) ? $data["name"] : "Search Some thing" }}</h4></span> </p>
                        </div>
                     
                        <div class="weather-data d-flex">
                            <div class="mr-auto">
                                <h4 class="display-3">{{ isset($data['main']['temp']) ? $data['main']['temp'] :0
                                }}<span class="symbol">°</span>{{ $tempUnit == "metric" ? 'C' :  'F' }}</span></h4>
                                <p> <span class="mb-1">{{ isset($data["weather"][0]) ?$data["weather"][0]["main"] : "" }}</span>  
                                    <img src="http://openweathermap.org/img/w/{{isset($data["weather"][0]) ? $data["weather"][0]['icon'].'.png' : '50n.png' }}" class="mt-1"/> </p>
                                <p class="display-3">Air Quality : {{ isset($data["air_quality"]) ?$data["air_quality"] :""  }}</p>
                            </div>
                            
                        </div>
                       
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex weakly-weather">
                            <div class="weakly-weather-item">
                                <p class="mb-0"> Feels Like </p> <i class="mdi mdi-weather-cloudy"></i>
                                <p class="mb-0"> {{ isset($data['main']['feels_like']) ? $data['main']['feels_like'] :
                                    "0" }}
                                    <span class="symbol">°</span>{{ $tempUnit == "metric" ? 'C' :  'F' }}</span> </p>
                            </div>
                            <div class="weakly-weather-item">
                                <p class="mb-1"> Temp Min </p> <i class="mdi mdi-weather-hail"></i>
                                <p class="mb-0"> {{ isset($data['main']['temp_min']) ? $data['main']['temp_min'] : "0"
                                }}
                                <span class="symbol">°</span>{{ $tempUnit == "metric" ? 'C' :  'F' }}</span> </p>
                            </div>
                            <div class="weakly-weather-item">
                                <p class="mb-1"> Temp Max </p> <i class="mdi mdi-weather-partlycloudy"></i>
                                <p class="mb-0">{{ isset($data['main']['temp_max']) ? $data['main']['temp_max'] : "0"
                                }}
                                <span class="symbol">°</span>{{ $tempUnit == "metric" ? 'C' :  'F' }}</span> </p>
                            </div>
                            <div class="weakly-weather-item">
                                <p class="mb-1"> Pressure </p> <i class="mdi mdi-weather-pouring"></i>
                                <p class="mb-0"> {{ isset($data['main']['pressure']) ? $data['main']['pressure'] : "0"
                                }} hPa </p>
                            </div>
                            <div class="weakly-weather-item">
                                <p class="mb-1"> Clouds </p> <i class="mdi mdi-weather-pouring"></i>
                                <p class="mb-0"> {{ isset($data['clouds']['all']) ? $data['clouds']['all'] : "0" }} % </p>
                            </div>
                            <div class="weakly-weather-item">
                                <p class="mb-1"> Humidity </p> <i class="mdi mdi-weather-snowy-rainy"></i>
                                <p class="mb-0"> {{ isset($data["main"]["humidity"]) ? $data["main"]["humidity"] : 0
                                }} % </p>
                            </div>
                            <div class="weakly-weather-item">
                                <p class="mb-1"> Wind  </p> <i class="mdi mdi-weather-snowy"></i>
                                <p class="mb-0"> {{ isset($data['wind']['speed']) ? $data['wind']['speed'] : "0"
                                }} m/s </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--weather card ends-->
            </div>
        </div>
    </div>
</div>
@push('javascript')
<script>
    function initMap() {
        var input = document.getElementById('location');
        var autocomplete = new google.maps.places.Autocomplete(input,{types: ['(cities)']});
        google.maps.event.addListener(autocomplete, 'place_changed', function(){
           var place = autocomplete.getPlace();
          livewire.emit('set-place', place)
        })
      }
</script>

@endpush