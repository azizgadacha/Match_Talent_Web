<?php

namespace App\Test\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnnonceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AnnonceRepository $repository;
    private string $path = '/annonce/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Annonce::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce index');

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
            'annonce[titre]' => 'Testing',
            'annonce[nomSocieté]' => 'Testing',
            'annonce[datedebut]' => 'Testing',
            'annonce[datefin]' => 'Testing',
            'annonce[description]' => 'Testing',
            'annonce[typeContrat]' => 'Testing',
            'annonce[quiz]' => 'Testing',
            'annonce[categorieAnnonce]' => 'Testing',
            'annonce[utilisateur]' => 'Testing',
        ]);

        self::assertResponseRedirects('/annonce/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setTitre('My Title');
        $fixture->setNomSocieté('My Title');
        $fixture->setDatedebut('My Title');
        $fixture->setDatefin('My Title');
        $fixture->setDescription('My Title');
        $fixture->setTypeContrat('My Title');
        $fixture->setQuiz('My Title');
        $fixture->setCategorieAnnonce('My Title');
        $fixture->setUtilisateur('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setTitre('My Title');
        $fixture->setNomSocieté('My Title');
        $fixture->setDatedebut('My Title');
        $fixture->setDatefin('My Title');
        $fixture->setDescription('My Title');
        $fixture->setTypeContrat('My Title');
        $fixture->setQuiz('My Title');
        $fixture->setCategorieAnnonce('My Title');
        $fixture->setUtilisateur('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'annonce[titre]' => 'Something New',
            'annonce[nomSocieté]' => 'Something New',
            'annonce[datedebut]' => 'Something New',
            'annonce[datefin]' => 'Something New',
            'annonce[description]' => 'Something New',
            'annonce[typeContrat]' => 'Something New',
            'annonce[quiz]' => 'Something New',
            'annonce[categorieAnnonce]' => 'Something New',
            'annonce[utilisateur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/annonce/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getNomSocieté());
        self::assertSame('Something New', $fixture[0]->getDatedebut());
        self::assertSame('Something New', $fixture[0]->getDatefin());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getTypeContrat());
        self::assertSame('Something New', $fixture[0]->getQuiz());
        self::assertSame('Something New', $fixture[0]->getCategorieAnnonce());
        self::assertSame('Something New', $fixture[0]->getUtilisateur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Annonce();
        $fixture->setTitre('My Title');
        $fixture->setNomSocieté('My Title');
        $fixture->setDatedebut('My Title');
        $fixture->setDatefin('My Title');
        $fixture->setDescription('My Title');
        $fixture->setTypeContrat('My Title');
        $fixture->setQuiz('My Title');
        $fixture->setCategorieAnnonce('My Title');
        $fixture->setUtilisateur('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/annonce/');
    }
}
