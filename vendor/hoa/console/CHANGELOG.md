# 3.17.05.02

  * Tput: Deterministic order for `name` and `desc…`. (Ivan Enderlin, 2017-03-08T09:26:31+01:00)
  * CI: Set up Travis. (Ivan Enderlin, 2017-03-08T08:58:58+01:00)

# 3.17.01.11

  * Quality: Happy new year! (Alexis von Glasow, 2017-01-10T12:48:50+01:00)

# 3.16.11.08

  * Documentation: Add the “Learn more” link. (Ivan Enderlin, 2016-10-14T23:40:05+02:00)
  * Documentation: New `README.md` file. (Ivan Enderlin, 2016-10-14T23:29:22+02:00)
  * Documentation: Fix `docs` and `source` links. (Ivan Enderlin, 2016-10-05T20:28:46+02:00)
  * Documentation: Update `support` properties. (Ivan Enderlin, 2016-10-05T20:12:17+02:00)
  * Documentation: Use TLS on `central.hoa`. (Ivan Enderlin, 2016-09-09T14:59:03+02:00)

# 3.16.09.06

  * Documentation: Fix API documentation. (Alexis von Glasow, 2016-07-11T00:01:57+02:00)
  * Quality: Fix example CS in the `README.md`. (Ivan Enderlin, 2016-07-01T16:37:50+02:00)
  * Autocompleter: Force to work on a sub-line. (Ivan Enderlin, 2016-05-22T15:46:58+02:00)
  * Quality: Fix methods ordering. (Ivan Enderlin, 2016-02-24T07:28:41+01:00)
  * Implement `Hoa\Console\Output::getStream` which is now required by `Hoa\Stream\IStream\Out`. (Metalaka, 2015-11-01T20:15:43+01:00)
  * Fix phpDoc. (Metalaka, 2015-11-01T20:13:12+01:00)

# 3.16.01.14

  * Composer: New stable libraries. (Ivan Enderlin, 2016-01-14T21:45:35+01:00)

