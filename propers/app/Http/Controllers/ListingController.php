<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Room;
use App\Models\Availability;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function publish(Request $request)
    {
        $propertyId = $request->input('property_id');
        $roomsData = $request->input('rooms', []);

        $property = Property::updateOrCreate(
            ['id' => $propertyId],
            [
                'name' => 'Default Name',
            ]
        );

        foreach ($roomsData as $roomData) {
            $room = Room::updateOrCreate(
                [
                    'property_id' => $property->id,
                    'id' => $roomData['room_id'] // Convert "r1" to integer if needed
                ],
                [
                    'max' => $roomData['max_guests'] ?? $roomData['max_'],
                    'price' => $roomData['price']
                ]
            );

            Availability::updateOrCreate(
                [
                    'room_id' => $room->id,
                    'date_available' => $roomData['date']
                ]
            );
        }

        return response()->json([
            'message' => 'successfully published'
        ]);
    }

    public function check(Request $request){
        $propertyId = $request->property_id;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;
        $guests = $request->guests;

        $query = Room::where('property_id', $propertyId);
        

        if ($guests) {
            $query->where('max', '>=', $guests);
        }

        $availableRooms = $query->get();
        return response()->json([
            'available_rooms' => $availableRooms,
            'total_available' => $availableRooms->count(),
        ]);
    }

    public function checkDialogFlowRequest(Request $request){
        // Extract parameters from JSON body: queryResult.parameters
        $parameters = $request->input('queryResult.parameters');

        $propertyId = $parameters['property_id'] ?? null;
        $checkIn = $parameters['check_in'] ?? null;
        $checkOut = $parameters['checkout'] ?? null;
        $guests = $parameters['number_of_guests'] ?? null;

        if (!$propertyId || !$checkIn || !$checkOut || !$guests) {
            return response()->json([
                'fulfillmentText' => 'Some booking information is missing. Please provide all details.'
            ]);
        }
         $query = Room::where('property_id', $propertyId);

        if ($guests) {
            $query->where('max', '>=', $guests);
        }

        $availableRooms = $query->get();
        $totalAvailable = $availableRooms->count();

        if ($totalAvailable === 0) {
            return response()->json([
                'fulfillmentText' => 'Sorry, no rooms are available for that period and guest count.'
            ]);
        }

        $roomSummaries = $availableRooms->map(function ($room) {
            return "room with ID {$room->id} for \${$room->price} per night";
        })->implode(', ');

        $message = "Yes, we found {$totalAvailable} available room(s) from {$checkIn} to {$checkOut} for {$guests} guest(s): {$roomSummaries}.";

        // Respond with fulfillmentText so Dialogflow shows it to the user
        return response()->json([
            'fulfillmentText' => $message,
        ]);
    }
}
