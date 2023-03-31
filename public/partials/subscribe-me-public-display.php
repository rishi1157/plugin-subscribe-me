<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://rishabh.com
 * @since      1.0.0
 *
 * @package    Subscribe_Me
 * @subpackage Subscribe_Me/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <form class="subscribe-form" method="post">
        <input type="hidden" name="action" value="subscribe_form">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required/><br>
        <input type="submit" name="submit" id="subscribe-button" value="Subscribe Me" />
    </form>
</div>