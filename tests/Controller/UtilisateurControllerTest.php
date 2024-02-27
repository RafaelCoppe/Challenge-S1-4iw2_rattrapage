<?php

namespace App\Test\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UtilisateurRepository $repository;
    private string $path = '/user/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Utilisateur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
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
            'utilisateur[username]' => 'Testing',
            'utilisateur[roles]' => 'Testing',
            'utilisateur[password]' => 'Testing',
            'utilisateur[nom]' => 'Testing',
            'utilisateur[prenom]' => 'Testing',
            'utilisateur[mail]' => 'Testing',
            'utilisateur[tel]' => 'Testing',
            'utilisateur[adresse]' => 'Testing',
            'utilisateur[city]' => 'Testing',
            'utilisateur[create_date]' => 'Testing',
            'utilisateur[update_date]' => 'Testing',
            'utilisateur[delete_date]' => 'Testing',
            'utilisateur[genre]' => 'Testing',
            'utilisateur[status]' => 'Testing',
            'utilisateur[role]' => 'Testing',
            'utilisateur[Agence]' => 'Testing',
        ]);

        self::assertResponseRedirects('/user/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setUsername('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setMail('My Title');
        $fixture->setTel('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCity('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdate_date('My Title');
        $fixture->setDelete_date('My Title');
        $fixture->setGenre('My Title');
        $fixture->setStatus('My Title');
        $fixture->setRole('My Title');
        $fixture->setAgence('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setUsername('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setMail('My Title');
        $fixture->setTel('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCity('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdate_date('My Title');
        $fixture->setDelete_date('My Title');
        $fixture->setGenre('My Title');
        $fixture->setStatus('My Title');
        $fixture->setRole('My Title');
        $fixture->setAgence('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[username]' => 'Something New',
            'utilisateur[roles]' => 'Something New',
            'utilisateur[password]' => 'Something New',
            'utilisateur[nom]' => 'Something New',
            'utilisateur[prenom]' => 'Something New',
            'utilisateur[mail]' => 'Something New',
            'utilisateur[tel]' => 'Something New',
            'utilisateur[adresse]' => 'Something New',
            'utilisateur[city]' => 'Something New',
            'utilisateur[create_date]' => 'Something New',
            'utilisateur[update_date]' => 'Something New',
            'utilisateur[delete_date]' => 'Something New',
            'utilisateur[genre]' => 'Something New',
            'utilisateur[status]' => 'Something New',
            'utilisateur[role]' => 'Something New',
            'utilisateur[Agence]' => 'Something New',
        ]);

        self::assertResponseRedirects('/user/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getUsername());
        self::assertSame('Something New', $fixture[0]->getRoles());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getMail());
        self::assertSame('Something New', $fixture[0]->getTel());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getCreate_date());
        self::assertSame('Something New', $fixture[0]->getUpdate_date());
        self::assertSame('Something New', $fixture[0]->getDelete_date());
        self::assertSame('Something New', $fixture[0]->getGenre());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getAgence());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Utilisateur();
        $fixture->setUsername('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setMail('My Title');
        $fixture->setTel('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCity('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdate_date('My Title');
        $fixture->setDelete_date('My Title');
        $fixture->setGenre('My Title');
        $fixture->setStatus('My Title');
        $fixture->setRole('My Title');
        $fixture->setAgence('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/user/');
    }
}
