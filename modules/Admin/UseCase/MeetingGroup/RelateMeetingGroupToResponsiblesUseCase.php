<?php

namespace Modules\Admin\UseCase\MeetingGroup;

use Modules\Admin\Domain\Entity\MeetingGroup;
use Modules\Admin\Domain\Entity\Responsible;
use Modules\Admin\DTO\MeetingGroup\RelateMeetingGroupToResponsiblesInputDTO;
use Modules\Admin\Gateway\MeetingGroupGateway;
use Modules\Admin\Gateway\ResponsibleGateway;
use Modules\Shared\Exceptions\EntityAlreadyRelatedException;
use Modules\Shared\Exceptions\EntityNotFoundException;

class RelateMeetingGroupToResponsiblesUseCase
{
    public function __construct(
        private MeetingGroupGateway $meetingGroupRepository,
        private ResponsibleGateway $responsibleRepository,
    ) {
    }

    public function execute(RelateMeetingGroupToResponsiblesInputDTO $input): void
    {
        $meetingGroup = $this->meetingGroupRepository->getMeetingGroupWithResponsibles($input->meetingGroupId);
        if (!$meetingGroup) {
            throw new EntityNotFoundException(MeetingGroup::class);
        }

        $this->verifyResponsiblesExist($input->responsiblesIds);
        $this->verifyResponsiblesAreNotRelated($meetingGroup, $input->responsiblesIds);

        $this->meetingGroupRepository->toggleResponsibles(
            meetingGroupId: $input->meetingGroupId,
            responsiblesIds: $input->responsiblesIds,
        );
    }

    private function verifyResponsiblesExist(array $responsiblesIds): void
    {
        foreach ($responsiblesIds as $id) {
            $responsibleExists = $this->responsibleRepository->find($id);
            if (!$responsibleExists) {
                throw new EntityNotFoundException(Responsible::class);
            }
        }
    }

    private function verifyResponsiblesAreNotRelated(MeetingGroup $meetingGroup, array $responsiblesIds): void
    {
        foreach ($meetingGroup->getResponsibles() as $r) {
            $id = $r->getId()->value;
            $responsibleAlreadyRelated = in_array($id, $responsiblesIds);
            if ($responsibleAlreadyRelated) {
                throw new EntityAlreadyRelatedException($meetingGroup, $r);
            }
        }
    }
}
