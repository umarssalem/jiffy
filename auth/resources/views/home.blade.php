@extends('layouts.master')

@section('content')
    <h1>Welcome to your Booking App</h1>
    <p>This is your dashboard.</p>

    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger
    chat-icon="https:&#x2F;&#x2F;media.istockphoto.com&#x2F;id&#x2F;1329751110&#x2F;vector&#x2F;chatbot-concept-dialogue-help-service.jpg?s=612x612&ampw=0&ampk=20&ampc=5aLsLEghDrDRjZ_bu-kAaSLU5dVv56g688HlCtR_TYA="
    intent="WELCOME"
    chat-title="Booking_agent"
    agent-id="8696a604-3612-4230-9fdf-9cf580fb5815"
    language-code="en"
    ></df-messenger>
@endsection

