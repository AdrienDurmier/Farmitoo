<?php


namespace App\Tests\Functional;


use App\DataFixtures\OrderFixtures;
use App\Entity\Order;
use Doctrine\ORM\EntityManager;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MainControllerTest extends WebTestCase
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

    public function testCart(): void
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->enableProfiler();

        $client->request(Request::METHOD_GET, '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddress(): void
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->enableProfiler();

        $orders = $this->entityManager->getRepository(Order::class)->findBy([], [], 1);
        $order = $orders[0];
        $items = [];
        foreach($order->getItems() as $item){
            $items[$item->getId()] = $item->getQuantity();
        }

        $client->request(Request::METHOD_POST, '/checkout/address', [
            'order' => $order->getId(),
            'items' => $items,
        ]);

        // Test de la réponse
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
