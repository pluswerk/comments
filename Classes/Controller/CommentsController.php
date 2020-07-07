<?php

declare(strict_types=1);

namespace Pluswerk\Comments\Controller;

use Pluswerk\Comments\Domain\Model\Comment;
use Pluswerk\Comments\Domain\Repository\CommentRepository;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Exception;

class CommentsController extends ActionController
{
    /**
     * @var \Pluswerk\Comments\Domain\Repository\CommentRepository
     * @\TYPO3\CMS\Extbase\Annotation\Inject()
     */
    protected $commentRepository;

    /**
     * @return void
     */
    public function listAction(): void
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $this->view->assign('comments', $this->commentRepository->findByPageUid((int)$this->getTypoScriptFrontEndController()->id));
        $this->view->assign('activeUser', $context->getPropertyFromAspect('frontend.user', 'isLoggedIn'));
        $this->view->assign('commentObject', GeneralUtility::makeInstance(Comment::class));
    }

    /**
     * @param Comment $commentObject
     * @return void
     */
    public function createAction(Comment $commentObject): void
    {
        $flashMessageContent = 'comment.create.error';
        $context = GeneralUtility::makeInstance(Context::class);
        if (
            $context->getPropertyFromAspect('frontend.user', 'isLoggedIn') &&
            is_array($this->getTypoScriptFrontEndController()->fe_user->user) &&
            $this->getTypoScriptFrontEndController()->fe_user->user['uid']
        ) {
            $commentRepository = $this->objectManager->get(CommentRepository::class);
            $feUser = $this->getFrontendUser();

            if ((bool)$this->settings['validateComments'] === true) {
                $commentObject->setHidden(true);
                $flashMessageContent = 'comment.create.success.validation';
            } else {
                $flashMessageContent = 'comment.create.success.novalidation';
            }

            $commentObject->setCrdate(time());
            $commentObject->setUser($feUser);
            $commentObject->setPageUid((int)$this->getTypoScriptFrontEndController()->id);
            $commentRepository->add($commentObject);
            $this->objectManager->get(PersistenceManager::class)->persistAll();
        }

        $this->addFlashMessage(LocalizationUtility::translate($flashMessageContent, 'comments'));
        $redirectUrl = $this->uriBuilder->setTargetPageUid((int)$this->getTypoScriptFrontEndController()->id)->buildFrontendUri();
        $this->redirectToUri($redirectUrl);
    }

    private function getTypoScriptFrontEndController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }

    private function getFrontendUser(): FrontendUser
    {
        $feUserRepo = $this->objectManager->get(FrontendUserRepository::class);
        $feUser = $feUserRepo->findByUid($this->getTypoScriptFrontEndController()->fe_user->user['uid']);

        if (!($feUser instanceof FrontendUser)) {
            throw new Exception($this->translate('exception.fe_user'));
        }

        return $feUser;
    }

    private function translate(string $identifier): ?string
    {
        return LocalizationUtility::translate($identifier, 'comments');
    }
}
