<?php

namespace App\Http\Livewire;

use App\Services\WeatherWidgetService;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

use Stevebauman\Location\Facades\Location;

class Index extends Component
{ 
    public $search = "";
    public $data = null;
    public $lat = null;
    public $lon = null;
    public $tempUnit = "metric";
    protected $listeners = [
        'set-place'      => 'getSearchedLocationWeather',
    ];

    public function mount()
    {
        $service = new WeatherWidgetService();
        $this->data = $service->getUserCurrentLocation(null,null,$this->tempUnit);
    }
    public function getWeatherDetails()
    {
        $service = new WeatherWidgetService();
        $this->data = $service->getUserCurrentLocation($this->lat,$this->lon,$this->tempUnit);
    }
    public function render()
    {
        
        return view('livewire.index');
    }

    public function getSearchedLocationWeather($place)
    {
        $this->search = $place ? $place["geometry"]["location"]: null;
        $this->lat  =  $this->search["lat"];
        $this->lon  =  $this->search["lng"];
        $service = new WeatherWidgetService();
        $this->data = $service->getUserCurrentLocation( $this->lat, $this->lon,$this->tempUnit);
    }
    
}
