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
    }
}
