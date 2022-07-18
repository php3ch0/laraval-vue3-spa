@extends('emails.emailtemplate')

@section('content')
Contact: {{ $name }}<br />
Phone: {{ $telephone }}<br />
Email: {{ $email }}<br /><br>
{!! nl2br($messagebody) !!}
@stop
