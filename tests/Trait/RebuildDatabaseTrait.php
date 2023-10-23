<?php

declare(strict_types=1);

namespace App\Tests\Trait;

use Doctrine\ORM\Tools\SchemaTool;

/**
 * Rebuild sqlite database on every setup
 * @see https://stackoverflow.com/questions/60352249/symfony-refresh-test-database-for-phpunit-testing-with-autoincrements-reset-on
 */
trait RebuildDatabaseTrait
{
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser */
    private $client;
    /** @var \Doctrine\ORM\EntityManager */
    private $em;
    private SchemaTool $schemaTool;
    /**
     * @var array<\Doctrine\ORM\Mapping\ClassMetadata>
     */
    private $metaData;

    /**
     * @inheritDoc
     * @throws \LogicException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        // if ($this->isNotTestDatabase()) {
        //     throw new \LogicException(
        //         'Tests cases must be executed agains test DB '
        //         . ' (DATABASE_URL:' . getenv('DATABASE_URL') . ')'
        //     );
        // }
        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();

        $this->metaData = $this->em->getMetadataFactory()->getAllMetadata();
        $this->schemaTool = new SchemaTool($this->em);
        $this->schemaTool->updateSchema($this->metaData);
    }

    private function isNotTestDatabase() : bool
    {
        if (
            getenv('DATABASE_URL')
            === 'sqlite:///%kernel.project_dir%/var/data.db'
        ) {
            return false;
        }

        return true;
    }
}