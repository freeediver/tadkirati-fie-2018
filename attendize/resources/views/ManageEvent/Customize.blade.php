{{-- @todo Rewrite the JS for choosing event bg images and colours. --}}
@extends('Shared.Layouts.Master')

@section('title')
    Personnaliser l'événement
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <i class="ico-cog mr5"></i>
    Personnaliser l'événement
@stop

@section('page_header')
    <style>
        .page-header {
            display: none;
        }
    </style>
@stop

@section('head')
    {!! HTML::script('https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places') !!}
    {!! HTML::script('vendor/geocomplete/jquery.geocomplete.min.js') !!}
    <script>
        $(function () {

            $("input[name='organiser_fee_percentage']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                verticalbuttons: true,
                postfix: '%',
                buttondown_class: "btn btn-link",
                buttonup_class: "btn btn-link",
                postfix_extraclass: "btn btn-link"
            });
            $("input[name='organiser_fee_fixed']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.1,
                decimals: 2,
                verticalbuttons: true,
                postfix: '{{$event->currency->symbol_left}}',
                buttondown_class: "btn btn-link",
                buttonup_class: "btn btn-link",
                postfix_extraclass: "btn btn-link"
            });

            /* Affiliate generator */
            $('#affiliateGenerator').on('keyup', function () {
                var text = $(this).val().replace(/\W/g, ''),
                        referralUrl = '{{$event->event_url}}?ref=' + text;

                $('#referralUrl').toggle(text !== '');
                $('#referralUrl input').val(referralUrl);
            });

            /* Background selector */
            $('.bgImage').on('click', function (e) {
                $('.bgImage').removeClass('selected');
                $(this).addClass('selected');
                $('input[name=bg_image_path_custom]').val($(this).data('src'));

                var replaced = replaceUrlParam('{{route('showEventPagePreview', ['event_id'=>$event->id])}}', 'bg_img_preview', $('input[name=bg_image_path_custom]').val());
                document.getElementById('previewIframe').src = replaced;
                e.preventDefault();
            });

            /* Background color */
            $('input[name=bg_color]').on('change', function (e) {
                var replaced = replaceUrlParam('{{route('showEventPagePreview', ['event_id'=>$event->id])}}', 'bg_color_preview', $('input[name=bg_color]').val().substring(1));
                document.getElementById('previewIframe').src = replaced;
                e.preventDefault();
            });

            $('#bgOptions .panel').on('shown.bs.collapse', function (e) {
                var type = $(e.currentTarget).data('type');
                console.log(type);
                $('input[name=bg_type]').val(type);
            });

            $('input[name=bg_image_path], input[name=bg_color]').on('change', function () {
                //showMessage('Uploading...');
                //$('.customizeForm').submit();
            });

            /* Color picker */
            $('.colorpicker').minicolors();

            $('#ticket_design .colorpicker').on('change', function (e) {
                var borderColor = $('input[name="ticket_border_color"]').val();
                var bgColor = $('input[name="ticket_bg_color"]').val();
                var textColor = $('input[name="ticket_text_color"]').val();
                var subTextColor = $('input[name="ticket_sub_text_color"]').val();

                $('.ticket').css({
                    'border': '1px solid ' + borderColor,
                    'background-color': bgColor,
                    'color': subTextColor,
                    'border-left-color': borderColor
                });
                $('.ticket h4').css({
                    'color': textColor
                });
                $('.ticket .logo').css({
                    'border-left': '1px solid ' + borderColor,
                    'border-bottom': '1px solid ' + borderColor
                });
                $('.ticket .barcode').css({
                    'border-right': '1px solid ' + borderColor,
                    'border-bottom': '1px solid ' + borderColor,
                    'border-top': '1px solid ' + borderColor
                });

            });

            $('#enable_offline_payments').change(function () {
                $('.offline_payment_details').toggle(this.checked);
            }).change();
        });


    </script>

    <style type="text/css">
        .bootstrap-touchspin-postfix {
            background-color: #ffffff;
            color: #333;
            border-left: none;
        }

        .bgImage {
            cursor: pointer;
        }

        .bgImage.selected {
            outline: 4px solid #0099ff;
        }
    </style>
    <script>
        $(function () {

            var hash = document.location.hash;
            var prefix = "tab_";
            if (hash) {
                $('.nav-tabs a[href=' + hash + ']').tab('show');
            }

            $(window).on('hashchange', function () {
                var newHash = location.hash;
                if (typeof newHash === undefined) {
                    $('.nav-tabs a[href=' + '#general' + ']').tab('show');
                } else {
                    $('.nav-tabs a[href=' + newHash + ']').tab('show');
                }

            });

            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            });

        });


    </script>

