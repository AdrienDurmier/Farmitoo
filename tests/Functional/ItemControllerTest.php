<?php


namespace App\Tests\Functional;

use App\DataFixtures\OrderFixtures;
use App\Entity\Order;
use Doctrine\ORM\EntityManager;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ItemControllerTest extends WebTestCase
{
    /** @var AbstractDatabaseTool */
    private $databaseTool;

    /** @var EntityManager */
    private $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        $this->databaseTool = $kernel->getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([
            OrderFixtures::class
        ]);
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testEdit(): void
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->enableProfiler();

        $orders = $this->entityManager->getRepository(Order::class)->findBy([], [], 1);
        $order = $orders[0];

        foreach($order->getItems() as $item){
            $client->request(Request::METHOD_POST, '/item/' . $item->getId(), [
                'quantity' => 7,
            ]);
            // Test de la réponse
            $this->assertTrue($client->getResponse()->isSuccessful());
            $this->assertJson($client->getResponse()->getContent());
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
    }
}
