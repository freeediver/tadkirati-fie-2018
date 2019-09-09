@extends('Shared.Layouts.Master')

@section('title')
Tadkirati

Event Widgets
@stop

@section('top_nav')
@include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
@include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
<i class='ico-code mr5'></i>
Enquêtes sur les événements
@stop

@section('head')

@stop

@section('page_header')
<style>
    .page-header {display: none;}
</style>
@stop


@section('content')
<div class="row">


    <div class="col-md-12">

        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Code d'intégration HTML</h4>
                            <textarea rows="7" onfocus="this.select();"
                                      class="form-control">{{$event->embed_html_code}}</textarea>
                    </div>
                    <div class="col-md-6">
                        <h4>Instructions</h4>

                        <p>
                            Il suffit de copier et coller le code HTML fourni sur votre site Web à l'endroit où vous souhaitez que le widget apparaisse.
                        </p>

                        <h5>
                            <b>Aperçu intégré</b>
                        </h5>

                        <div class="preview_embed" style="border:1px solid #ddd; padding: 5px;">
                            {!! $event->embed_html_code !!}
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@stop
