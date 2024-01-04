<?php

namespace App\Test\Controller;

use App\Entity\Offrande;
use App\Repository\OffrandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OffrandeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/offrande/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Offrande::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Offrande index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'offrande[libelle]' => 'Testing',
            'offrande[montantFC]' => 'Testing',
            'offrande[montantUSD]' => 'Testing',
            'offrande[montantEUR]' => 'Testing',
            'offrande[createdAt]' => 'Testing',
            'offrande[typeOffrande]' => 'Testing',
            'offrande[culte]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offrande();
        $fixture->setLibelle('My Title');
        $fixture->setMontantFC('My Title');
        $fixture->setMontantUSD('My Title');
        $fixture->setMontantEUR('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setTypeOffrande('My Title');
        $fixture->setCulte('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Offrande');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offrande();
        $fixture->setLibelle('Value');
        $fixture->setMontantFC('Value');
        $fixture->setMontantUSD('Value');
        $fixture->setMontantEUR('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setTypeOffrande('Value');
        $fixture->setCulte('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'offrande[libelle]' => 'Something New',
            'offrande[montantFC]' => 'Something New',
            'offrande[montantUSD]' => 'Something New',
            'offrande[montantEUR]' => 'Something New',
            'offrande[createdAt]' => 'Something New',
            'offrande[typeOffrande]' => 'Something New',
            'offrande[culte]' => 'Something New',
        ]);

        self::assertResponseRedirects('/offrande/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLibelle());
        self::assertSame('Something New', $fixture[0]->getMontantFC());
        self::assertSame('Something New', $fixture[0]->getMontantUSD());
        self::assertSame('Something New', $fixture[0]->getMontantEUR());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getTypeOffrande());
        self::assertSame('Something New', $fixture[0]->getCulte());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offrande();
        $fixture->setLibelle('Value');
        $fixture->setMontantFC('Value');
        $fixture->setMontantUSD('Value');
        $fixture->setMontantEUR('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setTypeOffrande('Value');
        $fixture->setCulte('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/offrande/');
        self::assertSame(0, $this->repository->count([]));
    }
}
