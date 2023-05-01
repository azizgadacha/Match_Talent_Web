<?php

namespace App\Test\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UtilisateurRepository $repository;
    private string $path = '/utilisateur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Utilisateur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur index');

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
            'utilisateur[nomSociete]' => 'Testing',
            'utilisateur[biographie]' => 'Testing',
            'utilisateur[username]' => 'Testing',
            'utilisateur[address]' => 'Testing',
            'utilisateur[motDePasse]' => 'Testing',
            'utilisateur[email]' => 'Testing',
            'utilisateur[contact]' => 'Testing',
            'utilisateur[file]' => 'Testing',
            'utilisateur[roleUser]' => 'Testing',
        ]);

        self::assertResponseRedirects('/utilisateur/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNomSociete('My Title');
        $fixture->setBiographie('My Title');
        $fixture->setUsername('My Title');
        $fixture->setAddress('My Title');
        $fixture->setMotDePasse('My Title');
        $fixture->setEmail('My Title');
        $fixture->setContact('My Title');
        $fixture->setFile('My Title');
        $fixture->setRoleUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNomSociete('My Title');
        $fixture->setBiographie('My Title');
        $fixture->setUsername('My Title');
        $fixture->setAddress('My Title');
        $fixture->setMotDePasse('My Title');
        $fixture->setEmail('My Title');
        $fixture->setContact('My Title');
        $fixture->setFile('My Title');
        $fixture->setRoleUser('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[nomSociete]' => 'Something New',
            'utilisateur[biographie]' => 'Something New',
            'utilisateur[username]' => 'Something New',
            'utilisateur[address]' => 'Something New',
            'utilisateur[motDePasse]' => 'Something New',
            'utilisateur[email]' => 'Something New',
            'utilisateur[contact]' => 'Something New',
            'utilisateur[file]' => 'Something New',
            'utilisateur[roleUser]' => 'Something New',
        ]);

        self::assertResponseRedirects('/utilisateur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomSociete());
        self::assertSame('Something New', $fixture[0]->getBiographie());
        self::assertSame('Something New', $fixture[0]->getUsername());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getMotDePasse());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getContact());
        self::assertSame('Something New', $fixture[0]->getFile());
        self::assertSame('Something New', $fixture[0]->getRoleUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Utilisateur();
        $fixture->setNomSociete('My Title');
        $fixture->setBiographie('My Title');
        $fixture->setUsername('My Title');
        $fixture->setAddress('My Title');
        $fixture->setMotDePasse('My Title');
        $fixture->setEmail('My Title');
        $fixture->setContact('My Title');
        $fixture->setFile('My Title');
        $fixture->setRoleUser('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/utilisateur/');
    }
}
