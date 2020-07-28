require(['jquery'], function ($) {
  $(function () {
    var scrollElementSelector = sessionStorage.getItem('frame-scroll-element');
    var activeTab = sessionStorage.getItem('active-comments-tab');
    sessionStorage.setItem('frame-scroll-element', 'none');

    if (scrollElementSelector && scrollElementSelector !== 'none') {
      var scrollElement = document.getElementById(scrollElementSelector);
      scrollElement.scrollIntoView();
    }

    if (activeTab) {
      var activeTabElement = document.querySelector('a[href="' + activeTab + '"]');
      activeTabElement.click();
    }

    $('.js-reload-frame').click(function () {
      window.location.reload();
    });

    $('.t3js-tabmenu-item a').click(function () {
      sessionStorage.setItem('active-comments-tab', $(this).attr('href'));
    });

    $('.js-editComment').click(function () {
      var $button = $(this);
      $.ajax({
        url: TYPO3.settings.ajaxUrls['comment_edit'],
        data: {
          commentUid: $button.data('comment-uid'),
          action: $button.data('action'),
        },
      }).done(function (data) {
        if (data.success === true) {
          switch (data.postProcessAction) {
            case 'delete':
              var $tableRow = $button.closest('tr');
              $tableRow.fadeOut(300, function () {
                $tableRow.remove();
              });
              break;
            case 'reload':
              sessionStorage.setItem('frame-scroll-element', $button.closest('tr')[0].id);
              window.location.reload();
              break;
            default:
          }
        }
      });
    });

    $('.js-submitEditorialComment').on('submit', function (event) {
      event.preventDefault();
      var $form = $(this);
      var text = $form.find('textarea').val();
      $.ajax({
        type: 'post',
        url: TYPO3.settings.ajaxUrls['comment_edit'],
        data: {
          commentUid: $form.data('comment-uid'),
          action: $form.data('action'),
          text: text,
        },
      }).done(function (data) {
        if (data.success === true) {
          sessionStorage.setItem('frame-scroll-element', $form[0].id);
          window.location.reload();
        }
      });
    });
  });
});
