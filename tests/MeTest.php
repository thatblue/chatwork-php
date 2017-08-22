<?php
namespace Tests\Innotama;

use Innotama\ChatworkWrapper\ChatworkClient;
use Innotama\ChatworkWrapper\Model\Member;
use PHPUnit\Framework\TestCase;

class MeTest extends TestCase
{
    public function testMe()
    {
        $client = new ChatworkClient(getenv('CHATWORK_API_KEY'));
        $member = $client->me();
        $this->assertInstanceOf(Member::class, $member);
        $this->assertEquals('[bot]くつした部長', $member->name);
        $this->assertNotNull($member->account_id);
        $this->assertNotNull($member->room_id);
        $this->assertNotNull($member->chatwork_id);
        $this->assertNotNull($member->organization_id);
        $this->assertNotNull($member->organization_name);
        $this->assertNotNull($member->department);
        $this->assertNotNull($member->title);
        $this->assertNotNull($member->url);
        $this->assertNotNull($member->introduction);
        $this->assertNotNull($member->mail);
        $this->assertNotNull($member->tel_organization);
        $this->assertNotNull($member->tel_extension);
        $this->assertNotNull($member->tel_mobile);
        $this->assertNotNull($member->skype);
        $this->assertNotNull($member->facebook);
        $this->assertNotNull($member->twitter);
        $this->assertNotNull($member->avatar_image_url);
    }
}
