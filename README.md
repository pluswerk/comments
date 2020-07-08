# What does it do

This extension adds the possibility for users to leave comments on your TYPO3 websites.

Features:

- logged in users can write comments
- comments are coupled to pages
- comments can be validated before getting published
- commentary sections can be closed so no comments can be written anymore
- intuitive backend module for simple page-based comment administration
- the editorial can reply to comments
- mail notifications for comments
- disabling comments (e.g. inappropriate comments)
- extendable (bootstrapped) fluid-templates
- users can delete their comments


# How to
Simply add the Plugin "Comments" to the pages you want to have a discussion in. Check all options you want to check.
Don't forget to set a storagePid for all comments. The storagePid is the database-field "pid" of a comment. The "page_uid" is the page on which the comments are getting displayed.
If "validate comments before publishing" is set in the plugin options, the editorial needs to approve comments before getting displayed on the website.

![image](https://user-images.githubusercontent.com/17744843/86806050-c6138d00-c078-11ea-81af-7e685b9a72cc.png)

Inside the backend-module "Comments" the editorial can administrate comments for every page. 
If no page is selected, every unapproved comment gets displayed for quick approval.
If a page is selected, the editorial can see all comments on the current page and reply to them, disable or delete them.
Disabled comments can be reenabled.

![image](https://user-images.githubusercontent.com/17744843/86807234-fc9dd780-c079-11ea-86b4-5b173adb3402.png)

# Important notices
- The plugins are uncached because of the user-login-check. So pages with a comment section do not work together with a static file cache.
