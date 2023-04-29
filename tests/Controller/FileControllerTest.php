<?php

namespace App\Test\Controller;

use App\Entity\File;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FileControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private FileRepository $repository;
    private string $path = '/file/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(File::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('File index');

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
            'file[cv]' => 'Testing',
            'file[deplome]' => 'Testing',
            'file[lettermotivation]' => 'Testing',
            'file[namecv]' => 'Testing',
            'file[namedeplome]' => 'Testing',
            'file[namemotivation]' => 'Testing',
            'file[userFile]' => 'Testing',
        ]);

        self::assertResponseRedirects('/file/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new File();
        $fixture->setCv('My Title');
        $fixture->setDeplome('My Title');
        $fixture->setLettermotivation('My Title');
        $fixture->setNamecv('My Title');
        $fixture->setNamedeplome('My Title');
        $fixture->setNamemotivation('My Title');
        $fixture->setUserFile('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('File');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new File();
        $fixture->setCv('My Title');
        $fixture->setDeplome('My Title');
        $fixture->setLettermotivation('My Title');
        $fixture->setNamecv('My Title');
        $fixture->setNamedeplome('My Title');
        $fixture->setNamemotivation('My Title');
        $fixture->setUserFile('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'file[cv]' => 'Something New',
            'file[deplome]' => 'Something New',
            'file[lettermotivation]' => 'Something New',
            'file[namecv]' => 'Something New',
            'file[namedeplome]' => 'Something New',
            'file[namemotivation]' => 'Something New',
            'file[userFile]' => 'Something New',
        ]);

        self::assertResponseRedirects('/file/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCv());
        self::assertSame('Something New', $fixture[0]->getDeplome());
        self::assertSame('Something New', $fixture[0]->getLettermotivation());
        self::assertSame('Something New', $fixture[0]->getNamecv());
        self::assertSame('Something New', $fixture[0]->getNamedeplome());
        self::assertSame('Something New', $fixture[0]->getNamemotivation());
        self::assertSame('Something New', $fixture[0]->getUserFile());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new File();
        $fixture->setCv('My Title');
        $fixture->setDeplome('My Title');
        $fixture->setLettermotivation('My Title');
        $fixture->setNamecv('My Title');
        $fixture->setNamedeplome('My Title');
        $fixture->setNamemotivation('My Title');
        $fixture->setUserFile('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/file/');
    }
}
