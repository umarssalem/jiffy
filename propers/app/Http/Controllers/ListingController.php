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
            // Step 2: Find or create/update the Room
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

            // Step 3: Find or create/update the RoomAvailability
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
}
