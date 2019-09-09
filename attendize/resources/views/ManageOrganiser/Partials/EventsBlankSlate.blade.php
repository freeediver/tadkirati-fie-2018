@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-ticket
@stop

@section('blankslate-title')
    Aucun événement pour le moment!
@stop

@section('blankslate-text')
    On dirait que vous n'avez pas encore créé d'événement. Vous pouvez en créer un en cliquant sur le bouton ci-dessous.
@stop

@section('blankslate-body')
<button data-invoke="modal" data-modal-id="CreateEvent" data-href="{{route('showCreateEvent', ['organiser_id' => $organiser->id])}}" href='javascript:void(0);'  class="btn btn-success mt5 btn-lg" type="button">
    <i class="ico-ticket"></i>
    Créer un évènement
</button>
@stop


