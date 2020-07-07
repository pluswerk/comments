<?php

return [
    // Comment editing
    'comment_edit' => [
        'path' => '/comment/edit',
        'target' => \Pluswerk\Comments\Controller\CommentAjaxController::class . '::editComment'
    ],
];
