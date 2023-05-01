<?php

namespace App\Test\Controller;

use App\Entity\Candidature;
use App\Repository\CandidatureRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CandidatureControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CandidatureRepository $repository;
    private string $path = '/candidature/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Candidature::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Candidature index');

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
            'candidature[note]' => 'Testing',
            'candidature[annonceAssocier]' => 'Testing',
            'candidature[utilisateurAssocier]' => 'Testing',
        ]);

        self::assertResponseRedirects('/candidature/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Candidature();
        $fixture->setNote('My Title');
        $fixture->setAnnonceAssocier('My Title');
        $fixture->setUtilisateurAssocier('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Candidature');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Candidature();
        $fixture->setNote('My Title');
        $fixture->setAnnonceAssocier('My Title');
        $fixture->setUtilisateurAssocier('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'candidature[note]' => 'Something New',
            'candidature[annonceAssocier]' => 'Something New',
            'candidature[utilisateurAssocier]' => 'Something New',
        ]);

        self::assertResponseRedirects('/candidature/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNote());
        self::assertSame('Something New', $fixture[0]->getAnnonceAssocier());
        self::assertSame('Something New', $fixture[0]->getUtilisateurAssocier());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Candidature();
        $fixture->setNote('My Title');
        $fixture->setAnnonceAssocier('My Title');
        $fixture->setUtilisateurAssocier('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/candidature/');
    }
}
