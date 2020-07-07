<?php

declare(strict_types=1);

namespace Pluswerk\Comments\Domain\Repository;

use Pluswerk\Comments\Domain\Model\Comment;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CommentRepository extends Repository
{
    protected $defaultOrderings = [
        'crdate' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Find all include hidden
     *
     * @return QueryResultInterface|array
     */
    public function findAllIncludeHidden()
    {
        $query = $this->createQuery();

        $query->getQuerySettings()
            ->setRespectStoragePage(false)
            ->setIgnoreEnableFields(true);

        return $query->execute();
    }

    /**
     * Find by uid include hidden
     *
     * @return Comment|null
     */
    public function findByUidIncludeHidden(int $uid): ?Comment
    {
        $query = $this->createQuery();

        $query->getQuerySettings()
            ->setRespectStoragePage(false)
            ->setIgnoreEnableFields(true);

        $query->matching($query->equals('uid', $uid));
        return $query->execute()->getFirst();
    }

    /**
     * Find by page uid include hidden
     *
     * @return QueryResultInterface|array
     */
    public function findByPageUidIncludeHidden(int $pageUid)
    {
        $query = $this->createQuery();

        $query->getQuerySettings()
            ->setRespectStoragePage(false)
            ->setIgnoreEnableFields(true);

        $query->matching($query->equals('pageUid', $pageUid));
        return $query->execute();
    }
}
