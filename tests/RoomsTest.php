<?php
namespace Tests\Innotama;

use Innotama\ChatworkWrapper\ChatworkClient;
use Innotama\ChatworkWrapper\Model\Room;
use PHPUnit\Framework\TestCase;

class RoomsTest extends TestCase
{

    /**
     * GET /rooms のテスト
     */
    public function testGetRooms()
    {
        $client = new ChatworkClient(getenv('CHATWORK_API_KEY'));
        $rooms = $client->getRooms();

        $this->assertCount(7, $rooms);

        $room = $rooms[1];
        $this->assertInstanceOf(Room::class, $room);
        $this->assertNotNull($room->room_id);

        $this->assertNotNull($room->name);
        $this->assertNotNull($room->type);
        $this->assertNotNull($room->role);
        $this->assertNotNull($room->sticky);
        $this->assertNotNull($room->unread_num);
        $this->assertNotNull($room->mention_num);
        $this->assertNotNull($room->mytask_num);
        $this->assertNotNull($room->message_num);
        $this->assertNotNull($room->file_num);
        $this->assertNotNull($room->task_num);
        $this->assertNotNull($room->icon_path);
        $this->assertNotNull($room->last_update_time);
    }

    /**
     * POST /rooms のテスト
     */
    public function testPostRooms()
    {
        $client = new ChatworkClient(getenv('CHATWORK_API_KEY'));
        $room = $client->postRooms([getenv('API_USER_ID')], 'テスト', '部屋作成のテスト', Room::ICON_PRESET_BEER, [getenv('MEMBER_USER_ID')]);

        $this->assertInstanceOf(Room::class, $room);
        $this->assertNotNull($room->room_id);
    }

}
