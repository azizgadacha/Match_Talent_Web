<?php

namespace App\Test\Controller;

use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RendezVousControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RendezVousRepository $repository;
    private string $path = '/rendez/vous/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(RendezVous::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RendezVou index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'rendez_vou[dateRendezVous]' => 'Testing',
            'rendez_vou[heureRendezVous]' => 'Testing',
            'rendez_vou[annonceAssocierRendezVous]' => 'Testing',
            'rendez_vou[userRendezVous]' => 'Testing',
        ]);

        self::assertResponseRedirects('/rendez/vous/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new RendezVous();
        $fixture->setDateRendezVous('My Title');
        $fixture->setHeureRendezVous('My Title');
        $fixture->setAnnonceAssocierRendezVous('My Title');
        $fixture->setUserRendezVous('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RendezVou');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new RendezVous();
        $fixture->setDateRendezVous('My Title');
        $fixture->setHeureRendezVous('My Title');
        $fixture->setAnnonceAssocierRendezVous('My Title');
        $fixture->setUserRendezVous('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rendez_vou[dateRendezVous]' => 'Something New',
            'rendez_vou[heureRendezVous]' => 'Something New',
            'rendez_vou[annonceAssocierRendezVous]' => 'Something New',
            'rendez_vou[userRendezVous]' => 'Something New',
        ]);

        self::assertResponseRedirects('/rendez/vous/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateRendezVous());
        self::assertSame('Something New', $fixture[0]->getHeureRendezVous());
        self::assertSame('Something New', $fixture[0]->getAnnonceAssocierRendezVous());
        self::assertSame('Something New', $fixture[0]->getUserRendezVous());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new RendezVous();
        $fixture->setDateRendezVous('My Title');
        $fixture->setHeureRendezVous('My Title');
        $fixture->setAnnonceAssocierRendezVous('My Title');
        $fixture->setUserRendezVous('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/rendez/vous/');
    }
}
