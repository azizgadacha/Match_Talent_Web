<?php

namespace App\Test\Controller;

use App\Entity\Postulation;
use App\Repository\PostulationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostulationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PostulationRepository $repository;
    private string $path = '/postulation/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Postulation::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Postulation index');

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
            'postulation[etat]' => 'Testing',
            'postulation[date]' => 'Testing',
            'postulation[annoncePostulation]' => 'Testing',
            'postulation[userPostulation]' => 'Testing',
            'postulation[fileAssocier]' => 'Testing',
        ]);

        self::assertResponseRedirects('/postulation/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Postulation();
        $fixture->setEtat('My Title');
        $fixture->setDate('My Title');
        $fixture->setAnnoncePostulation('My Title');
        $fixture->setUserPostulation('My Title');
        $fixture->setFileAssocier('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Postulation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Postulation();
        $fixture->setEtat('My Title');
        $fixture->setDate('My Title');
        $fixture->setAnnoncePostulation('My Title');
        $fixture->setUserPostulation('My Title');
        $fixture->setFileAssocier('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'postulation[etat]' => 'Something New',
            'postulation[date]' => 'Something New',
            'postulation[annoncePostulation]' => 'Something New',
            'postulation[userPostulation]' => 'Something New',
            'postulation[fileAssocier]' => 'Something New',
        ]);

        self::assertResponseRedirects('/postulation/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getEtat());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getAnnoncePostulation());
        self::assertSame('Something New', $fixture[0]->getUserPostulation());
        self::assertSame('Something New', $fixture[0]->getFileAssocier());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Postulation();
        $fixture->setEtat('My Title');
        $fixture->setDate('My Title');
        $fixture->setAnnoncePostulation('My Title');
        $fixture->setUserPostulation('My Title');
        $fixture->setFileAssocier('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/postulation/');
    }
}
