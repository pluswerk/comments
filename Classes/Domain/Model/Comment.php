<?php

declare(strict_types=1);

namespace Pluswerk\Comments\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Comment extends AbstractEntity
{
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $user = null;

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * @var int
     */
    protected $crdate = 0;

    /**
     * @var string
     */
    protected $editorialComment = '';

    /**
     * @var bool
     */
    protected $disabled = false;

    /**
     * @var int
     */
    protected $pageUid = 0;

    /**
     * @var bool
     */
    protected $mailNotification = false;

    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @var bool
     */
    protected $deleted = false;

    /**
     * @var bool
     */
    protected $reported = false;

    /**
     * @var bool
     */
    protected $acknowledged = false;

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     * @return void
     */
    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return void
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return FrontendUser
     */
    public function getUser(): ?FrontendUser
    {
        return $this->user;
    }

    /**
     * @param FrontendUser $user
     * @return void
     */
    public function setUser(FrontendUser $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return void
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getEditorialComment(): string
    {
        return $this->editorialComment;
    }

    /**
     * @param string $editorialComment
     * @return void
     */
    public function setEditorialComment(string $editorialComment): void
    {
        $this->editorialComment = $editorialComment;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return void
     */
    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    /**
     * @return int
     */
    public function getPageUid(): int
    {
        return $this->pageUid;
    }

    /**
     * @param int $pageUid
     * @return void
     */
    public function setPageUid(int $pageUid): void
    {
        $this->pageUid = $pageUid;
    }

    /**
     * @return int
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }

    /**
     * @param int $crdate
     * @return void
     */
    public function setCrdate(int $crdate): void
    {
        $this->crdate = $crdate;
    }

    /**
     * @return bool
     */
    public function isMailNotification(): bool
    {
        return $this->mailNotification;
    }

    /**
     * @param bool $mailNotification
     * @return void
     */
    public function setMailNotification(bool $mailNotification): void
    {
        $this->mailNotification = $mailNotification;
    }

    /**
     * @return bool
     */
    public function isReported(): bool
    {
        return $this->reported;
    }

    /**
     * @param bool $reported
     * @return void
     */
    public function setReported(bool $reported): void
    {
        $this->reported = $reported;
    }

    /**
     * @return bool
     */
    public function isAcknowledged(): bool
    {
        return $this->acknowledged;
    }

    /**
     * @param bool $acknowledged
     * @return void
     */
    public function setAcknowledged(bool $acknowledged): void
    {
        $this->acknowledged = $acknowledged;
    }
}
