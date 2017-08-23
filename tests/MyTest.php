<?php
namespace Tests\Innotama;

use Innotama\ChatworkWrapper\ChatworkClient;
use Innotama\ChatworkWrapper\Model\Member;
use Innotama\ChatworkWrapper\Model\Room;
use Innotama\ChatworkWrapper\Model\Status;
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    /**
     * /my/statusのテスト
     */
    public function testStatus()
    {
        $client = new ChatworkClient(getenv('CHATWORK_API_KEY'));
        $status = $client->myStatus();

        $this->assertInstanceOf(Status::class, $status);
        $this->assertNotNull($status->unread_room_num);
        $this->assertNotNull($status->mention_room_num);
        $this->assertNotNull($status->mytask_room_num);
        $this->assertNotNull($status->unread_num);
        $this->assertNotNull($status->mention_num);
        $this->assertNotNull($status->mytask_num);
   }

    /**
     * /my/tasksのテスト
     */
   public function testTasks()
   {
       $client = new ChatworkClient(getenv('CHATWORK_API_KEY'));
       $tasks = $client->myTasks();
       $this->assertEquals(2, count($tasks));

       $task = $tasks[0];
       $this->assertNotNull($task->task_id);
       // Roomの検証
       $this->assertInstanceOf(Room::class, $task->getRoom());
       $this->assertNotNull($task->getRoom()->room_id);
       $this->assertNotNull($task->getRoom()->name);
       $this->assertNotNull($task->getRoom()->icon_path);

       // Memberの検証
       $this->assertInstanceOf(Member::class, $task->getAssignedByAccount());
       $this->assertNotNull($task->getAssignedByAccount()->account_id);
       $this->assertNotNull($task->getAssignedByAccount()->name);
       $this->assertNotNull($task->getAssignedByAccount()->avatar_image_url);

       $this->assertNotNull($task->message_id);
       $this->assertNotNull($task->body);
       $this->assertNotNull($task->limit_time);
       $this->assertNotNull($task->status);
   }
}
