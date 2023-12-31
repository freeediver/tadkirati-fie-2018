@extends('Shared.Layouts.Master')

@section('title')
    Tableau de bord
@stop

@section('top_nav')
    @include('ManageOrganiser.Partials.TopNav')
@stop
@section('page_title')
    Tableau de bord de {{ $organiser->name }}
@stop

@section('menu')
    @include('ManageOrganiser.Partials.Sidebar')
@stop

@section('head')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    {!! HTML::script('https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places') !!}
    {!! HTML::script('vendor/geocomplete/jquery.geocomplete.min.js')!!}
    {!! HTML::script('vendor/moment/moment.js')!!}
    {!! HTML::script('vendor/fullcalendar/dist/fullcalendar.min.js')!!}
    {!! HTML::style('vendor/fullcalendar/dist/fullcalendar.css')!!}

    <script>
        $(function() {
           $('#calendar').fullCalendar({
               events: {!! $calendar_events !!},
            header: {
                left:   'prev,',
                center: 'title',
                right:  'next'
            },
            dayClick: function(date, jsEvent, view) {

               }
           });
        });
    </script>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>
                    {{$organiser->events->count()}}
                </h3>
            <span>
                Événements
            </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>
                    {{$organiser->attendees->count()}}
                </h3>
            <span>
                Billets vendus
            </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="stat-box">
                <h3>
                    {{ money($organiser->events->sum('sales_volume') + $organiser->events->sum('organiser_fees_volume'), $organiser->account->currency) }}
                </h3>
            <span>
                Volume des ventes
            </span>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8">

            <h4 style="margin-bottom: 25px;margin-top: 20px;">Calendrier des événements</h4>
                    <div id="calendar"></div>


            <h4 style="margin-bottom: 25px;margin-top: 20px;">évènements à venir</h4>
            @if($upcoming_events->count())
                @foreach($upcoming_events as $event)
                    @include('ManageOrganiser.Partials.EventPanel')
                @endforeach
            @else
                <div class="alert alert-success alert-lg">
                    Vous n'avez aucun événement à venir. <a href="#"
                                                     data-href="{{route('showCreateEvent', ['organiser_id' => $organiser->id])}}"
                                                     class=" loadModal">Vous pouvez cliquer ici pour créer un événement.</a>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <h4 style="margin-bottom: 25px;margin-top: 20px;">Dernières commandes</h4>
              @if($organiser->orders->count())
            <ul class="list-group">
                    @foreach($organiser->orders()->orderBy('created_at', 'desc')->take(5)->get() as $order)
                        <li class="list-group-item">
                            <h6 class="ellipsis">
                                <a href="{{ route('showEventDashboard', ['event_id' => $order->event->id]) }}">
                                    {{ $order->event->title }}
                                </a>
                            </h6>
                            <p class="list-group-text">
                                <a href="{{ route('showEventOrders', ['event_id' => $order->event_id, 'q' => $order->order_reference]) }}">
                                    <b>#{{ $order->order_reference }}</b></a> -
                                <a href="{{ route('showEventAttendees', ['event_id'=>$order->event->id,'q'=>$order->order_reference]) }}">{{ $order->full_name }}</a>
                                registered {{ $order->attendees()->withTrashed()->count() }} ticket{{ $order->attendees()->withTrashed()->count()  > 1 ? 's' : '' }}.
                            </p>
                            <h6>
                                {{ $order->created_at->diffForHumans() }} &bull; <span
                                        style="color: green;">{{ $order->event->currency_symbol }}{{ $order->amount }}</span>
                            </h6>
                        </li>
                    @endforeach
                  @else
                            <div class="alert alert-success alert-lg">
                                On dirait qu'il n'y a pas d'ordres récents.
                            </div>
                @endif
            </ul>

        </div>
    </div>
@stop
