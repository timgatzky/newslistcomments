
/**
 * Class 
 * NewslistComments
 */
var NewslistComments = 
{
	/**
	 * Load news entries via ajax
	 * @param object
	 * @param integer
	 * @return boolean
	 */
	load: function(el, newsID)
	{
		var objRequest = new Request({
			'url':window.location.href,
			'followRedirects':false,
			onSuccess : function(html)
			{
				document.body.set('html',html);
			}
		});	
		objRequest.post({'cmd_loadNews':newsID,'ajax':1});
		return false;
	},
	remove: function(el, commentID, newsID)
	{
		var objRequest = new Request({
			'url':window.location.href,
			'followRedirects':false,
			onSuccess : function(html)
			{
				document.body.set('html',html);
			}
		});	
		objRequest.post({'cmd_remove_comment':commentID,'parent':newsID,'ajax':1});
		return false;
	},
	
	/**
	 * Set focus on comments input field
	 * @param object
	 */
	setFocus: function(el)
	{
		var input = el.getParent('.comments').getElement('input[name=NEW_COMMENT]');
		input.focus();
	}
}