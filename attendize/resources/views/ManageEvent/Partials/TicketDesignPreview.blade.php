{!! HTML::style(asset('assets/stylesheet/ticket.css')) !!}
<style>
    .ticket {
        border: 1px solid {{$event->ticket_border_color}};
        background: {{$event->ticket_bg_color}} ;
        color: {{$event->ticket_sub_text_color}};
        border-left-color: {{$event->ticket_border_color}} ;
    }
    .ticket h4 {color: {{$event->ticket_text_color}};}
    .ticket .logo {
        border-left: 1px solid {{$event->ticket_border_color}};
        border-bottom: 1px solid {{$event->ticket_border_color}};

    }
</style>
<div class="ticket">
    <div class="logo">
        {!! HTML::image(asset($image_path)) !!}
    </div>

    <div class="event_details">
        <h4>Evénement</h4>Evénement de démonstration<h4>Organisateur</h4>Organisateur de démonstration<h4>Lieu</h4>Emplacement de démonstration<h4>Date de début / Temps</h4>
        Mar 18th 4:08PM
        <h4>Date de fin / Temps</h4>
        Mar 18th 5:08PM
    </div>

    <div class="attendee_details">
        <h4>Nom</h4>Example nom<h4>Type de billet</h4>
        Ordinaire
        <h4>Réf. de la commande</h4>
        #YLY9U73
        <h4>Réf. du participant</h4>
        #YLY9U73-1
        <h4>Prix</h4>
        200DZD
    </div>

    <div class="barcode">
        {!! DNS2D::getBarcodeSVG('hello', "QRCODE", 6, 6) !!}
    </div>
    @if($event->is_1d_barcode_enabled)
        <div class="barcode_vertical">
            {!! DNS1D::getBarcodeSVG(12211221, "C39+", 1, 50) !!}
        </div>
    @endif
</div>