@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- tab -->
            <ul class="nav nav-tabs">
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'general'])}}"
                    class="{{($tab == 'general' || !$tab) ? 'active' : ''}}"><a href="#general" data-toggle="tab">Général</a>
                </li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'design'])}}"
                    class="{{$tab == 'design' ? 'active' : ''}}"><a href="#design" data-toggle="tab">Conception de page d'événement</a></li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'order_page'])}}"
                    class="{{$tab == 'order_page' ? 'active' : ''}}"><a href="#order_page" data-toggle="tab">Formulaire de commande</a></li>

                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'social'])}}"
                    class="{{$tab == 'social' ? 'active' : ''}}"><a href="#social" data-toggle="tab">Social</a></li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'affiliates'])}}"
                    class="{{$tab == 'affiliates' ? 'active' : ''}}"><a href="#affiliates"
                                                                        data-toggle="tab">Affiliés</a></li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'fees'])}}"
                    class="{{$tab == 'fees' ? 'active' : ''}}"><a href="#fees" data-toggle="tab">Frais de service</a></li>
                <li data-route="{{route('showEventCustomizeTab', ['event_id' => $event->id, 'tab' => 'ticket_design'])}}"
                    class="{{$tab == 'ticket_design' ? 'active' : ''}}"><a href="#ticket_design" data-toggle="tab">Conception de ticket</a></li>

            </ul>
            <!--/ tab -->
            <!-- tab content -->
            <div class="tab-content panel">
                <div class="tab-pane {{($tab == 'general' || !$tab) ? 'active' : ''}}" id="general">
                    @include('ManageEvent.Partials.EditEventForm', ['event'=>$event, 'organisers'=>\Auth::user()->account->organisers])
                </div>

                <div class="tab-pane {{$tab == 'affiliates' ? 'active' : ''}}" id="affiliates">

                    <h4>Suivi des affiliés</h4>

                    <div class="well">
                        Garder une trace de qui génère des ventes pour votre événement est extrêmement facile.
                        Créez simplement un lien de parrainage en utilisant la case ci-dessous et partagez le lien avec vos affiliés / promoteurs d'événements.

                        <br><br>

                        <input type="text" id="affiliateGenerator" name="affiliateGenerator" class="form-control"/>

                        <div style="display:none; margin-top:10px; " id="referralUrl">
                            <input onclick="this.select();" type="text" name="affiliateLink" class="form-control"/>
                        </div>
                    </div>

                    @if($event->affiliates->count())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Nom d'affilié</th>
                                    <th>Visites générées</th>
                                    <th>Ventes de billets générées</th>
                                    <th>Volume des ventes généré</th>
                                    <th>Dernier Referral</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($event->affiliates as $affiliate)
                                    <tr>
                                        <td>{{ $affiliate->name }}</td>
                                        <td>{{ $affiliate->visits }}</td>
                                        <td>{{ $affiliate->tickets_sold }}</td>
                                        <td>{{ money($affiliate->sales_volume, $event->currency) }}</td>
                                        <td>{{ $affiliate->updated_at->format('M dS H:i A') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucune référence d'affiliation pour le moment.
                        </div>
                    @endif


                </div>
                <div class="tab-pane {{$tab == 'social' ? 'active' : ''}}" id="social">
                    <div class="well hide">
                        <h5>Les codes courts suivants sont disponibles pour l'utilisation:</h5>
                        Afficher l'URL publique de l'événement: <code>[event_url]</code><br>
                        Afficher le nom de l'organisateur: <code>[organiser_name]</code><br>
                        Afficher le titre de l'événement: <code>[event_title]</code><br>
                        Afficher la description de l'événement: <code>[event_description]</code><br>
                        Afficher la date et l'heure de début de l'événement: <code>[event_start_date]</code><br>
                        Afficher la date et l'heure de fin de l'événement: <code>[event_end_date]</code>
                    </div>

                    {!! Form::model($event, array('url' => route('postEditEventSocial', ['event_id' => $event->id]), 'class' => 'ajax ')) !!}

                    <h4>Social Settings</h4>

                    <div class="form-group hide">

                        {!! Form::label('social_share_text', 'Texte de partage social', array('class'=>'control-label ')) !!}

                        {!!  Form::textarea('social_share_text', $event->social_share_text, [
                            'class' => 'form-control',
                            'rows' => 4
                        ])  !!}
                        <div class="help-block">
                            C'est le texte qui sera partagé par défaut lorsqu'un utilisateur partage votre événement sur les réseaux sociaux
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label">Partager les boutons pour montrer.</label>
                        <br>

                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_facebook', 1, $event->social_show_facebook, ['id' => 'social_show_facebook', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_facebook', 'Facebook') !!}
                        </div>
                        <div class="custom-checkbox mb5">

                            {!! Form::checkbox('social_show_twitter', 1, $event->social_show_twitter, ['id' => 'social_show_twitter', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_twitter', 'Twitter') !!}

                        </div>

                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_email', 1, $event->social_show_email, ['id' => 'social_show_email', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_email', 'Email') !!}
                        </div>
                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_googleplus', 1, $event->social_show_googleplus, ['id' => 'social_show_googleplus', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_googleplus', 'Google+') !!}
                        </div>
                        <div class="custom-checkbox mb5">
                            {!! Form::checkbox('social_show_linkedin', 1, $event->social_show_linkedin, ['id' => 'social_show_linkedin', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_linkedin', 'LinkedIn') !!}
                        </div>
                        <div class="custom-checkbox">

                            {!! Form::checkbox('social_show_whatsapp', 1, $event->social_show_whatsapp, ['id' => 'social_show_whatsapp', 'data-toggle' => 'toggle']) !!}
                            {!! Form::label('social_show_whatsapp', 'WhatsApp') !!}


                        </div>
                    </div>

                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit('Sauvegarder les modifications', ['class'=>"btn btn-success"]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
                <div class="tab-pane scale_iframe {{$tab == 'design' ? 'active' : ''}}" id="design">

                    <div class="row">
                        <div class="col-sm-6">

                            {!! Form::open(array('url' => route('postEditEventDesign', ['event_id' => $event->id]), 'files'=> true, 'class' => 'ajax customizeForm')) !!}

                            {!! Form::hidden('bg_type', $event->bg_type) !!}

                            <h4>Options de l'arrière-plan</h4>

                            <div class="panel-group" id="bgOptions">

                                <div class="panel panel-default" data-type="color">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#bgOptions" href="#bgColor"
                                               class="{{($event->bg_type == 'color') ? '' : 'collapsed'}}">
                                                <span class="arrow mr5"></span> Utilisez une couleur pour l'arrière-plan
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="bgColor"
                                         class="panel-collapse {{($event->bg_type == 'color') ? 'in' : 'collapse'}}">
                                        <div class="panel-body">
                                            {!! Form::text('bg_color', $event->bg_color, ['class' => 'colorpicker form-control']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default" data-type="image">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#bgOptions" href="#bgImage"
                                               class="{{($event->bg_type == 'image') ? '' : 'collapsed'}}">
                                                <span class="arrow mr5"></span> Sélectionnez parmi les images disponibles
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="bgImage"
                                         class="panel-collapse {{($event->bg_type == 'image') ? 'in' : 'collapse'}}">
                                        <div class="panel-body">
                                            @foreach($available_bg_images_thumbs as $bg_image)

                                                <img data-3="{{str_replace('/thumbs', '', $event->bg_image_path)}}"
                                                     class="img-thumbnail ma5 bgImage {{ ($bg_image === str_replace('/thumbs', '', $event->bg_image_path) ? 'selected' : '') }}"
                                                     style="width: 120px;" src="{{asset($bg_image)}}"
                                                     data-src="{{str_replace('/thumbs', '', substr($bg_image,1))}}"/>

                                            @endforeach

                                            {!! Form::hidden('bg_image_path_custom', ($event->bg_type == 'image') ? $event->bg_image_path : '') !!}
                                        </div>
                                            <a class="btn btn-link" href="https://pixabay.com?ref=attendize" title="PixaBay Free Images">
                                            Images fournies par <b>PixaBay.com</b>
                                            </a>
                                    </div>
                                </div>

                            </div>
                            <div class="panel-footer mt15 text-right">
                                <span class="uploadProgress" style="display:none;"></span>
                                {!! Form::submit('Sauvegarder les modifications', ['class'=>"btn btn-success"]) !!}
                            </div>

                            <div class="panel-footer ar hide">
                                {!! Form::button('Annuler', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                                {!! Form::submit('Sauvegarder les modifications', ['class'=>"btn btn-success"]) !!}
                            </div>

                            {!! Form::close() !!}

                        </div>
                        <div class="col-sm-6">
                            <h4>Aperçu de la page d'événement</h4>

                            <div class="iframe_wrap" style="overflow:hidden; height: 600px; border: 1px solid #ccc;">
                                <iframe id="previewIframe"
                                        src="{{route('showEventPagePreview', ['event_id'=>$event->id])}}"
                                        frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%"
                                        width="100%">
                                </iframe>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane {{$tab == 'fees' ? 'active' : ''}}" id="fees">
                    {!! Form::model($event, array('url' => route('postEditEventFees', ['event_id' => $event->id]), 'class' => 'ajax')) !!}
                    <h4>Frais de l'organisateur</h4>

                    <div class="well">
                        Ce sont des frais facultatifs que vous pouvez inclure dans le coût de chaque billet. Cette charge apparaîtra sur les factures de l'acheteur comme '<b>FRAIS DE RESERVATION</b>'.
                    </div>

                    <div class="form-group">
                        {!! Form::label('organiser_fee_percentage', 'Pourcentage des frais de service', array('class'=>'control-label required')) !!}
                        {!!  Form::text('organiser_fee_percentage', $event->organiser_fee_percentage, [
                            'class' => 'form-control',
                            'placeholder' => '0'
                        ])  !!}
                        <div class="help-block">
                            par exemple: entrez <b>3.5</b> pour <b>3.5%</b>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('organiser_fee_fixed', 'Frais de service Prix fixe', array('class'=>'control-label required')) !!}
                        {!!  Form::text('organiser_fee_fixed', null, [
                            'class' => 'form-control',
                            'placeholder' => '0.00'
                        ])  !!}
                        <div class="help-block">
                            par exemple: entrez <b>10.25</b> pour <b>{{$event->currency_symbol}}10.25</b>
                        </div>
                    </div>
                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit('Sauvegarder les modifications', ['class'=>"btn btn-success"]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="tab-pane" id="social">
                    <h4>Paramètres sociaux</h4>

                    <div class="form-group">
                        <div class="checkbox custom-checkbox">
                            {!! Form::label('event_page_show_map', 'Afficher la carte sur la page de l\'événement?', array('id' => 'customcheckbox', 'class'=>'control-label')) !!}
                            {!! Form::checkbox('event_page_show_map', 1, false) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('event_page_show_social_share', 'Afficher les boutons de partage social?', array('class'=>'control-label')) !!}
                        {!! Form::checkbox('event_page_show_social_share', 1, false) !!}
                    </div>

                </div>

                <div class="tab-pane {{$tab == 'order_page' ? 'active' : ''}}" id="order_page">
                    {!! Form::model($event, array('url' => route('postEditEventOrderPage', ['event_id' => $event->id]), 'class' => 'ajax ')) !!}
                    <h4>Paramètres de la page de commande</h4>

                    <div class="form-group">
                        {!! Form::label('pre_order_display_message', 'Message à afficher aux participants avant qu\'ils achèvent leur commande.', array('class'=>'control-label ')) !!}

                        {!!  Form::textarea('pre_order_display_message', $event->pre_order_display_message, [
                            'class' => 'form-control',
                            'rows' => 4
                        ])  !!}
                        <div class="help-block">
                            Ce message sera affiché aux participants immédiatement avant qu'ils finalisent leur commande.
                        </div>

                    </div>
                    <div class="form-group">
                        {!! Form::label('post_order_display_message', 'Message à afficher aux participants après qu\'ils ont terminé leur commande.', array('class'=>'control-label ')) !!}

                        {!!  Form::textarea('post_order_display_message', $event->post_order_display_message, [
                            'class' => 'form-control',
                            'rows' => 4
                        ])  !!}
                        <div class="help-block">
                            Ce message sera affiché aux participants une fois qu'ils auront terminé le processus de paiement.
                        </div>
                    </div>


                        <h4>Paramètres de paiement hors connexion</h4>
                        <div class="form-group">
                            <div class="custom-checkbox">
                                <input {{ $event->enable_offline_payments ? 'checked="checked"' : '' }} data-toggle="toggle" id="enable_offline_payments" name="enable_offline_payments" type="checkbox" value="1">
                                <label for="enable_offline_payments">Activer les paiements hors connexion</label>
                            </div>
                        </div>
                        <div class="offline_payment_details" style="display: none;">
                            {!! Form::textarea('offline_payment_instructions', $event->offline_payment_instructions, ['class' => 'form-control editable']) !!}
                            <div class="help-block">
                                Entrez les instructions sur la façon dont les participants peuvent effectuer un paiement hors connexion.
                            </div>
                        </div>


                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit('Sauvegarder les modifications', ['class'=>"btn btn-success"]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>


                <div class="tab-pane {{$tab == 'ticket_design' ? 'active' : ''}}" id="ticket_design">
                    {!! Form::model($event, array('url' => route('postEditEventTicketDesign', ['event_id' => $event->id]), 'class' => 'ajax ')) !!}
                    <h4>Conception de ticket</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('ticket_border_color', 'Couleur de la bordure du ticket', ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'ticket_border_color', Input::old('ticket_border_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#000000'
                                                            ])  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('ticket_bg_color', 'Couleur de fond de billet', ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'ticket_bg_color', Input::old('ticket_bg_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#FFFFFF'
                                                            ])  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('ticket_text_color', 'Couleur de texte de billet', ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'ticket_text_color', Input::old('ticket_text_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#000000'
                                                            ])  !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('ticket_sub_text_color', 'Couleur du texte secondaire du billet', ['class'=>'control-label required ']) !!}
                                {!!  Form::input('text', 'ticket_sub_text_color', Input::old('ticket_border_color'),
                                                            [
                                                            'class'=>'form-control colorpicker',
                                                            'placeholder'=>'#000000'
                                                            ])  !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('is_1d_barcode_enabled', 'Afficher le code à barres 1D sur les tickets', ['class' => 'control-label required']) !!}
                                {!! Form::select('is_1d_barcode_enabled', [1 => 'Yes', 0 => 'No'], $event->is_1d_barcode_enabled, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <h4>Aperçu du billet</h4>
                            @include('ManageEvent.Partials.TicketDesignPreview')
                        </div>
                    </div>
                    <div class="panel-footer mt15 text-right">
                        {!! Form::submit('Sauvegarder les modifications', ['class'=>"btn btn-success"]) !!}
                    </div>

                    {!! Form::close() !!}

                </div>

            </div>
            <!--/ tab content -->
        </div>
    </div>
@stop
