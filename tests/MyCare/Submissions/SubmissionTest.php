<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseMigrations;
use MyCare\Shared\Application\OutDto;
use MyCare\Shared\Domain\ValueObj\Identifier;
use MyCare\Shared\Infrastructure\User\Eloquent\EPersonalData;
use MyCare\Shared\Infrastructure\User\Eloquent\User;
use MyCare\Shared\Infrastructure\User\UserRepository;
use MyCare\Submissions\Application\SubmissionCreator;
use MyCare\Submissions\Application\SubmissionDeleter;
use MyCare\Submissions\Application\SubmissionSearchById;
use MyCare\Submissions\Application\SubmissionSearcher;
use MyCare\Submissions\Infrastructure\SubmissionRepository;
use Tests\TestCase;


class SubmissionTest extends TestCase
{
    use DatabaseMigrations;

    public function testSaveSubmissions()
    {
        $user = User::factory()
            ->create();

        $this->actingAs($user);

        $ucase = (new SubmissionCreator(new SubmissionRepository(), $user->getDomain()))(
            title:    'Title saraza',
            symptoms: 'Description saraza'
        );

        $this->assertInstanceOf(OutDto::class, $ucase);
        $this->assertTrue($ucase->isSuccess());
        $this->assertNotEmpty($ucase->getData());
    }

    public function testGetSubmissions()
    {
        $user = User::factory()
            ->create();

        $this->actingAs($user);

        (new SubmissionCreator(new SubmissionRepository(), $user->getDomain()))(
            title:    'Title saraza',
            symptoms: 'Description saraza'
        );

        $ucase = (new SubmissionSearcher(new SubmissionRepository(), new UserRepository()))();

        $this->assertInstanceOf(OutDto::class, $ucase);
        $this->assertTrue($ucase->isSuccess());
        $this->assertNotEmpty($ucase->getData());
    }

    public function testGetSubmissionById()
    {
        $user = User::factory()
            ->create();

        $this->actingAs($user);

        $repository = new SubmissionRepository();

        $result = (new SubmissionCreator($repository, $user->getDomain()))(
            title:    'Title saraza',
            symptoms: 'Description saraza'
        );

        $submissionCreated = $result->getData();

        $ucase = (new SubmissionSearchById(
            $repository
        ))(
            $submissionCreated->getId()
        );

        $this->assertInstanceOf(OutDto::class, $ucase);
        $this->assertTrue($ucase->isSuccess(), $ucase->getErrorMessage());
        $this->assertNotEmpty($ucase->getData());
    }

    public function testDeleteSubmission()
    {
        $user = User::factory()
            ->has(
                EPersonalData::factory()
                    ->count(1)
                    ->state(
                        function (array $attributes, User $user) {
                            $attributes['id'] = new Identifier($user->id);
                            return $attributes;
                        }
                    ), 'personalData'
            )
            ->create();

        $this->actingAs($user);

        $result = (new SubmissionCreator(new SubmissionRepository(), $user->getDomain()))(
            title:    'Title saraza',
            symptoms: 'Description saraza'
        );
        $submissionCreated = $result->getData();

        $result = (new SubmissionDeleter(new SubmissionRepository()))(
            $submissionCreated->getId()
        );

        $this->assertInstanceOf(OutDto::class, $result);
        $this->assertTrue($result->isSuccess(), $result->getErrorMessage());
    }
}
