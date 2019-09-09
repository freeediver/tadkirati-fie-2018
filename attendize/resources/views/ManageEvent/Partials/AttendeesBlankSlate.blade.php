@extends('Shared.Layouts.BlankSlate')


@section('blankslate-icon-class')
    ico-users
@stop

@section('blankslate-title')
    Aucun participants
@stop

@section('blankslate-text')
    Les participants apparaîtront ici une fois qu'ils se sont enregistrés avec succès pour votre événement, ou, vous pouvez inviter manuellement les participants vous-même.
@stop

@section('blankslate-body')
<button data-invoke="modal" data-modal-id='InviteAttendee' data-href="{{route('showInviteAttendee', array('event_id'=>$event->id))}}" href='javascript:void(0);'  class=' btn btn-success mt5 btn-lg' type="button" >
    <i class="ico-user-plus"></i>
    Inviter un participant
</button>
@stop


