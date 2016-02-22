@extends('layout')

@section('content')
    <h1><i class="search icon"></i> Find a place to stay</h1>

    <form method="get" class="ui form">
        <input name="_token" type="hidden" value="{{csrf_token()}}" />

        <div class="two fields">
            <div class="field">
                <label for="location">Location</label>
                <input name="location" id="location" type="text" value="{{request('location')}}">
            </div>
            <div class="field">
                <label for="availability">Availability (From - To)</label>
                <div class="ui two columns grid">
                    <div class="row">
                        {{-- Teoretically, I should be using a datepicker plugin, but for the sake of quickness I'll just use the HTML5 inputs --}}
                        <div class="column">
                            <input value="{{request('availability.from')}}" name="availability[from]" id="availability" type="date">
                        </div>
                        <div class="column">
                            <input value="{{request('availability.to')}}" name="availability[to]" id="availability" type="date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="two fields">
            <div class="field">
                <label for="minimum_sleeps">Minimum sleeps</label>
                <input name="minimum_sleeps" id="minimum_sleeps" type="number" value="{{request('minimum_sleeps')}}">
            </div>
            <div class="field">
                <label for="minimum_beds">Minimum sleeps</label>
                <input name="minimum_beds" id="minimum_beds" type="number" value="{{request('minimum_beds')}}">
            </div>
        </div>
        <div class="ui checkbox">
            <input {{request()->has('near_beach') ? 'checked' : ''}} id="near_beach" name="near_beach" type="checkbox">
            <label for="near_beach">
                Near the beach
            </label>
        </div>
        <div style="margin-left:15px;" class="ui checkbox">
            <input {{request()->has('accepts_pets') ? 'checked' : ''}} id="accepts_pets" name="accepts_pets" type="checkbox">
            <label for="accepts_pets">
                Accepts pets
            </label>
        </div>

        <br>
        <button style="margin-top:20px;" class="ui blue big labeled icon button"><i class="search icon"></i> Let's find some</button>
    </form>


    @if($properties !== false)
        <h2 class="ui diving header">We found {{$properties->total()}} properties.</h2>

        @if ($properties->count())
            <table class="ui table">
                <thead>
                    <th>Name</th>
                </thead>
                <tbody>
                    @foreach($properties as $property)
                        <tr>
                            <td>{{$property->property_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {!!$properties->appends(request()->input())->render()!!}
        @else
            <div class="ui warning message">
                <div class="header">Sorry</div>

                <p>We don't have anything that matches your search at the moment :-(</p>
            </div>
        @endif
    @endif
@stop