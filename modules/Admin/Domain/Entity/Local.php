<?php

namespace Modules\Admin\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;

/**
 * @property string[] $meetingsIds
 *
 * @package Local
 */
class Local extends BaseEntity
{
    private array $meetingsIds = [];

    public function __construct(
        private string $title,
        private ?string $description = null,
        ?UUID $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description = null): void
    {
        $this->description = $description;
    }

    /**
     * @return string[]
     */
    public function getMeetingsIds(): array
    {
        return $this->meetingsIds;
    }

    public function addMeeting(Meeting $meeting): void
    {
        $meetingAlreadyRelated = in_array($meeting->getId()->value, $this->meetingsIds);

        if ($meetingAlreadyRelated) {
            throw new EntityAlreadyRelatedException($this, $meeting);
        }

        array_push($this->meetingsIds, $meeting->getId()->value);
    }

    public function removeMeeting(Meeting $meeting): void
    {
        $index = array_search($meeting->getId()->value, $this->meetingsIds);
        unset($this->meetingsIds[$index]);
    }
}
