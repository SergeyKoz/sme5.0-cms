/**
 * $Id: tinymce.js,v 1.2 2010/11/29 09:34:26 skozin Exp $
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2008, Moxiecode Systems AB, All rights reserved.
 */

(function($){
	var w, ed, wm, args = {};

	window.focus();

//	try {
		w = opener || parent;

		// Check mcFileManager
		if (w.mcImageManager)
			args = w.mcImageManager.windowArgs;

		// Check TinyMCE
		if (w.tinyMCE && (ed = w.tinyMCE.activeEditor)) {
			if (ed && (wm = ed.windowManager)) {
				if (wm.params)
					args = wm.params;

				if (wm.setTitle)
					wm.setTitle(window, document.title);
			}
		}
/*	} catch (ex) {
	}*/

	if (!$.CurrentWindowManager) {
		// Add default window and add some methods to it
		$.WindowManager.defaultWin = {
			getArgs : function() {
				return args;
			},

			close : function() {
				// Restore selection
				if (ed && wm.bookmark)
					ed.selection.moveToBookmark(wm.bookmark);

				if (wm)
					wm.close(window);
				else
					window.close();
			}
		};
	}
})(jQuery);
