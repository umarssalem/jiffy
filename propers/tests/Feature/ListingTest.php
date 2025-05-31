<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Room;
use App\Models\Property;

class ListingTest extends TestCase
{

    private string $token;
    private User $user;
    private Room $room;
    private Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $password = Str::random(10);
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
        ]);
        $this->user = $user;
        $this->token = base64_encode($user->email . ':secret123');
        $this->property = Property::factory()->create();
        $this->room = Room::factory()->create([
            'property_id' => $this->property->id,
        ]);

    }

    public function test_unauthenticated_user_cannot_access_availability()
    {
        $this->getJson('/api/availability')
            ->assertStatus(403);
    }

    public function test_publish_listing(): void
    {
        $payload = $this->preparePayLoad();
        
        $response = $this->postJson('/api/publish/listing', $payload, ['Authorization' => 'Basic ' . $this->token]);
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('properties', ['id' => $this->property->id]);

        foreach ($payload['rooms'] as $roomData) {
            $this->assertDatabaseHas('rooms', [
                'id' => $roomData['room_id'],
                'property_id' => $this->property->id,
                'price' => $roomData['price'],
            ]);

            $this->assertDatabaseHas('availabilities', [
                'room_id' => $roomData['room_id'],
                'date_available' => $roomData['date'],
            ]);
        }

    }

    /**
     * @depends test_publish_listing
     */
    public function test_getting_availablity(): void
    {
        $property_id = $this->property->id;
        $checkin = now()->addDays(1);
        $checkout = now()->addDays(2);
        $guests = 1;

        $query = http_build_query([
            'property_id' => $property_id,
            'check_in' => $checkin->toDateString(),
            'check_out' => $checkout->toDateString(),
            'guests' => $guests,
        ]);

        $response = $this->get('/api/availability?' . $query, [
            'Authorization' => 'Basic ' . $this->token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'available_rooms' => [
                '*' => [
                    'id',
                    'property_id',
                    'max',
                    'price',
                    'created_at',
                    'updated_at',
                ]
            ],
            'total_available',
        ]);

        $response->assertJsonFragment([
            'id' => $this->room->id,
        ]);
    }

    /**
     * @depends test_publish_listing
     */
    public function test_dialogflow_request(): void
    {
        $payload = $this->prepareDialogflowPayload();
        $token = base64_encode(env('DIALOG_FLOW_USER'). ':' .env('DIALOG_FLOW_PASSWORD'));
        $response = $this->postJson('/api/availability', $payload, ['Authorization' => 'Basic ' . $token]);
        
        $response->assertStatus(200);
        
        $responseData = $response->json();
        $this->assertStringContainsString("room with ID {$this->room->id}", $responseData['fulfillmentText']);
    }


    
    protected function tearDown(): void
    {
        $this->user->delete();
        $this->room->delete();
        $this->property->delete();
    }

    private function preparePayload(): array
    {
        $json = file_get_contents(base_path('tests/Artifacts/publish_sample.json'));
        $payload = json_decode($json, true);

        $payload['property_id'] = $this->property->id;
        foreach ($payload['rooms'] as $i => &$room) {
            $room['room_id'] = $this->room->id;
            $room['date'] = now()->addDays(1 + $i)->toDateString(); // e.g., 2025-06-01, 2025-06-02, etc.
        }
        return $payload;
    }

    private function prepareDialogflowPayload(){
        $json = file_get_contents(base_path('tests/Artifacts/dialog_flow_body_sample.json'));
        $payload = json_decode($json, true);

        // Replace parameters with actual test values
        $payload['queryResult']['parameters']['property_id'] = $this->property->id;
        $payload['queryResult']['parameters']['check_in'] = now()->addDays(1)->toIso8601String();
        $payload['queryResult']['parameters']['checkout'] = now()->addDays(2)->toIso8601String();
        $payload['queryResult']['parameters']['number_of_guests'] = 1;

        return $payload;
    }
}
