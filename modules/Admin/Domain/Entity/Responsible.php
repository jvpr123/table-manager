<?php

namespace Modules\Admin\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;

/**
 * @property string[] $meetingsIds
 * @property Meeting[] $meetings
 *
 * @package Responsible
 */
class Responsible extends BaseEntity
{
    private array $meetingsIds = [];
    private array $meetings = [];

    public function __construct(
        private string $name,
        ?UUID $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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
