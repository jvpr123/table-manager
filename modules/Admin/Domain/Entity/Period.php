<?php

namespace Modules\Admin\Domain\Entity;

use Carbon\Carbon;
use Modules\Shared\Domain\Entity\BaseEntity;
use Modules\Shared\Domain\ValueObject\UUID;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;

/**
 * @property string[] $meetingsIds
 *
 * @package Period
 */
class Period extends BaseEntity
{
    private string $time;
    private array $meetingsIds = [];

    public function __construct(
        string $time,
        ?UUID $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->setTime($time);
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(string $time): void
    {
        $this->time = $time;
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
