<?php
namespace Tests\Innotama;

use Innotama\ChatworkWrapper\ChatworkClient;
use Innotama\ChatworkWrapper\Model\Member;
use PHPUnit\Framework\TestCase;

class ContactsTest extends TestCase
{

    public function testContacts()
    {
        $client = new ChatworkClient(getenv('CHATWORK_API_KEY'));
        $contacts = $client->contacts();

        $this->assertCount(2, $contacts);

        $contact = $contacts[0];
        $this->assertInstanceOf(Member::class, $contact);
        $this->assertNotNull($contact->account_id);
        $this->assertNotNull($contact->room_id);
        $this->assertNotNull($contact->name);
        $this->assertNotNull($contact->chatwork_id);
        $this->assertNotNull($contact->organization_id);
        $this->assertNotNull($contact->organization_name);
        $this->assertNotNull($contact->department);
        $this->assertNotNull($contact->avatar_image_url);
    }
}
