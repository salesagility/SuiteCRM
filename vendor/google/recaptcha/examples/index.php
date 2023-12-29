<?php
/**
 * BSD 3-Clause License
 * @copyright (c) 2019, Google Inc.
 * @link https://www.google.com/recaptcha
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright notice, this
 *    list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its
 *    contributors may be used to endorse or promote products derived from
 *    this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

require __DIR__ . '/appengine-https.php';
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,minimum-scale=1">
<link rel="shortcut icon" href="https://www.gstatic.com/recaptcha/admin/favicon.ico" type="image/x-icon"/>
<link rel="canonical" href="https://recaptcha-demo.appspot.com/">
<script type="application/ld+json">{ "@context": "http://schema.org", "@type": "WebSite", "name": "reCAPTCHA demo", "url": "http://recaptcha-demo.appspot.com/" }</script>
<meta name="description" content="reCAPTCHA demo" />
<meta property="og:url" content="https://recaptcha-demo.appspot.com/" />
<meta property="og:type" content="website" />
<meta property="og:title" content="reCAPTCHA demo" />
<meta property="og:description" content="Examples of the reCAPTCHA client." />
<link rel="stylesheet" type="text/css" href="/examples.css">
<title>reCAPTCHA demo</title>

<header>
  <h1>reCAPTCHA demo</h1>
</header>
<main>
  <p>Try out the various forms of <a href="https://www.google.com/recaptcha/">reCAPTCHA</a>.</p>
  <p>You can find the source code for these examples on GitHub in <kbd><a href="https://github.com/google/recaptcha">google/recaptcha</a></kbd>.</p>
  <ul>
    <li><h2>reCAPTCHA v2</h2>
    <ul>
      <li><a href="/recaptcha-v2-checkbox.php">"I'm not a robot" checkbox</a></li>
      <li><a href="/recaptcha-v2-checkbox-explicit.php">"I'm not a robot" checkbox - Explicit render</a></li>
      <li><a href="/recaptcha-v2-invisible.php">Invisible</a></li>
    </ul>
    </li>
    <li><h2>reCAPTCHA v3</h2>
    <ul>
      <li><a href="/recaptcha-v3-request-scores.php">Request scores</a></li>
    </ul>
    </li>
    <li><h2>General</h2>
    <ul>
      <li><a href="/recaptcha-content-security-policy.php">Content Security Policy</a></li>
    </ul>
    </li>
  </ul>
</main>

<!-- Google Analytics - just ignore this -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123057962-1"></script>
<script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-123057962-1');</script>
