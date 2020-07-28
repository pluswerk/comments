<?php

declare(strict_types=1);

namespace Pluswerk\Comments\Controller;

use Pluswerk\Comments\Domain\Model\Comment;
use Pluswerk\Comments\Domain\Repository\CommentRepository;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * Class ReferenceController
 *
 * @author Felix König <felix.koenig@pluswerk.ag>
 * @copyright 2020 Pluswerk AG
 * @license GPL, version 2
 */
class CommentAdministrationController extends ActionController
{
    /**
     * @var \Pluswerk\Comments\Domain\Repository\CommentRepository
     * @\TYPO3\CMS\Extbase\Annotation\Inject()
     */
    protected $commentRepository;

    /**
     * @return void
     */
    public function showAction(): void
    {
        $pageId = (int)GeneralUtility::_GET('id');
        if ($pageId === 0) {
            $this->forward('dashboard');
        }

        $page = BackendUtility::getRecord('pages', $pageId);

        $comments = $this->commentRepository->findByPageUidIncludeHidden($pageId);
        $reportedComments = $this->commentRepository->findReported($pageId);
        $acknowledgedComments = $this->commentRepository->findByAcknowledged($pageId);
        $hiddenComments = $this->commentRepository->findByHidden($pageId);

        $this->view->assign('page', $page);
        $this->view->assign('comments', $comments);
        $this->view->assign('reportedComments', $reportedComments);
        $this->view->assign('acknowledgedComments', $acknowledgedComments);
        $this->view->assign('hiddenComments', $hiddenComments);
    }

    /**
     * @return void
     */
    public function dashboardAction(): void
    {
        $querySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $this->commentRepository->setDefaultQuerySettings($querySettings);
        $comments = $this->commentRepository->findAllIncludeHidden();
        $reportedComments = $this->commentRepository->findReported();
        $acknowledgedComments = $this->commentRepository->findByAcknowledged();
        $hiddenComments = $this->commentRepository->findByHidden();

        $this->view->assign('comments', $comments);
        $this->view->assign('reportedComments', $reportedComments);
        $this->view->assign('acknowledgedComments', $acknowledgedComments);
        $this->view->assign('hiddenComments', $hiddenComments);
    }
}
