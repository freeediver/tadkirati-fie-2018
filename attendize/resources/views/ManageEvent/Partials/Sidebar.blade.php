<aside class="sidebar sidebar-left sidebar-menu">
    <section class="content">
        <h5 class="heading">Menu principal</h5>
        <ul id="nav_main" class="topmenu">
            <li>
                <a href="{{route('showOrganiserDashboard', ['organiser_id' => $event->organiser->id])}}">
                    <span class="figure"><i class="ico-arrow-left"></i></span>
                    <span class="text">Retour à {{$event->organiser->name}}</span>
                </a>
            </li>
        </ul>
        <h5 class="heading">Menu de l'événement</h5>
        <ul id="nav_event" class="topmenu">
            <li class="{{ Request::is('*dashboard*') ? 'active' : '' }}">
                <a href="{{route('showEventDashboard', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-home2"></i></span>
                    <span class="text">Tableau de bord</span>
                </a>
            </li>
            <li class="{{ Request::is('*tickets*') ? 'active' : '' }}">
                <a href="{{route('showEventTickets', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-ticket"></i></span>
                    <span class="text">Tickets</span>
                </a>
            </li>
            <li class="{{ Request::is('*orders*') ? 'active' : '' }}">
                <a href="{{route('showEventOrders', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-cart"></i></span>
                    <span class="text">Commandes</span>
                </a>
            </li>
            <li class="{{ Request::is('*attendees*') ? 'active' : '' }}">
                <a href="{{route('showEventAttendees', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-user"></i></span>
                    <span class="text">Participants</span>
                </a>
            </li>
            <li class="{{ Request::is('*promote*') ? 'active' : '' }} hide">
                <a href="{{route('showEventPromote', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-bullhorn"></i></span>
                    <span class="text">Promouvoir</span>
                </a>
            </li>
            <li class="{{ Request::is('*customize*') ? 'active' : '' }}">
                <a href="{{route('showEventCustomize', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-cog"></i></span>
                    <span class="text">Personnaliser</span>
                </a>
            </li>
        </ul>
        <h5 class="heading">Outils d'événement</h5>
        <ul id="nav_event" class="topmenu">
            <li class="{{ Request::is('*check_in*') ? 'active' : '' }}">
                <a href="{{route('showChechIn', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-checkbox-checked"></i></span>
                    <span class="text">Check-In</span>
                </a>
            </li>
            <li class="{{ Request::is('*surveys*') ? 'active' : '' }}">
                <a href="{{route('showEventSurveys', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-question"></i></span>
                    <span class="text">Sondages</span>
                </a>
            </li>
            <li class="{{ Request::is('*widgets*') ? 'active' : '' }}">
                <a href="{{route('showEventWidgets', array('event_id' => $event->id))}}">
                    <span class="figure"><i class="ico-code"></i></span>
                    <span class="text">Widgets</span>
                </a>
            </li>
    </section>
</aside>
