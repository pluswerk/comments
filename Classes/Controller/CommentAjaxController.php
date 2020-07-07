<?php

declare(strict_types=1);

namespace Pluswerk\Comments\Controller;

use Pluswerk\Comments\Domain\Model\Comment;
use Pluswerk\Comments\Domain\Repository\CommentRepository;
use Pluswerk\Comments\Exception\EditCommentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MailUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class CommentAjaxController
{
    /**
     * @var \Pluswerk\Comments\Domain\Repository\CommentRepository
     */
    protected $commentRepository;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->commentRepository = $this->objectManager->get(CommentRepository::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function editComment(ServerRequestInterface $request): ResponseInterface
    {
        $uid = (int)GeneralUtility::_GP('commentUid');
        if (!$uid) {
            return new JsonResponse(
                [
                    'success' => false,
                    'error' => [
                        'message' => $this->translate('exception.no_uid'),
                    ],
                ],
                500
            );
        }

        $comment = $this->commentRepository->findByUidIncludeHidden($uid);
        try {
            $postProcessAction = $this->processComment($comment);
        } catch (EditCommentException $e) {
            return new JsonResponse(
                [
                    'success' => false,
                    'error' => [
                        'message' => $e->getMessage(),
                    ],
                ],
                500
            );
        }

        $this->commentRepository->update($comment);
        $this->objectManager->get(PersistenceManager::class)->persistAll();
        return new JsonResponse(
            [
                'success' => true,
                'postProcessAction' => $postProcessAction,
            ]
        );
    }

    private function processComment(Comment $comment): string
    {
        $action = GeneralUtility::_GP('action');
        $postProcessAction = '';
        switch ($action) {
            case 'approve':
                $comment->setHidden(false);
                $postProcessAction = 'delete';
                break;
            case 'disable':
                $comment->setDisabled(true);
                $postProcessAction = 'reload';
                break;
            case 'enable':
                $comment->setDisabled(false);
                $postProcessAction = 'reload';
                break;
            case 'delete':
                $comment->setDeleted(true);
                $postProcessAction = 'delete';
                break;
            case 'edit':
                $text = GeneralUtility::_GP('text');
                if (empty($text)) {
                    throw new EditCommentException($this->translate('exception.no_text'));
                }
                $comment->setEditorialComment($text);
                if ($comment->isMailNotification()) {
                    $this->sendNotificationMailToUser($comment);
                }
                break;
            default:
                throw new EditCommentException($this->translate('exception.no_action'));
        }

        return $postProcessAction;
    }

    private function sendNotificationMailToUser(Comment $comment): void
    {
        $mail = GeneralUtility::makeInstance(MailMessage::class);
        $mail
            ->setFrom(MailUtility::getSystemFrom())
            ->setSubject($this->translate('mail.subject'))
            ->setTo([$comment->getUser()->getEmail()])
            ->setBody(
                sprintf(
                    '%s<br><br>%s %s<br><br>%s %s',
                    $this->translate('mail.body.0'),
                    $this->translate('mail.body.1'),
                    $comment->getEditorialComment(),
                    $this->translate('mail.body.2'),
                    $comment->getComment()
                )
            )
            ->send();
    }

    private function translate(string $identifier): ?string
    {
        return LocalizationUtility::translate($identifier, 'comments');
    }
}
