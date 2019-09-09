@extends('Shared.Layouts.BlankSlate')

@section('blankslate-icon-class')
    ico-ticket
@stop

@section('blankslate-title')
    Aucun billet
@stop

@section('blankslate-text')
    Créez votre premier ticket en cliquant sur le bouton ci-dessous.
@stop

@section('blankslate-body')
    <button data-invoke="modal" data-modal-id='CreateTicket' data-href="{{route('showCreateTicket', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
        <i class="ico-ticket"></i>
        Créer un ticket
    </button>
@stop
