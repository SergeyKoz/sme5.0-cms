/**
 * $Id: domain.js,v 1.2 2010/11/29 09:34:26 skozin Exp $
 *
 * @author Moxiecode
 * @copyright Copyright � 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

(function(){
	try {
		var li = document.location.search.replace(/\?/, '').split('&'), query = {}, i;

		for (i = 0; i < li.length; i++) {
			it = li[i].split('=');
			query[unescape(it[0])] = unescape(it[1]);
		}

		if (query.domain)
			document.domain = query.domain;
	} catch (ex) {
		// Ignore
	}
})();
