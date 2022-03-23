@extends('layouts.email')

@section('content')
Company: {{ $company_name }}<br />
Contact: {{ $contact_name }}<br />
Phone: {{ $phone }}<br />
Email: {{ $email }}<br /><br>
{!! nl2br($messagebody) !!}
@stop