# 3.16.01.11

  * Quality: Drop PHP5.4. (Ivan Enderlin, 2016-01-11T09:15:26+01:00)
  * Quality: Run devtools:cs. (Ivan Enderlin, 2016-01-09T08:59:18+01:00)
  * Core: Remove `Hoa\Core`. (Ivan Enderlin, 2016-01-09T08:08:44+01:00)
  * Consistency: Update `registerShutdownFunction`. (Ivan Enderlin, 2015-12-09T06:58:00+01:00)
  * Consistency: Remove `from` calls. (Ivan Enderlin, 2015-12-09T06:35:35+01:00)
  * Consistency: Update `registerShutdownFunction`. (Ivan Enderlin, 2015-12-08T23:41:11+01:00)
  * Event: Remove `event` calls. (Ivan Enderlin, 2015-12-08T22:48:06+01:00)
  * Consistency: Use `Hoa\Consistency`. (Ivan Enderlin, 2015-12-08T11:01:36+01:00)
  * Event: Use `Hoa\Event`. (Ivan Enderlin, 2015-11-23T21:48:33+01:00)
  * Exception: Use `Hoa\Exception`. (Ivan Enderlin, 2015-11-20T07:17:38+01:00)
  * Test: Add specificity for Windows. (Ivan Enderlin, 2015-11-10T13:29:22+01:00)
  * Test: Write test suite for `…completer\Aggregate`. (Ivan Enderlin, 2015-11-10T08:45:10+01:00)
  * Test: Write test suite for `…e\Readline\Password`. (Ivan Enderlin, 2015-10-29T23:00:01+01:00)
  * Test: Use `beforeTestMethod` instead of `setUp`. (Ivan Enderlin, 2015-10-29T13:41:12+01:00)
  * Terminfo: Add the `xterm-256color` database. (Ivan Enderlin, 2015-10-29T13:40:30+01:00)
  * Test: Write test suite for `…Autocompleter\Path`. (Ivan Enderlin, 2015-10-29T08:46:04+01:00)
  * Test: Write test suite for `…Autocompleter\Word`. (Ivan Enderlin, 2015-10-29T08:10:47+01:00)
  * Readline: Use `Console::getInput`. (Ivan Enderlin, 2015-10-29T07:38:13+01:00)
  * Test: Write test suite for `Hoa\Console\GetOption`. (Ivan Enderlin, 2015-10-29T07:37:57+01:00)
  * GetOption: Reset the `$optionValue` all the time. (Ivan Enderlin, 2015-10-29T07:37:37+01:00)
  * CS: Clean namespaces and fix some styles. (Ivan Enderlin, 2015-10-28T07:56:40+01:00)
  * Test: Write test suite for `Hoa\Console\Mouse`. (Ivan Enderlin, 2015-10-28T07:54:38+01:00)
  * Mouse: Untrack when tracking fails. (Ivan Enderlin, 2015-10-28T07:52:48+01:00)
  * Mouse: New constants representing pointer codes. (Ivan Enderlin, 2015-10-28T07:50:50+01:00)
  * Test: Write test suite for `Hoa\Console\Window`. (Ivan Enderlin, 2015-10-27T10:12:44+01:00)
  * Window: The constructor must be private. (Ivan Enderlin, 2015-10-27T09:32:54+01:00)
  * Test: Write test suite for `Hoa\Console\Cursor`. (Ivan Enderlin, 2015-10-26T13:37:53+01:00)
  * Test: Write test suite for `Hoa\Console\Tput`. (Ivan Enderlin, 2015-10-26T13:37:33+01:00)
  * Test: Write test suite for `Hoa\Console\Parser`. (Ivan Enderlin, 2015-10-26T13:37:13+01:00)
  * Test: Write test suite for `Hoa\Console`. (Ivan Enderlin, 2015-10-26T13:36:42+01:00)
  * Console: Add the `setTput` static method. (Ivan Enderlin, 2015-10-26T13:34:37+01:00)
  * Console: Ensure `STDIN` is defined before using it. (Ivan Enderlin, 2015-10-26T13:34:02+01:00)
  * Tput: If no terminfo found, fallback to `xterm`. (Ivan Enderlin, 2015-10-28T14:07:18+01:00)
  * Tput: Check that `TERM` is set **and** not empty. (Ivan Enderlin, 2015-10-28T14:06:36+01:00)
  * Update API documentation. (Ivan Enderlin, 2015-10-26T08:39:15+01:00)
  * Console: Solve `stty -f` vs. `stty -F` issue. (Ivan Enderlin, 2015-10-22T09:29:42+02:00)
  * Input: Add the `getStream` method. (Ivan Enderlin, 2015-10-22T08:34:02+02:00)
  * Test the `Input` class. (Ivan Enderlin, 2015-10-21T17:04:52+02:00)
  * Create the `Input` interface. (Ivan Enderlin, 2015-09-24T07:44:50+02:00)
  * `stty` uses `/dev/tty` instead of the std. input. (Ivan Enderlin, 2015-09-24T07:16:48+02:00)
  * Advanced interaction can be forced. (Ivan Enderlin, 2015-09-24T07:15:26+02:00)
  * Fix, doc. (Metalaka, 2015-10-20T21:58:00+02:00)
  * Improve Output behavior. (Metalaka, 2015-10-20T13:24:48+02:00)
  * Test the `Output` classes. (Ivan Enderlin, 2015-10-14T16:49:53+02:00)
  * Arrays are “var exported” on the output. (Ivan Enderlin, 2015-10-14T07:54:29+02:00)
  * `Window` uses `Output` & multiplexer support. (Ivan Enderlin, 2015-10-14T07:41:33+02:00)
  * Consider multiplexer while writing on the output. (Ivan Enderlin, 2015-10-14T07:37:29+02:00)
  * Use `Hoa\Console::getOutput` when possible. (Ivan Enderlin, 2015-09-30T17:23:28+02:00)
  * Introduce the `Output` object. (Ivan Enderlin, 2015-09-30T16:53:13+02:00)
  * Format API documentation. (Ivan Enderlin, 2015-09-30T16:53:08+02:00)
  * Update API documentation. (Ivan Enderlin, 2015-09-30T16:48:30+02:00)
  * Add TMUX(1) support for `Window::copy`. (Ivan Enderlin, 2015-09-30T09:36:38+02:00)
  * Add the `Console::isTmuxRunning` method. (Ivan Enderlin, 2015-09-30T09:29:16+02:00)
  * Add a `.gitignore` file. (Stéphane HULARD, 2015-08-03T11:23:22+02:00)

