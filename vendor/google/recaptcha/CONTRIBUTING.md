# Contributing

Want to contribute? Great! First, read this page (including the small print at
the end).

## Contributor License Agreement

Before we can use your code, you must sign the [Google Individual Contributor
License
Agreement](https://developers.google.com/open-source/cla/individual?csw=1)
(CLA), which you can do online. The CLA is necessary mainly because you own the
copyright to your changes, even after your contribution becomes part of our
codebase, so we need your permission to use and distribute your code. We also
need to be sure of various other things—for instance that you'll tell us if you
know that your code infringes on other people's patents. You don't have to sign
the CLA until after you've submitted your code for review (a link will be
automatically added to your Pull Request) and a member has approved it, but you
must do it before we can put your code into our codebase. Before you start
working on a larger contribution, you should get in touch with us first through
the issue tracker with your idea so that we can help out and possibly guide you.
Coordinating up front makes it much easier to avoid frustration later on.

## Linting and testing

We use PHP Coding Standards Fixer to maintain coding standards and PHPUnit to
run our tests. For convenience, there are Composer scripts to run each of these:

```sh
composer run-script lint
composer run-script test
```

These are run automatically by [Travis
CI](https://travis-ci.org/google/recaptcha) against your Pull Request, but it's
a good idea to run them locally before submission to avoid getting things
bounced back. That said, tests can be a little daunting so feel free to submit
your PR and ask for help.

## Code reviews

All submissions, including submissions by project members, require review.
Reviews are conducted on the Pull Requests. The reviews are there to ensure and
improve code quality, so treat them like a discussion and opportunity to learn.
Don't get disheartened if your Pull Request isn't just automatically approved.

### The small print

Contributions made by corporations are covered by a different agreement than the
one above, the Software Grant and Corporate Contributor License Agreement.
