## How to contribute to SuiteCRM


### **Code of Conduct**

This project and all community members are expected to uphold the [SuiteCRM Code of Conduct.](CODE_OF_CONDUCT.md)

#### **Bug Reporting**

* **Please do not open a GitHub issue if the bug is a security vulnerability**, and instead email us at security@suitecrm.com. This will be delivered to the product team who handle security issues. Please don't disclose security bugs publicly until they have been handled by the security team.

* Your email will be acknowledged within 24 hours during the business week (Mon - Fri), and you’ll receive a more detailed response to your email within 72 hours during the business week (Mon - Fri) indicating the next steps in handling your report.

* **Ensure the bug was not already reported** by searching on GitHub under [Issues.](https://github.com/salesagility/SuiteCRM/issues)

* If you're unable to find an open issue that relates to your problem, [open a new one.](https://github.com/salesagility/SuiteCRM/issues/new) Please be sure to follow the issue template as much as possible.

* **Ensure that the bug you are reporting is a core SuiteCRM issue** and not specific to your individual setup. For these types of issues please use the [Community Forum.](https://www.suitecrm.com/forum/suite-forum)

#### **Did you fix a bug?**

* To provide a code contribution for an issue you will need to set up your own fork of the SuiteCRM repository, make your code changes, commit the changes and make a Pull Request to the appropriate branch on the SuiteCM repository. See our [Quick Guide to Fork SuiteCRM.](https://suitecrm.com/wiki/index.php/Contributing_to_SuiteCRM#Quick_Guide_to_Fork_SuiteCRM) Once you have set up your forked repository you can begin making commits to the project.

* Determine which base branch your bug fix should use. If your bug is present in both hotfix and hotfix-7.8.x then use the hotfix-7.8.x branch. If however, your bug is specific to hotfix, then you can use the hotfix branch.

* Separate each issue fix into a new branch in your repository (Either from the hotfix-7.8.x or hotfix branch) and name it with the issue ID e.g. bugfix_3062 or issue-1234.

* When committing to your individual bugfix branch, please try and use the following as your commit message 
```Fixed #1234 - <the subject of the issue>```. E.g. ```Fixed #1436 - Reports with nested Parentheses are removing parameters```. By using this format we can easily include all bug fixes within major and minor release notes on our [Wiki](https://suitecrm.com/wiki/index.php/Main_Page).

* If you are new to Writing Commit Messages in git follow the guide [here](http://chris.beams.io/posts/git-commit/#seven-rules)

* After you have made your commits and pushed them up to your forked repository you then create a [Pull Request](https://help.github.com/articles/about-pull-requests/) to be reviewed and merged into the SuiteCRM repository. Make a new Pull Request for each issue you fix – do not combine multiple bugfixes into one Pull Request.
  Ensure that in your Pull Request that the base fork is salesagility/SuiteCRM and base branch is either hotfix or hotfix-7.8.x. and the head fork is your repository and the base branch is your unique bugfix branch e.g. bugfix_1234
  We will automatically reject any Pull Requests made to the wrong branch!

* If you have not signed our CLA [Contributor License Agreement](https://www.clahub.com/agreements/salesagility/SuiteCRM) then your pull request will fail a check and we will be unable to merge it into the project. You will only be required to sign this once.

* When a new Pull Request is opened, Travis CI will test the merging of the origin and upstream branch and update the Pull Request. If this check fails you can review the test results and resolve accordingly. To test prior to making a Pull Request install PHPUnit via composer into your develop environment then cd into the tests directory and run: ```$ sh runtests.sh```

* Ensure that you follow the pull request [template](https://github.com/salesagility/SuiteCRM/blob/master/.github/PULL_REQUEST_TEMPLATE.md) as much as possible.

#### **Did you create a new feature or enhancement?**

* Changes that can be considered a new feature or enhancement should be made to the develop branch instead of the hotfix or hotfix-7.8.x. branch.

* To contribute a feature to SuiteCRM, similar to providing a Bug Fix, you must create a forked repository of SuiteCRM and set up your git and development environment.
  Once done, create a new branch from **develop** and name it relevant to the feature's purpose e.g campaign-wizard-ui. Following our [Code Standards,](https://suitecrm.com/wiki/index.php/Coding_Standards) develop the new feature and ensure your forked repository is kept up to date with minor/major releases. See our [Quick Guide to Fork SuiteCRM.](https://suitecrm.com/wiki/index.php/Contributing_to_SuiteCRM#Quick_Guide_to_Fork_SuiteCRM) to update your repository.
  Make sure your commit messages are relevant and descriptive. When ready to submit for review make a Pull Request detailing your feature's functionality.
  Ensure that in your Pull Request that the base fork is **salesagility/SuiteCRM** and base branch is **develop** and the head fork is your repository and the base branch is your feature branch.
  Add any new PHPUnit tests to the new feature branch if required e.g new modules or classes.
  
  We will review the code and provide feedback within the Pull Request and issues relating to your feature. If the feature is to be included in the core product we will request for the forked repo to have an Issues tab so we can raise any bugs from our testing. This will also allow you to fix those issues using the below commit message format similar to how to submit bug fixes to the hotfix-7.8.x branch.
  ```$ git commit -m "Fixed #1436 - Reports with nested Parentheses are removing parameters"```. You can add an Issues tab to your forked repository via the 'Settings' tab.

### Issue and Pull Request Labels

* This section lists the labels we use to help us track and manage issues and pull requests across the SuiteCRM repositories.

* By using [GitHub search](https://help.github.com/articles/searching-issues/) you can use labels to help find issues and pull requests that you are interested in. If for example, you are interested in which PR's will be included in the next release of SuiteCRM, you can use the [open issues "Resolved: Next Release"](https://github.com/salesagility/SuiteCRM/issues?q=is%3Aopen+is%3Aissue+label%3A%22Resolved%3A+Next+Release%22) label.

* We encourage users whom feel an issue should be raised as a higher priority for a next release that they should make a comment to that affect. This also applies to incorrect labelling.

#### Types of Issue Labels

| Label name | `salesagility/SuiteCRM` | Description |
| --- | --- | --- |
| `bug` | [search][search-suitecrm-label-bug] | Confirmed or very likely to be a bug. |
| `Low Priority` | [search][search-suitecrm-label-Low-Priority] | Low impact (e.g. visual only, typos, alignments). |
| `Medium Priority` | [search][search-suitecrm-label-Medium-Priority] | Medium impact blocker with a workaround. |
| `High Priority` | [search][search-suitecrm-label-High-Priority] | A high impact blocker with no workaround. |
| `Fix Proposed` | [search][search-suitecrm-label-Fix-Proposed] | Issues with a related pull request. |
| `Pending Input` | [search][search-suitecrm-label-Pending-Input] | Pending input from issue raiser. |
| `language` | [search][search-suitecrm-label-language] | Issues relating to language files  |
| `suggestion` | [search][search-suitecrm-label-suggestion] | Suggestions that will later be moved to [Trello](https://trello.com/b/Ht7LbMqw/suitecrm-suggestion-box) |
| `question` | [search][search-suitecrm-label-question] | General questions (Should usually be posted to the community forum instead) |
| `Resolved: Next Release` | [search][search-suitecrm-label-Resolved:-Next-Release] | Solved issues that will be closed after the next release. |
| `invalid` | [search][search-suitecrm-label-invalid] | Issues that are invalid or non-reproducible. |
| `duplicate` | [search][search-suitecrm-label-duplicate] | Issues which are duplicates of other issues. |

#### Types of Pull Request Labels

| Label name | `salesagility/SuiteCRM` | Description |
| --- | --- | --- |
| `Assessed` | [search][search-suitecrm-label-Assessed] | Pull requests that have been confirmed to fix the original issue by a SalesAgility member. |
| `Ready to Merge` | [search][search-suitecrm-label-Ready-to-Merge] | Pull requests that have both been assessed and code reviewed by SalesAgility. |
| `In Review` | [search][search-suitecrm-label-In-Review] | Currently in-review and requires additional work from creator |
| `Wrong Branch` | [search][search-suitecrm-label-Wrong-Branch] | Pull requests that have been created to the wrong branch. |
| `duplicate` | [search][search-suitecrm-label-duplicate] | Duplicate of other pull requests. |

[search-suitecrm-label-bug]: https://github.com/salesagility/SuiteCRM/labels/bug
[search-suitecrm-label-Low-Priority]: https://github.com/salesagility/SuiteCRM/labels/Low%20Priority
[search-suitecrm-label-Medium-Priority]: https://github.com/salesagility/SuiteCRM/labels/Medium%20Priority
[search-suitecrm-label-High-Priority]: https://github.com/salesagility/SuiteCRM/labels/High%20Priority
[search-suitecrm-label-Fix-Proposed]: https://github.com/salesagility/SuiteCRM/labels/Fix%20Proposed
[search-suitecrm-label-Pending-Input]: https://github.com/salesagility/SuiteCRM/labels/Pending%20Input
[search-suitecrm-label-language]: https://github.com/salesagility/SuiteCRM/labels/language
[search-suitecrm-label-suggestion]: https://github.com/salesagility/SuiteCRM/labels/suggestion
[search-suitecrm-label-question]: https://github.com/salesagility/SuiteCRM/labels/question
[search-suitecrm-label-Resolved:-Next-Release]: https://github.com/salesagility/SuiteCRM/labels/Resolved%3A%20Next%20Release
[search-suitecrm-label-invalid]: https://github.com/salesagility/SuiteCRM/labels/invalid
[search-suitecrm-label-duplicate]: https://github.com/salesagility/SuiteCRM/labels/duplicate

[search-suitecrm-label-Assessed]: https://github.com/salesagility/SuiteCRM/pulls?q=is%3Aopen+is%3Apr+label%3AAssessed
[search-suitecrm-label-Ready-to-Merge]: https://github.com/salesagility/SuiteCRM/pulls?q=is%3Aopen+is%3Apr+label%3A%22Ready+to+Merge%22
[search-suitecrm-label-In-Review]: https://github.com/salesagility/SuiteCRM/pulls?q=is%3Aopen+is%3Apr+label%3A%22In+Review%22
[search-suitecrm-label-Wrong-Branch]: https://github.com/salesagility/SuiteCRM/pulls?q=is%3Aopen+is%3Apr+label%3A%22Wrong+Branch%22
[search-suitecrm-label-duplicate]: https://github.com/salesagility/SuiteCRM/pulls?q=is%3Aopen+is%3Apr+label%3Aduplicate

Thanks!

SuiteCRM Team
