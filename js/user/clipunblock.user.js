// ==UserScript==
// @name			Clipboard Operation Unblocker
// @version			1.0.0
// @namespace		http://github.com/rogwilco
// @author			Nick Williams <rogwilco@gmail.com>
// @description		Prevents websites from interfering with clipboardr
//					operations (cut/copy/paste).
//
// @include			http://*.i-doxs.net/*
// @include			https://*.i-doxs.net/*
//
// @require			http://code.jquery.com/jquery-1.8.0.min.js
// ==/UserScript==

(function() {
	$('input').removeAttr('onCut');
	$('input').removeAttr('onCopy');
	$('input').removeAttr('onPaste');
})();