# 2.15.07.27

  * Bip when an “invalid” character is pressed. (Ivan Enderlin, 2015-07-27T08:30:51+02:00)
  * Print character only if printable. (Ivan Enderlin, 2015-07-27T08:23:01+02:00)
  * Optimize the `_readline` control flow graph. (Ivan Enderlin, 2015-07-27T08:20:50+02:00)

# 2.15.07.23

  * More detailed API documentation. (Ivan Enderlin, 2015-07-16T08:12:43+02:00)
  * Update the API documentation. (Ivan Enderlin, 2015-07-16T07:47:55+02:00)
  * Fix phpDoc. (Metalaka, 2015-07-15T18:01:57+02:00)

# 2.15.05.29

  * Move to `Hoa\Ustring`. (Ivan Enderlin, 2015-05-29T14:50:28+02:00)
  * Move to PSR-1 and PSR-2. (Ivan Enderlin, 2015-05-13T10:30:22+02:00)

# 2.15.03.19

  * Add timeouts on `Window::getTitle` and `Window::getLabel` for tmux. (Ivan Enderlin, 2015-03-19T09:46:00+01:00)

# 2.15.03.06

  * Fix a bug in the ambiguity resolver. (Ivan Enderlin, 2015-03-06T10:48:55+01:00)

# 2.15.02.18

  * Add the CHANGELOG.md file. (Ivan Enderlin, 2015-02-18T08:59:24+01:00)
  * Use `Hoa\Dispatcher\ClassMethod` dispatcher in the documentation. (Ivan Enderlin, 2015-02-11T10:49:19+01:00)
  * Fix a CS. (Ivan Enderlin, 2015-02-10T17:03:09+01:00)
  * Fix links in the documentation. (Ivan Enderlin, 2015-01-23T19:23:57+01:00)
  * Happy new year! (Ivan Enderlin, 2015-01-05T14:21:41+01:00)

# 2.15.01.04

  * Inverse `$x` and `$y` in `Cursor::moveTo`. (Ivan Enderlin, 2015-01-04T15:10:08+01:00)
  * Allows to specify the term in `Tput::getTerminfo`. (Ivan Enderlin, 2015-01-04T15:08:59+01:00)
  * Remove `from`/`import` and update to PHP5.4. (Ivan Enderlin, 2015-01-04T15:03:40+01:00)

# 2.14.12.10

  * Move to PSR-4. (Ivan Enderlin, 2014-12-09T13:41:35+01:00)

# 2.14.11.26

  * Format the `composer.json` file. (Ivan Enderlin, 2014-11-25T14:15:31+01:00)
  * Require `hoa/test`. (Alexis von Glasow, 2014-11-25T13:49:37+01:00)

# 2.14.11.09

  * Add links around `hoa://` in the documentation. (Ivan Enderlin, 2014-09-26T10:37:52+02:00)

# 2.14.09.23

  * Format code. #mania (Ivan Enderlin, 2014-09-23T16:17:08+02:00)
  * Add `branch-alias`. (Stéphane PY, 2014-09-23T11:55:58+02:00)

# 2.14.09.17

  * Drop PHP5.3. (Ivan Enderlin, 2014-09-17T17:23:29+02:00)
  * Add the installation section. (Ivan Enderlin, 2014-09-17T17:23:10+02:00)

(first snapshot)
